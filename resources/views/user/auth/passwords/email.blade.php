@extends('user.layout.auth')

@section('content')

<?php $login_user = asset('asset/img/login-user-bg.jpg'); ?>
<div class="full-page-bg" style="background-image: url({{$login_user}});">
<div class="log-overlay"></div>
    <div class="full-page-bg-inner">
        <div class="columns no-margin">
            <div class="column log-left">
                <span class="login-logo"><img src="{{ config('constants.site_logo', asset('logo-black.png'))}}"></span>
                <h2>Crie sua conta e mova-se em minutos</h2>
                <p>Bem-vindo(a) ao {{ config('constants.site_title', 'Service Mario')  }}, a maneira mais fácil de se locomover com o toque de um botão.</p>
            </div>
            <div class="column log-right">
                <div class="login-box-outer">
                <div class="login-box columns no-margin">
                    <div class="column">
                        <a class="log-blk-btn" href="{{url('login')}}">JÁ TEM UMA CONTA?</a>
                        <h3>Redefinir Password</h3>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="column">
                            <input type="email" class="input" name="email" placeholder="Seu e-mail" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif                        
                        </div>

                        
                        <div class="column">
                            <button class="log-teal-btn" type="submit">ENVIAR LINK DE REDEFINIÇÃO</button>
                        </div>
                    </form>     

                    <div class="column">
                        <p class="helper">Ou <a href="{{route('login')}}">Entre</a> com sua conta de usuário.</p>   
                    </div>

                </div>


                <div class="log-copy"><p class="no-margin">{{ config('constants.site_copyright', '&copy; '.date('Y').' Service Mario') }}</p></div>
                </div>
            </div>
        </div>
    </div>
@endsection
