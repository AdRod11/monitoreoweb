@extends('Main.index')
@section('title','Informacion del dispositivo')
@section('list')

    <section class="content-header">
        <h1>
            Estado del dispositivo
        </h1>
    </section>
    <section class="content">
        <div class="row">
                <div class="col-md-11">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-blue">
                            <h3 class="widget-user-username">Nombre: {{$dispositivo->dispositivo_nombre}}</h3>
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
                                <h3 class="box-title">Servicios</h3>
                                @if($_SESSION['permiso'] == 1)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#servicio">
                                        <a style="color: white;"> Agregar</a>
                                    </button>
                                @endif
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        @if($_SESSION['permiso'] == 1)
                                            <th>Eliminar</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($servicios as $service)
                                        <tr>
                                            @if(!empty($service))
                                                <th>{{$service->servicio}}</th>
                                                <th>{{$service->estado}}</th>
                                                @if($_SESSION['permiso'] == 1)
                                                    <th><a class="btn btn-social-icon" href="{{ route('/dispositivo/servicio/delete',['id' => $service->id] )}}" ><i class ="fa fa-remove"></i></a></th>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        @if($_SESSION['permiso'] == 1)
                                            <th>Eliminar</th>
                                        @endif
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box box-default collapsed-box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Responsable</h3>
                                @if($_SESSION['permiso'] == 1)
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#responsableadd">
                                        <a style="color: white">Agregar</a>
                                    </button>
                                @endif
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="responsable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        @if($_SESSION['permiso'] == 1)
                                            <th>Eliminar</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($responsable as $res)
                                        <tr>
                                            <th>{{$res->nombre}} {{$res->a_paterno}} {{$res->a_materno}}</th>
                                            @if($_SESSION['permiso'] == 1)
                                                <th><a class="btn btn-social-icon" href="{{ route('/dispositivo/responsable/delete',['id' => $res->id] )}}" ><i class ="fa fa-remove"></i></a></th>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Nombre</th>
                                        @if($_SESSION['permiso'] == 1)
                                            <th>Eliminar</th>
                                        @endif
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <div class="box-footer no-padding align-items-center">
                            <ul class="nav nav-stacked  align-items-center">
                                <li>
                                    @if($_SESSION['permiso'] == 1)
                                        <button class="btn bg-blue" style="width: 100px;"><a href="{{route ('dispositivo.edit',['dispositivo'=>$dispositivo->id_dispositivo])}}" style="color:white;">Editar</a></button>
                                        <button class="btn bg-red" style="width: 100px;"><a href="{{route ('/dispositivo/delete',['id'=>$dispositivo->id_dispositivo])}}" style="color: white;">Borrar</a></button>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>
                <!-- /.col -->
        <!-- /.col -->
        </div>
    </section>
    <div class="modal fade" id="servicio" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregar nuevo servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open([ 'route'=>["/dispositivo/servicio",$dispositivo->id_dispositivo], 'method'=>'POST']) !!}

                    @include('Dispositivo.add_service')
                    <div>
                        <input id="descripcion" placeholder="Este servicio sirva para:" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="responsableadd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Agregar nuevo responsable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open([ 'route'=>["/dispositivo/responsable",$dispositivo->id_dispositivo], 'method'=>'POST']) !!}

                    @include('Dispositivo.responsable')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    {!! Form::submit('Guardar',['class'=>'btn btn-primary']) !!}
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@stop

