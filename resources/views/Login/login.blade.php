@extends('Login.index')
@section('title','Login')

@section('login')

    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper" style="background-color: transparent;">
        <div class="lockscreen-logo">
            <b>Monitoreo</b> ITC
        </div>
        <!-- User name -->
        <div class="lockscreen-name">Inicio de Sesión</div>
        <div class="lockscreen-item">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        <!-- lockscreen credentials (contains the form) -->
            {!! Form::open(['route'=>'Login.validate', 'method'=>'POST','files'=>'true','class'=>'lockscreen-name']) !!}
            <div class="input-group">
                {!! Form::text('usuario',null,['class'=>'form-control','placeholder'=>'usuario',''=>'']) !!}
                {!! Form::password('contrasena',array('class'=>'form-control','placeholder'=>'contraseña')) !!}

                <div class="input-group-btn">
                    {{ Form::button('<i class="fa fa-arrow-right text-muted"></i>',['type'=>'submit','class'=>'btn']) }}
                </div>
            </div>
        {!! Form::close()!!}
        <!-- /.lockscreen credentials -->
        </div>
        <!-- /.lockscreen-item -->
        <div class="text-center">
            <a href="/login/create">Crear una cuenta</a>
            <a href="/login/forgot">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
    <!-- /.center -->

@stop
