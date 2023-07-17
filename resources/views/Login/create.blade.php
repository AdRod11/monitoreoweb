@extends('Login.index')
@section('title','Crear Cuenta')

@section('login')

    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper" style="background-color: transparent;">
        <div class="lockscreen-logo">
            <b>Monitoreo</b> ITC
        </div>
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
        <!-- User name -->
        <div class="lockscreen-name"><h1>Crear Cuenta</h1></div>
        <!-- lockscreen credentials (contains the form) -->
        {!! Form::open(['route'=>'Login.store', 'method'=>'POST','files'=>'true','class'=>'lockscreen-name']) !!}
            @include('Login.form')
        {!! Form::submit('Crear Cuenta',['class'=>'btn btn-primary']) !!}
        {!! Form::close()!!}
        <!-- /.lockscreen credentials -->
    </div>
    <!-- /.center -->

@stop
