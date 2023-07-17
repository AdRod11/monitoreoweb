@extends('Main.index')

@section('title','Crear Usuarios')

@section('list')

    <div class="content">
        <h2 class="page-header">Crear Usuario</h2>

        <div class="row">
            <div class="col-md-8">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    {!! Form::open(['route'=>'usuario.store', 'method'=>'POST','files'=>'true']) !!}

                    @include('Usuarios.form')

                    {!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>
    </div>

@stop
