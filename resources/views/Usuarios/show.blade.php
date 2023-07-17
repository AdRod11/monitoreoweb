    @extends('Main.index')

@section('title','Usuario')

@section('list')

    <section class="content-header">
        <h1>
            Estado del Usuario
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-widget widget-user">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="widget-user-header bg-blue">
                                <span class="info-box-icon bg-blue"><span class="glyphicon glyphicon-user"></span></span>
                                <h3 class="widget-user-username">{{$user[0]->usuario}}</h3>
                                <h5 class="widget-user-desc">{{$user[0]->nombre.' '.$user[0]->a_paterno.' '.$user[0]->a_materno}}</h5>
                                <h5 class="widget-user-desc">{{ $rol[0]->descripcion }} </h5>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Correo</h5>
                                    <span class="description-block">{{$user[0]->correo}}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Ultimo Acceso</h5>
                                    <span class="description-block">{{date("H:i Y/m/d",strtotime($user[0]->ultimo_acceso))}}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Estado</h5>
                                    <span class="description-block">{{$user[0]->estatus}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <button class="btn bg-blue" style="width: 150px;"><a href="{{route ('/usuario/edit',['usuario'=>$user[0]->id_usuario])}}" style="color:white;">Editar</a></button>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <nav class="nav navbar-nav">
                                        <div class="dropdown messages-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <button class="btn bg-blue" style="width: 450px;">Registro de Accesos</button>
                                            </a>
                                            <ul class="dropdown-menu" style="width: 450px;">
                                                <li class="header" >Usted tiene {{$no_registros}} registros.</li>
                                                <li>
                                                    <ul class="menu">
                                                        @foreach($bitacoras as $bitacora)
                                                            <li>
                                                                <a href="#">
                                                                    <div class="pull-left">
                                                                        <img src="{{ asset('dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
                                                                    </div>
                                                                    <h4>
                                                                        Fecha de Acceso
                                                                        <small>Sesion <i class="fa fa-clock-o"></i></small>
                                                                    </h4>
                                                                    <h5>{{ date("H:i Y-m-d",strtotime($bitacora->fecha_fin)) }}</h5>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    @if($_SESSION['permiso'] == 1 or $_SESSION['permiso'] == 2)
                                        <button class="btn bg-red" style="width: 150px;"><a href="{{route ('/usuario/editStatus',['id'=>$user[0]->id])}}" style="color: white;">Cambiar Estado</a></button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
