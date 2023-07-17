@extends('Main.index')
@section('title','Actualizar rol')
@section('list')

    <div class="content">
        <h2 class="page-header">Actualizar rol</h2>

        <div class="row">
            <div class="col-md-8">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    {!! Form::model($rol,['route'=>['rol.update',$rol->id], 'method'=>'PUT']) !!}

                    @include('Roles.form')

                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>

@stop
