@extends('Main.index')
@section('title','Monitoreo')
@section('list')
    <section class="content-header">
        <h1>Monitoreo de Dispositivos</h1>
    </section>
    <section class="content">
        <div class="row">
            @foreach($dispositivos as $dispositivo)
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <a href="{{route('monitoreo.show',['dispositivo'=>$dispositivo->id])}}">
                            <span class="info-box-icon bg-blue"><span class="glyphicon glyphicon-hdd"></span></span>
                            <div class="info-box-content">
                                <span class="info-box-number">{{ $dispositivo->nombre }}</span>
                                <span class="info-box-text">{{ $dispositivo->ip }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@stop

@section('script')
<script>
    $(function () {
        var bar_data = {
            data : [
                @foreach($dispositivos as $dispositivo)
                    ['{{$dispositivo->nombre}}',100],
                @endforeach
            ]
            ,
            color: '#3c8dbc'
        }
        $.plot('#bar-chart', [bar_data], {
            grid  : {
                borderWidth: 1,
                borderColor: '#f3f3f3',
                tickColor  : '#f3f3f3'
            },
            series: {
                bars: {
                    show    : true,
                    barWidth: 0.3,
                    align   : 'center'
                }
            },
            xaxis : {
                mode      : 'categories',
                tickLength: 0
            }
        })
    })
</script>
@stop
