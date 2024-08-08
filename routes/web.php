<?php


use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {return view('welcome');});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/tarefa', 'App\Http\Controllers\TarefaController');

Route::get('/mensagem-teste', function(){
   // return new MensagemTesteMail();
   //Mail::to('')->send(new MensagemTesteMail());
   //return 'E-mail enviado com sucesso!';
});
