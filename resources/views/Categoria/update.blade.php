@extends('Main.index')
@section('title','Actualizar sistemas')
@section('list')

    <div class="content">
        <h2 class="page-header">Actualizar catgeoria</h2>

        <div class="row">
            <div class="col-md-8">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    {!! Form::model($categoria,['route'=>['categoria.update',$categoria->id], 'method'=>'PUT']) !!}

                    @include('Categoria.form')

                    {!! Form::submit('Actualizar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->
        </div>

@stop
