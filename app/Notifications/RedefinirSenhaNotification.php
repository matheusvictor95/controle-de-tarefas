<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class RedefinirSenhaNotification extends Notification
{
    use Queueable;
    public $token;
    public $email;
    public $name;
    public function __construct($token, $email, $name)
    {
        $this->token = $token;
        $this->email = $email;
        $this->name = $name;
    }

    
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = 'http://localhost:8000/password/reset/'.$this->token.'?email='.$this->email;
        $minutos = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');
        $saudacao = 'Olá '. $this->name;
        return (new MailMessage)
        ->subject('Atualização de Senha')
        ->greeting($saudacao)
        ->line('Esqueceu a Senha? Sem problemas, vamos resolver isso!')
        ->action('clique aqui para modificar a senha', $url)
        ->line('O link acima expira em '.$minutos.'minutos')
        ->line('Caso você não tenha requisitado a alteração de senha, então nenhuma ação é necessária')
        ->salutation('Até breve!');
    }

   
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
