@extends('Main.index')
@section('title','Servicios')
@section('list')

        <section class="content-header">
            <h1>
                Servicios
                <small><a class="" href="{{ route('servicio.create')}}" >Agregar</a></small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicio as $service)
                                        <tr>
                                            <th>
                                                <div class="col-md-8 col-sm-10">
                                                    <div class="info-box">
                                                        <span class="info-box-icon bg-blue"><span class="fa fa-book"></span></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-number">{{ $service->nombre }}</span>
                                                            <span class="info-box-text">{{ $service->descripcion }}</span>

                                                            <button class="btn bg-blue" style="width: 100px;"><a href="{{ route('servicio.edit',['servicio' => $service->id] )}}" style="color:white;">Editar</a></button>
                                                            <button class="btn bg-red" style="width: 100px;"><a href="{{ route('/servicio/delete',['id' => $service->id] )}}" style="color: white;">Borrar</a></button>
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
@stop
