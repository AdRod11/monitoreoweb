@extends('Main.index')
@section('title','Tipo Servicios')
@section('list')

    <section class="content-header">
        <h1>
            Tipo Servicio
            <small><a class="" href="{{ route('tiposervicio.create')}}" >Agregar</a></small>
        </h1>
    </section>
    <div class="content">
        <section class="row">
            @foreach($tiposervicios as $service)
                <div class="col-md-4 col-sm-10">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><span class="fa fa-list-ul"></span></span>
                        <div class="info-box-content">
                            <span class="info-box-number">{{ $service->descripcion }}</span>

                        </div>
                        <div class="info-box-content">
                            <button class="btn bg-blue" style="width: 100px;"><a href="{{ route('tiposervicio.edit',['tiposervicio' => $service->id] )}}" style="color:white;">Editar</a></button>
                            <button class="btn bg-red" style="width: 100px;"><a href="{{ route('/tiposervicio/delete',['id' => $service->id] )}}" style="color: white;">Borrar</a></button>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    </div>
@stop
