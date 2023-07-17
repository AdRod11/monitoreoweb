@extends('Main.index')

@section('title','Grupos')

@section('list')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Grupos
            <small><a class="" href="{{ route('grupo.create')}}" >Agregar</a></small>

        </h1>
    </section>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            @foreach($groups as $group)
                <div class="col-md-4 col-sm-10">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">{{$group->descripcion}}</span>
                        </div>
                        <div class="info-box-content">
                            <button class="btn bg-blue" style="width: 100px;">
                                <a href="{{route ('grupo.edit',['grupo'=>$group->id])}}" style="color: white;">
                                    Editar
                                </a>
                            </button>
                            <button class="btn bg-red" style="width: 100px;">
                                <a href="{{route ('/grupo/delete',['id'=>$group->id])}}" style="color: white;">
                                    Borrar
                                </a>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /.row -->
    </section>
@stop
