@extends('template.login.main')

@section('content')

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Inicio Sesion</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {!! csrf_field() !!}

            <div class="form-group has-feedback">
                <input id="nom_usua" type="text" class="form-control" name="nom_usua" value="{{ old('nom_usua') }}" required autofocus placeholder="Usuario">

                @if ($errors->has('nom_usua'))
                <span class="help-block">
                    <strong>{{ $errors->first('nom_usua') }}</strong>
                </span>
                @endif
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input id="con_usua" type="password" class="form-control" name="con_usua" required placeholder="Contraseña">

                @if ($errors->has('con_usua'))
                <span class="help-block">
                    <strong>{{ $errors->first('con_usua') }}</strong>
                </span>
                @endif 
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <br/>
        <a href="{{ route('password.request') }}">Olvide mi contraseña</a><br>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection
