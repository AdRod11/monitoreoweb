@extends('Main.index')

@section('title','Usuarios')

@section('list')
    <section class="content-header">
        <h1>
            Usuarios
            <small>
                <a href="{{route ('usuario.create')}}">Crear Nuevo</a>
            </small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#fa-icons" data-toggle="tab">Activos</a></li>
                        <li><a href="#glyphicons" data-toggle="tab">In Activos</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="fa-icons">
                        <section id="new">
                            @foreach($usersActives as $user)
                                <div class="col-md-4">
                                    <div class="box box-widget widget-user-2">
                                        <div class="widget-user-header bg-blue">
                                            <div class="widget-user-image">
                                                <span class="info-box-icon bg-blue"><span class="glyphicon glyphicon-user"></span></span>
                                            </div>
                                            <h3 class="widget-user-username">{{$user->nombre}}</h3>
                                            <h3 class="widget-user-username">{{$user->a_paterno.' '.$user->a_materno}}</h3>
                                            <h5 class="widget-user-desc">{{$user->descripcion}}</h5>
                                        </div>
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <li><a>Correo <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->correo}}</span></a></li>
                                                <li><a>Curp <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->curp}}</span></a></li>
                                                <li><a>Telefono <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->telefono}}</span></a></li>
                                                <li><a>Domicilio <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->domicilio}}</span></a></li>
                                                <li>
                                                    <button class="btn bg-blue" style="width: 100px;"><a href="{{route('usuario.show',['usuario'=>$user->id])}}" style="color: white;">Info. Usuario</a></button>
                                                    <button class="btn bg-blue" style="width: 100px;"><a href="{{route ('usuario.edit',['usuario'=>$user->id])}}" style="color:white;">Editar</a></button>
                                                    <button class="btn bg-red" style="width: 100px;"><a href="{{route ('/usuario/delete',['id'=>$user->id])}}" style="color: white;">Borrar</a></button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>
                    </div>
                    <div class="tab-pane" id="glyphicons">
                        <section id="new">
                            @foreach($usersInActives as $user)
                                <div class="col-md-4">
                                    <div class="box box-widget widget-user-2">
                                        <div class="widget-user-header bg-blue">
                                            <div class="widget-user-image">
                                                <span class="info-box-icon bg-blue"><span class="glyphicon glyphicon-user"></span></span>
                                            </div>
                                            <h3 class="widget-user-username">{{$user->nombre}}</h3>
                                            <h3 class="widget-user-username">{{$user->a_paterno.' '.$user->a_materno}}</h3>
                                            <h5 class="widget-user-desc">{{$user->descripcion}}</h5>
                                        </div>
                                        <div class="box-footer no-padding">
                                            <ul class="nav nav-stacked">
                                                <li><a href="#">Apellido(s) <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->a_paterno}} {{$user->a_materno}}</span></a></li>
                                                <li><a href="#">Correo <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->correo}}</span></a></li>
                                                <li><a href="#">Curp <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->curp}}</span></a></li>
                                                <li><a href="#">Telefono <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->telefono}}</span></a></li>
                                                <li><a href="#">Domicilio <span class="pull-right badge bg-blue" style="width: 200px;">{{$user->domicilio}}</span></a></li>
                                                <li>
                                                    <button class="btn bg-blue" style="width: 100px;"><a href="{{route('usuario.show',['usuario'=>$user->id])}}" style="color: white;">Info. Usuario</a></button>
                                                    <button class="btn bg-blue" style="width: 100px;"><a href="{{route ('usuario.edit',['usuario'=>$user->id])}}" style="color:white;">Editar</a></button>
                                                    <button class="btn bg-red" style="width: 100px;"><a href="{{route ('/usuario/delete',['id'=>$user->id])}}" style="color: white;">Borrar</a></button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- /.widget-user -->
                                </div>
                            @endforeach
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
