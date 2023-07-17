
@extends('Main.index')

@section('title','Historico')

@section('list')
    <section class="content">
        <div class="box-body no-padding">
            <table id="historico" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th style="width: 1%;">Dispositivo</th>
                    <th style="width: 1%;">Servicio</th>
                    <th style="width: 10%;">IP</th>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 15%;">Estatus</th>
                    <th>Mensaje</th>
                </tr>
                </thead>
                <tbody>
                @foreach($historicos as $historico)
                    <tr>
                        <td>{{ $historico->dispositivo }}</td>
                        <td>{{ $historico->servicio }}</td>
                        <td>{{ $historico->ip }}</td>
                        <td>{{ date("Y-m-d H:i",strtotime($historico->fecha)) }}</td>
                        <td>
                            <div class="progress progress-xs progress-striped active" style="height: 20px;">
                                @if($historico->estatus == 'Correcto')
                                    <div class="progress-bar progress-bar-success" style="width: 50%;"><b>{{ $historico->estatus }}</b></div>
                                @endif
                                @if($historico->estatus == 'Advertencia')
                                    <div class="progress-bar progress-bar-warning" style="width: 50%;"><b>{{ $historico->estatus }}</b></div>
                                @endif
                                @if($historico->estatus == 'Desconocido')
                                    <div class="progress-bar progress-bar-yellow" style="width: 50%;"><b>{{ $historico->estatus }}</b></div>
                                @endif
                                @if($historico->estatus == 'Critico')
                                    <div class="progress-bar progress-bar-danger" style="width: 50%;"><b>{{ $historico->estatus }}</b></div>
                                @endif
                            </div>
                        </td>
                        <th>{{$historico->mensaje}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </section>
@stop
