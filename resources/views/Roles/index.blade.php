@extends('Main.index')
@section('title','Roles')
@section('list')

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Roles
                <small><a class="" href="{{ route('rol.create')}}" >Agregar</a></small>
            </h1>

        </section>
        <div class="content">
            <section class="row">
                @foreach($rol as $role)
                    <div class="col-md-4 col-sm-10">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fa fa-user-secret"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{$role->descripcion}}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                            </div>
                            <div class="info-box-content">
                                <button class="btn bg-blue" style="width: 100px;">
                                    <a href="{{ route('rol.edit',['rol' => $role->id] )}}" style="color: white;">
                                        Editar
                                    </a>
                                </button>
                                <button class="btn bg-red" style="width: 100px;">
                                    <a href="{{ route('/rol/delete',['id' => $role->id] )}}" style="color: white;">
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
