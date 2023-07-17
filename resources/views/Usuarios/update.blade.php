@extends('Main.index')

@section('title','Actualizacion Usuarios')

@section('list')

    <div class="content">
        <h2 class="page-header">Actualizar Usuario</h2>

        <div class="row">
            <div class="col-md-8">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    {!! Form::model($usuario,['route'=>['usuario.update',$usuario->id], 'method'=>'PUT','files'=>'true']) !!}

                    @include('Usuarios.form')

                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>
    </div>

@stop
