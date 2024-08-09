<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerificarEmailNotification extends Notification
{
    
    public static $createUrlCallback;
    public static $toMailCallback;

    public $name;

   
    public function __construct($name){
        $this->name = $name;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

  
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

   
    protected function buildMailMessage($url)
    {
        $saudacao = 'Olá '. $this->name;
        return (new MailMessage)
            ->subject('Confirmação de E-mail')
            ->greeting($saudacao)
            ->line('Por favor clique no botão abaixo para validar o seu e-mail')
            ->action(Lang::get('clique aqui para validar o seu e-mail'), $url)
            ->line('Caso você não tenha se cadastrado no nosso sistema apenas desconsidere esta mensagem!');
    }

  
    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

 
    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
