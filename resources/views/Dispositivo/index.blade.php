@extends('Main.index')
@section('title','Dispositivos')
@section('list')

    <section class="content-header">
        <h1>
            Dispositivos
            <small>
                @if($_SESSION['permiso'] == 1)
                    <a href="{{route ('dispositivo.create')}}" style="color: #0a568c;">Crear Nuevo</a>
                @endif
            </small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @foreach($dispositivo as $dispositivo)
                    <div class="col-md-4">
                        <div class="box box-widget widget-user-2">
                            <div class="widget-user-header bg-blue">
                                <div class="widget-user-image">
                                    <span class="info-box-icon bg-blue"><span class="glyphicon glyphicon-hdd"></span></span>
                                </div>
                                <h3 class="widget-user-username">{{$dispositivo->dispositivo_nombre}}</h3>
                                <h5 class="widget-user-desc">IP: {{$dispositivo->ip}}</h5>
                                <h5 class="widget-user-desc">MAC: {{$dispositivo->mac}}</h5>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a>SO: <span class="pull-right badge bg-blue" style="width: 200px;">{{$dispositivo->sistema_nombre}}</span></a></li>
                                    <li><a>Grupo: <span class="pull-right badge bg-blue" style="width: 200px;">{{$dispositivo->grupo_nombre}}</span></a></li>
                                    <li><a>Ubicación: <span class="pull-right badge bg-blue" style="width: 200px;">{{$dispositivo->ubicacion_nombre}}</span></a></li>
                                    <li><a>Categoria: <span class="pull-right badge bg-blue" style="width: 200px;">{{$dispositivo->categoria_nombre}}</span></a></li>
                                    <li><a>Periodo: <span class="pull-right badge bg-blue" style="width: 200px;">{{$dispositivo->periodo}}</span></a></li>
                                </ul>
                            </div>
                            <div class="box box-default collapsed-box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Responsable</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    @foreach($responsable as $res)
                                        @if($res->id_dispositivo == $dispositivo->id_dispositivo)
                                            <li>{{$res->nombre}} {{$res->a_paterno}} {{$res->a_materno}}</li>
                                            @endif
                                    @endforeach
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <div class="box-footer no-padding align-items-center">
                                <ul class="nav nav-stacked  align-items-center">
                                    <li>
                                        <button class="btn bg-blue" style="width: 100px;"><a href="{{route('dispositivo.show',['dispositivo'=>$dispositivo->id_dispositivo])}}" style="color: white;">Detalles</a></button>
                                        @if($_SESSION['permiso'] == 1)
                                            <button class="btn bg-blue" style="width: 100px;"><a href="{{route ('dispositivo.edit',['dispositivo'=>$dispositivo->id_dispositivo])}}" style="color:white;">Editar</a></button>
                                            <button class="btn bg-red" style="width: 100px;"><a href="{{route ('/dispositivo/delete',['id'=>$dispositivo->id_dispositivo])}}" style="color: white;">Borrar</a></button>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@stop
