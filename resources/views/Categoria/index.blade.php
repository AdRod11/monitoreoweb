@extends('Main.index')
@section('title','Categorias')
@section('list')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Categorias
                <small><a class="" href="{{ route('categoria.create')}}" >Agregar</a></small>

            </h1>

        </section>
        <div class="content">
            <section class="row">
                @foreach($categoria as $categoria)
                    <div class="col-md-4 col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa fa-cubes"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{$categoria->descripcion}}</span>
                            </div>
                            <div class="info-box-content">
                                <button class="btn bg-blue" style="width: 100px;">
                                    <a href="{{ route('categoria.edit',['categorium' => $categoria->id] )}}" style="color: white;">
                                        Editar
                                    </a>
                                </button>
                                <button class="btn bg-red" style="width: 100px;">
                                    <a href="{{ route('/categoria/delete',['id' => $categoria->id] )}}" style="color: white;">
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
