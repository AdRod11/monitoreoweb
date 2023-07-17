@extends('Main.index')
@section('title','Monitoreo')
@section('list')
    <section class="content-header">
        <h1>
            {{ $dispositivo[0]->disNombre }}
        </h1>
        <br>
        <button class="btn bg-blue" style="width: 100px;"><a href="" style="color:white;"><i class="fa fa-rotate-right"></i>  <span>Actualizar</span></a></button>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <h3 class="box-title">Detalles</h3>
                    <div class="box-header with-border">
                        <p>Responsable:
                            <a data-toggle="modal" data-target="#responsableadd">Enviar Correo</a>
                        </p>
                        @foreach($responsables as $responsable)
                            <p>
                                <code>{{ $responsable->perNombre.' '.$responsable->perPaterno.' '.$responsable->perMaterno.' ('.$responsable->perCorreo.')'}}</code>
                            </p>
                        @endforeach
                        <p>
                            IP Address:
				<label id = "ipMonitoreo">{{$dispositivo[0]->disIp}} </label> 
                            <span class =''> <button type="button" id="pingMonitoreo" class ="btn bg-blue">Comprobar conexion</button> </span>
                        </p>
                        <p>Mac Address: <code>{{ $dispositivo[0]->disMac }}</code></p>
                        <p>Sistema Operativo: <code>{{ $dispositivo[0]->sisNombre.' ('.$dispositivo[0]->sisVersion.')' }}</code></p>
                        <p>Grupo: <code>{{ $dispositivo[0]->grpDescripcion }}</code></p>
                        <p>Ubicacion: <code>{{ $dispositivo[0]->ubiDescripcion.' - '.$dispositivo[0]->ubiLugar }}</code></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <h3 class="box-title">Servicios de Red</h3>
                    <div class="box-body">
                        @foreach($servicios_red as $servicio)
                            @if($servicio->id_estado == 1)
                                <div class="alert bg-red">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre.' - Critico' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                            @if($servicio->id_estado == 2)
                                <div class="alert bg-green">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre. ' - Correcto' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                            @if($servicio->id_estado == 3)
                                <div class="alert bg-blue">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre.' - Desconocido' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                            @if($servicio->id_estado == 4)
                                <div class="alert bg-yellow">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre.' - Advertencia' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <h3 class="box-title">Servicios de Hardware</h3>
                    <div class="box-body">
                        @foreach($servicios_hardware as $servicio)
                            @if($servicio->id_estado == 1)
                                <div class="alert bg-red">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre.' - Critico' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                              </div>
                            @endif
                            @if($servicio->id_estado == 2)
                                <div class="alert bg-green">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre. ' - Correcto' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                            @if($servicio->id_estado == 3)
                                <div class="alert bg-blue">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre.' - Desconocido' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                            @if($servicio->id_estado == 4)
                                <div class="alert bg-yellow">
                                    <h4><i class="icon fa fa-bar-chart"></i>{{ $servicio->nombre.' - Advertencia' }}</h4>
                                    <p>{{ $servicio->mensaje }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal fade" id="responsableadd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">Enviar Correo a:</h5>
                            <p>
                                @foreach($responsables as $responsable)
                                    {{ $responsable->perCorreo.';   ' }}
                                @endforeach
                            </p>
                        </div>
                        <div class="modal-body">
                            {!! Form::open([ 'route'=>["/monitoreo/correo",$dispositivo[0]->idDispositivo], 'method'=>'POST']) !!}
                            @include('Monitoreo.sendCorreo')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            {!! Form::submit('Enviar',['class'=>'btn btn-primary']) !!}
                            {!! Form::close()!!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
