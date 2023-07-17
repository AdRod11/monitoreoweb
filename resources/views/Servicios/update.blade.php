@extends('Main.index')
@section('title','Actualizar servicio')
@section('list')

    <div class="content">
        <h2 class="page-header">Crear Usuario</h2>

        <div class="row">
            <div class="col-md-8">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    {!! Form::model($servicio,['route'=>['servicio.update',$servicio->id], 'method'=>'PUT']) !!}

                    @include('Servicios.form')

                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>

@stop
