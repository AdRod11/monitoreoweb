@extends('Main.index')
@section('title','Estados')
@section('list')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Estados
                <small><a class="" href="{{ route('estado.create')}}" >Agregar</a></small>
            </h1>

        </section>

        <!-- Main content -->
        <div class="content">
            <section class="row">
                @foreach($estado as $estado)
                    <div class="col-md-4 col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa fa-check-square"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{$estado->descripcion}}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <div class="info-box-content">
                                <button class="btn bg-blue" style="width: 100px;">
                                    <a href="{{ route('estado.edit',['estado' => $estado->id] )}}" style="color: white;">
                                        Editar
                                    </a>
                                </button>
                                <button class="btn bg-red" style="width: 100px;">
                                    <a href="{{ route('/estado/delete',['id' => $estado->id] )}}" style="color: white;">
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
