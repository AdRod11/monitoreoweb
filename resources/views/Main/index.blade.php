<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ITC | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/morris.js/morris.css')}}">
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css')}}">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">

    <header class="main-header">
        <a href="/" class="logo bg-blue">
            <span class="logo-mini bg-blue"><b>ITC</b></span>
            <span class="logo-lg bg-blue"><b>Monitoreo </b>ITC </span>
        </a>
        <nav class="navbar navbar-static-top bg-blue">
            <a href="#" class="sidebar-toggle bg-blue" data-toggle="push-menu" role="button">
                <span class="sr-only bg-blue">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu bg-blue">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu bg-blue">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs">{{$_SESSION['usuario']}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-body bg-blue">
                                <span class="info-box-icon bg-blue"><span class="glyphicon glyphicon-user"></span></span>
                                <p>
                                    {{ $_SESSION['nombre'] }}
                                    <small>{{ $_SESSION['permiso_descripcion'] }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Editar Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="/logout" class="btn btn-default btn-flat">Cerrar sesión</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">Menu</li>
                @if($_SESSION['permiso'] == 1 || $_SESSION['permiso'] == 2)
                    <li><a href="/dispositivo"><i class="glyphicon glyphicon-hdd"></i> <span>Dispositivo</span></a></li>
                @endif
                @if($_SESSION['permiso'] == 1)
                    <li><a href="/servicio"><i class="fa fa-book"></i> <span>Servicio</span></a></li>
                    <li><a href="/tiposervicio"><i class="fa fa-list-ul"></i> <span>Tipo Servicio</span></a></li>
                    <li><a href="/usuario"><i class="glyphicon glyphicon-user"></i> <span>Usuario</span></a></li>
                    <li><a href="/rol"><i class="fa fa-user-secret"></i><span>Rol</span></a></li>
                    <li><a href="/grupo"><i class="fa fa-group"></i> <span>Grupo</span></a></li>
                    <li><a href="/categoria"><i class="fa fa-cubes"></i> <span>Categoria</span></a></li>
                    <li><a href="/sistema"><i class="fa fa-linux"></i><span>Sistema</span></a></li>
                    <li><a href="/ubicacion"><i class="fa fa-map-marker"></i> <span>Ubicación</span></a></li>
                    <li><a href="#"><i class="fa fa-calendar"></i> <span>Periodo</span></a></li>
                    <li><a href="/estado"><i class="fa fa-check"></i> <span>Estado</span></a></li>
                    <li><a href="/historico"><i class="fa fa-history"></i> <span>Historico</span></a></li>
                @endif
                <li><a href="/monitoreo"><i class="fa fa-bar-chart"></i> <span>Monitoreo</span></a></li>
            </ul>
        </section>
    </aside>
    <div class="content-wrapper">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('info'))
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @yield("list")

    </div>
    <aside class="control-sidebar control-sidebar-dark">
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>Some information about this general settings option</p>
                    </div>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>Other sets of options are available</p>
                    </div>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p>Allow the user to show his name in blog posts</p>
                    </div>
                    <h3 class="control-sidebar-heading">Chat Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </aside>
    <div class="control-sidebar-bg"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('bower_components/chart.js/Chart.js')}}"></script>
    <script src="{{asset('bower_components/morris.js/morris.min.js')}}"></script>
    <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
    <script src="{{asset('bower_components/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('bower_components/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('bower_components/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('bower_components/Flot/jquery.flot.categories.js')}}"></script>

    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('dist/js/demo.js')}}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button);
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#historico thead tr').clone(true).appendTo( '#historico thead' );
            $('#historico thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input style="width: 100%;" type="text" placeholder="Buscar '+title+'" />' );
                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table = $('#historico').DataTable( {
                orderCellsTop: true,
                fixedHeader: true
            } );
        } );
        $(function () {
            $('#example1').DataTable()
        });
        $(function () {
            $('#responsable').DataTable()
        });
        $("#ping").click(function (event) {
            var valor = document.getElementById("ip").value;
            $.get('/ping/'+valor,function (data) {
                alert(data);
            });
        });
	 $("#pingMonitoreo").click(function (event) {
          $('#pingMonitoreo').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
            var el = document.getElementById("ipMonitoreo");
           valor = (el.innerText || el.textContent);
            $.get('/ping/'+valor,function (data) {
                alert(data);
		$('#pingMonitoreo').html();
		const element =  '<span> <button type="button" id="pingMonitoreo" class ="btn bg-blue">Comprobar conexion</button> </span>';
		ReactDOM.render(element, document.getElementById('pingMonitoreo'));
            });
        });
        $("#servicio").change(function(event){
            $.get('/servicio/'+event.target.value,function (data) {
                document.getElementById("descripcion").value = data;
            });
        });
    </script>
    @yield("script")

    </body>
</html>
