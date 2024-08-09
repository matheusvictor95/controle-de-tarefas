@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Falta pouco agora! Precisamos apenas que você valide o seu e-mail</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Enviamos um e-mail para você com o link de validação.
                        </div>
                    @endif

                    {{ __('Antes de Continuarmos, por favor verifique seu e-mail e valide o seu cadastro em nossa plataforma.') }}
                    {{ __('Se você não recebeu o e-mail de validação clique aqui ou verifique a caixa de SPAM do seu E-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('clique aqui pra reenviar outro email de validação') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
