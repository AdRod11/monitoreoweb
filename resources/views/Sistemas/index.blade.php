@extends('Main.index')
@section('title','Sistemas')
@section('list')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Sistemas
                <small><a class="" href="{{ route('sistema.create')}}" >Agregar</a></small>
            </h1>

        </section>
        <div class="content">
            <section class="row">
                @foreach($sistema as $system)
                    <div class="col-md-4 col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa fa-linux"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{$system->nombre}}</span>
                                <span class="info-box-text">version {{$system->version}}</span>
                            </div>
                            <div class="info-box-content">
                                <button class="btn bg-blue" style="width: 100px;">
                                    <a href="{{ route('sistema.edit',['sistema' => $system->id] )}}" style="color: white;">
                                        Editar
                                    </a>
                                </button>
                                <button class="btn bg-red" style="width: 100px;">
                                    <a href="{{ route('/sistema/delete',['id' => $system->id] )}}" style="color: white;">
                                        Borrar
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
            <!-- /.row -->
        </div>
@stop
