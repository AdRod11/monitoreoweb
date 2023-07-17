@extends('Main.index')

@section('title','Actualizacion Usuarios')

@section('list')

    <div class="content">
        <h2 class="page-header">Actualizar Información de {{$infoUsuario[0]->usuario}}</h2>
        <div class="row">
            <div class="col-md-8">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    {!! Form::open(['route'=>['/usuario/update',$usuario_id], 'method'=>'PUT','files'=>'true']) !!}

                    <div class="form-group">
                        {!! Form::label('correo','Correo') !!}
                        {!! Form::text('correo',$infoUsuario[0]->correo,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('rol','Rol') !!}
                        {!! Form::select('rol', $roles, $rol[0]->id,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('contrasena','Contraseña') !!}
                        {!! Form::password('contrasena',array('class'=>'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('contrasena_confirmar','Confirmar Contraseña') !!}
                        {!! Form::password('contrasena_confirmar',array('class'=>'form-control')) !!}
                    </div>

                    {!! Form::hidden('usuario_id',$usuario_id) !!}

                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>
    </div>

@stop
