@extends('Login.index')
@section('title','Correo')

@section('login')

    <!-- Automatic element centering -->
    <div class="lockscreen-wrapper" style="background-color: transparent;">
        <div class="lockscreen-logo">
            <b>Monitoreo</b> ITC
        </div>
        <!-- User name -->
        <div class="lockscreen-name">Enviar correo electronico</div>
        <div class="lockscreen-item">
            <!-- lockscreen credentials (contains the form) -->
            {!! Form::open(['route'=>'Login.sendEmail', 'method'=>'POST','files'=>'true','class'=>'lockscreen-name']) !!}
            <div class="input-group">
                {!! Form::text('correo',null,['class'=>'form-control','placeholder'=>'usuario',''=>'']) !!}

                <div class="input-group-btn">
                    {{ Form::button('<i class="fa fa-arrow-right text-muted"></i>',['type'=>'submit','class'=>'btn']) }}
                </div>
            </div>
        {!! Form::close()!!}
        <!-- /.lockscreen credentials -->
        </div>
        <!-- /.lockscreen-item -->
    </div>
    <!-- /.center -->

@stop
