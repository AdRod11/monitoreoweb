@extends('Main.index')
@section('title','Ubicaciones')
@section('list')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Ubicación
                <small><a class="" href="{{ route('ubicacion.create')}}" >Agregar</a></small>

            </h1>

        </section>

        <!-- Main content -->
        <div class="content">
            <section class="row">
                 @foreach($ubicacion as $ubication)
                    <div class="col-md-4 col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa fa-map-marker"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{$ubication->descripcion}}</span>
                                <span class="info-box-text">{{$ubication->lugar}}</span>
                            </div>
                            <div class="info-box-content">
                                <button class="btn bg-blue" style="width: 100px;">
                                    <a href="{{ route('ubicacion.edit',['ubicacion' => $ubication->id] )}}" style="color: white;">
                                        Editar
                                    </a>
                                </button>
                                <button class="btn bg-red" style="width: 100px;">
                                    <a href="{{ route('/ubicacion/delete',['id' => $ubication->id] )}}" style="color: white;">
                                        Borrar
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                 @endforeach
            </section>
        </div>
@stop
