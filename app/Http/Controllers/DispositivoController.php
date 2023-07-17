<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\Dispositivo_servicio;

use App\Estado;
use App\Historico;
use App\Notificacion;
use App\Responsable_dispositivo;
use App\Ubicacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Grupo;
use App\Sistema;
use App\Categoria;
use App\Periodo;
use App\Dispositivo;
use App\Service;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPUnit\Framework\Constraint\IsTrue;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class DispositivoController extends Controller {

    public function sesion(){
        session_start();
        if ($_SESSION != null) {
            $current = Carbon::now();
            $sesion = Binnacle::where('token',$_SESSION['token'])
                ->where('fecha_inicio','<=',$current)
                ->where('fecha_fin','>=',$current)->get();
            if (sizeof($sesion)>0){
                return true;
            }
            else{
                return false;
            }
        }else{
            redirect('/login');
        }
    }
    public function index() {
        if($this->sesion()){

             $dispositivo = DB::table('dispositivo')
                 ->join('sistema', 'dispositivo.id_sistema', '=', 'sistema.id')
                 ->join('grupo', 'dispositivo.id_grupo', '=', 'grupo.id')
                 ->join('categoria', 'dispositivo.id_categoria', '=', 'categoria.id')
                 ->join('ubicacion', 'dispositivo.id_ubicacion', '=', 'grupo.id')
                 ->join('periodo', 'dispositivo.id_periodo', '=', 'periodo.id')
                 ->join('dia', 'periodo.id_dia', '=', 'dia.id')
                 ->select('dispositivo.id as id_dispositivo','dispositivo.ip as ip','dispositivo.mac',
                     'dispositivo.nombre as dispositivo_nombre',
                     'grupo.descripcion as grupo_nombre', 'sistema.nombre as sistema_nombre','categoria.descripcion as categoria_nombre',
                     'ubicacion.descripcion as ubicacion_nombre','dia.descripcion as periodo')
                 ->get();
             $responsable =DB::Table('responsable')
                 ->join('responsable_dispositivo','responsable_dispositivo.id_responsable','=','responsable.id')
                 ->join('persona','responsable.id_persona','=','persona.id')
                 ->select('persona.*','responsable_dispositivo.id_dispositivo')
                 ->get();

             if($_SESSION['permiso'] == 1 || $_SESSION['permiso'] == 2){
                 return view('Dispositivo.index',compact('dispositivo','responsable')) ;
             }else{
                 return redirect('login');
             }
        }else{
            return redirect('logout');
        }
    }
    public function store(Request $request)
    {
        if($this->sesion()){
            if($request->has('consulta')) {
                $consulta = 't';
            }else {
                $consulta = 'f';
            }
            $sistema = Sistema::find($request->id_sistema);
            $dispositivo = new Dispositivo();
            $dispositivo->nombre = $request->nombre;
            $dispositivo->ip = $request->ip;
            $dispositivo->mac = $request->mac;
            $dispositivo->id_grupo = $request->id_grupo;
            $dispositivo->id_sistema = $request->id_sistema;
            $dispositivo->id_ubicacion = $request->id_ubicacion;
            $dispositivo->id_categoria = $request->id_categoria;
            $dispositivo->id_periodo = $request->id_periodo;
            $dispositivo->consulta = $consulta;
            $dispositivo->save();
            if(is_writable('/usr/local/nagios/etc/hosts.cfg')) {
                $fp = fopen('/usr/local/nagios/etc/hosts.cfg','a');
                $host= '
define host{
name                            ' . $request->nombre . '
use                             generic-host
check_period                    24x7
check_interval                  5
retry_interval                  1
max_check_attempts              10
check_command                   check-host-alive
notification_period             24x7
notification_interval           30
notification_options            d,r
contact_groups                  admins
register                        0
}

define host{
use                             ' . $request->nombre . '
host_name                       ' . $request->nombre . '
alias                           ' . $sistema->nombre . ' ' . $sistema->version . '
address                         ' . $request->ip . '
}';
                fwrite($fp,$host);
                fclose($fp);
            }
            shell_exec("curl --data 'cmd_typ=13' --data 'cmd_mod=2'  'http://localhost/nagios/cgi-bin/cmd.cgi' -u 'nagiosadmin:jR73V87'");
            return redirect('/dispositivo')->with('success','Dispositivo agregado');;
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            $grupos = Grupo::pluck("descripcion",'id');
            $sistemas = Sistema::
            select(DB::raw("concat(nombre,' ',version) as nombre"),"id")
                ->pluck("nombre",'id');
            $ubicaciones = Ubicacion::pluck("descripcion",'id');
            $categorias = Categoria::pluck("descripcion",'id');
            $periodos = Periodo::
            join('dia','periodo.id_dia','=','dia.id')
                ->pluck("dia.descripcion",'periodo.id');
            if($_SESSION['permiso'] == 1){
                return view('Dispositivo.create',compact('grupos','sistemas','ubicaciones','categorias','periodos'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($dispositivo)
    {
        if($this->sesion()){
            $grupos = Grupo::pluck("descripcion",'id');
            $sistemas = Sistema::
            select(DB::raw("concat(nombre,' ',version) as nombre"),"id")
                ->pluck("nombre",'id');
            $ubicaciones = Ubicacion::pluck("descripcion",'id');
            $categorias = Categoria::pluck("descripcion",'id');
            $periodos = Periodo::
            join('dia','periodo.id_dia','=','dia.id')
                ->pluck("dia.descripcion",'periodo.id');
            $dispositivo = Dispositivo::find($dispositivo);
            if($_SESSION['permiso'] == 1){
                return view('Dispositivo.update',compact('dispositivo','grupos','sistemas','ubicaciones','categorias','periodos'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function update(Request $request)
    {
        if($this->sesion()){
            if($request->has('consulta'))
                $request->consulta='t';
            else
                $request->consulta='f';
            $dispositivo = Dispositivo::find($request->dispositivo);
            $old_name=$dispositivo->nombre;
            $old_ip=$dispositivo->ip;
            $dispositivo->update($request->all());
            shell_exec('sed -i s/'.$old_name.'/'.$request->nombre.'/g /usr/local/nagios/etc/hosts.cfg');
            shell_exec('sed -i s/'.$old_name.'/'.$request->nombre.'/g /usr/local/nagios/etc/services.cfg');
            shell_exec('sed -i s/'.$old_ip.'/'.$request->ip.'/g /usr/local/nagios/etc/hosts.cfg');
            shell_exec("curl --data 'cmd_typ=13' --data 'cmd_mod=2'  'http://localhost/nagios/cgi-bin/cmd.cgi' -u 'nagiosadmin:jR73V87'");
            return redirect('/dispositivo')->with('success','Dispositivo actualizado');;
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $dispositivo = Dispositivo::find($id);
            $dispositivo->delete();
            if(is_writable('/usr/local/nagios/etc/hosts.cfg')) {
                //eliminar contenido de archivo
                $arch="";
                $arch = fopen ("/usr/local/nagios/etc/hosts.cfg", "w+");
                fwrite($arch, "");
                fclose($arch);

                $fp = fopen('/usr/local/nagios/etc/hosts.cfg','a');
                $dispositivos = DB::table('dispositivo')
                    ->join('sistema','id_sistema','=','sistema.id')
                    ->select('dispositivo.nombre','dispositivo.ip','sistema.version','sistema.nombre as sistema')
                    ->get();
                foreach ($dispositivos as $devices) {
                    $host= '
define host{
name                            ' . $devices->nombre . '
use                             generic-host
check_period                    24x7
check_interval                  5
retry_interval                  1
max_check_attempts              10
check_command                   check-host-alive
notification_period             24x7
notification_interval           30
notification_options            d,r
contact_groups                  admins
register                        0
}

define host{
use                             ' . $devices->nombre . '
host_name                       ' . $devices->nombre . '
alias                           ' . $devices->sistema . ' ' . $devices->version . '
address                         ' . $devices->ip . '
}';
                    fwrite($fp, $host);
                }
                fclose($fp);
            }
            shell_exec("curl --data 'cmd_typ=13' --data 'cmd_mod=2'  'http://localhost/nagios/cgi-bin/cmd.cgi' -u 'nagiosadmin:jR73V87'");
            return redirect()->back();
        }else{
            return redirect('logout');
        }
    }
    public function show($id){
        if($this->sesion()){
            $dispositivo = DB::table('dispositivo')
                ->join('sistema', 'dispositivo.id_sistema', '=', 'sistema.id')
                ->join('grupo', 'dispositivo.id_grupo', '=', 'grupo.id')
                ->join('categoria', 'dispositivo.id_categoria', '=', 'categoria.id')
                ->join('ubicacion', 'dispositivo.id_ubicacion', '=', 'grupo.id')
                ->join('periodo', 'dispositivo.id_periodo', '=', 'periodo.id')
                ->join('dia', 'periodo.id_dia', '=', 'dia.id')
                ->select('dispositivo.id as id_dispositivo','dispositivo.ip as ip','dispositivo.mac',
                    'dispositivo.nombre as dispositivo_nombre',
                    'grupo.descripcion as grupo_nombre', 'sistema.nombre as sistema_nombre','categoria.descripcion as categoria_nombre',
                    'ubicacion.descripcion as ubicacion_nombre','dia.descripcion as periodo')
                ->where('dispositivo.id','=',$id)
                ->get();
            $dispositivo =$dispositivo->first();
            $responsable =DB::Table('responsable')
                ->join('responsable_dispositivo','responsable_dispositivo.id_responsable','=','responsable.id')
                ->join('persona','responsable.id_persona','=','persona.id')
                ->select('persona.*','responsable_dispositivo.id')
                ->where('responsable_dispositivo.id_dispositivo','=',$id)
                ->get();

            $servicios =DB::Table('servicio')
                ->join('dispositivo_servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->join('estado','dispositivo_servicio.id_estado','=','estado.id')
                ->select('servicio.nombre as servicio','estado.descripcion as estado','dispositivo_servicio.id')
                ->where('dispositivo_servicio.id_dispositivo','=',$id)
                ->get();
            $servicio_disponible = DB::Table('servicio')
                ->whereNotIn('id',DB::Table('dispositivo_servicio')
                    ->select('id_servicio')
                    ->where('id_dispositivo',"=",$id))
                ->pluck('nombre','id');
            $responsable_disponible = DB::Table('responsable')
                ->whereNotIn('responsable.id',DB::Table('responsable_dispositivo')
                    ->select("id_responsable")
                    ->where('id_dispositivo',"=",$id))
                ->join("persona","responsable.id_persona","=","persona.id")
                ->select(DB::raw("concat(persona.nombre,' ',persona.a_paterno,' ',persona.a_materno) as nombre"),"responsable.id")
                ->pluck('persona.nombre','responsable.id');

            if($_SESSION['permiso'] == 1 || $_SESSION['permiso'] == 2){
                return view('Dispositivo.show',compact('dispositivo','responsable','servicios','servicio_disponible','responsable_disponible'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function addService(Request $request,$id)
    {
        if($this->sesion()){
            $dispositivo = Dispositivo::find($id);
            $servicio = Service::find($request->servicio);
            $comando = DB::table('servicio')
                ->join('comando_servicio','id_comando','=','comando_servicio.id')
                ->where('servicio.id','=',$request->servicio)
                ->select('identificador','comando_servicio.descripcion')
                ->get();
            $comando =$comando[0];
            if(is_writable('/usr/local/nagios/etc/services.cfg')) {
                $fp = fopen('/usr/local/nagios/etc/services.cfg','a');
                $service= '
define service{
use                     generic-service
host_name               ' . $dispositivo->nombre . '
service_description     ' . $servicio->identificador.'
check_command           ' . $comando->descripcion.'
        }';
                fwrite($fp,$service);
                fclose($fp);
                echo "Si entro";
            }
            else
            {echo "No tiene permisos";
            }
            $service = new Dispositivo_servicio();
            $service->id_dispositivo= $id;
            $service->id_servicio= $request->servicio;
            $service->id_estado = 1;
            $service ->save();
            shell_exec("curl --data 'cmd_typ=13' --data 'cmd_mod=2'  'http://localhost/nagios/cgi-bin/cmd.cgi' -u 'nagiosadmin:jR73V87'");

            return redirect()->back()->with('success','Servicio agregado');;
        }else{
            return redirect('logout');
        }
    }
    public function deleteService($id)
    {
        if($this->sesion()){
            $servicio = Dispositivo_servicio::find($id);
            $servicio->delete();

            if(is_writable('/usr/local/nagios/etc/services.cfg')) {
                //eliminar contenido de archivo
                $arch="";
                $arch = fopen ("/usr/local/nagios/etc/services.cfg", "w+");
                fwrite($arch, "");
                fclose($arch);

                $fp = fopen('/usr/local/nagios/etc/services.cfg','a');
                $servicios = DB::table('servicio')
                    ->join('dispositivo_servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                    ->join('dispositivo','dispositivo.id','=','dispositivo_servicio.id_dispositivo')
                    ->join('comando_servicio','id_comando','=','comando_servicio.id')
                    ->select('identificador','comando_servicio.descripcion','dispositivo.nombre')
                    ->get();
                foreach ($servicios as $services) {
                    $service = '
define service{
use                     generic-service
host_name               ' . $services->nombre . '
service_description     ' . $services->identificador . '
check_command           ' . $services->descripcion . '
        }';
                    fwrite($fp, $service);
                }
                fclose($fp);
            }
            shell_exec("curl --data 'cmd_typ=13' --data 'cmd_mod=2'  'http://localhost/nagios/cgi-bin/cmd.cgi' -u 'nagiosadmin:jR73V87'");
            return redirect()->back()->with('error','Servicio eliminado');;
        }else{
            return redirect('logout');
        }
    }
    public function addResponsable(Request $request,$id)
    {
        if($this->sesion()){
            $responsable = new Responsable_dispositivo();
            $responsable->id_dispositivo= $id;
            $responsable->id_responsable= $request->responsable;
            $responsable ->save();
            return redirect()->back()->with('success','Responsable agregado');;
        }else{
            return redirect('logout');
        }
    }
    public function deleteResponsable($id)
    {
        if($this->sesion()){
            $responsable = Responsable_dispositivo::find($id);
            $responsable->delete();
            return redirect()->back()->with('error','Responsable eliminado');;

        }else{
            return redirect('logout');
        }
    }
    public function checkStatus()
    {
        $dispositivo = DB::table('dispositivo')
            ->get();
        foreach($dispositivo as $device)
        {
            $services = DB::table('dispositivo_servicio')
                ->join('servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->where('dispositivo_servicio.id_dispositivo','=',$device->id)
                ->select('servicio.*','dispositivo_servicio.mensaje','dispositivo_servicio.id as id_dispositivo_servicio','dispositivo_servicio.id_estado')
                ->get();
            foreach ($services as $servicios)
            {
                $device->nombre=srt_replace(' ','+',$device->nombre);
                $fecha=now()->format('m-d-Y H:i:s');
                $force= shell_exec("curl --data 'cmd_typ=7' --data 'cmd_mod=2' --data 'host=$device->nombre' --data 'service=$servicios->identificador' --data 'start_time=$fecha' --data 'force_check=1' 'http://localhost/nagios/cgi-bin/cmd.cgi' -u 'nagiosadmin:jR73V87'");
                $response=shell_exec("curl -XGET 'http://nagiosadmin:jR73V87@localhost/nagios/cgi-bin/statusjson.cgi?query=service&hostname='".$device->nombre."'&servicedescription='".$servicios->identificador.'""');
                $response= json_decode($response);
                print_r($servicios->identificador);
                if ($response->result->type_text == "Success")
                {
                    $mensaje = $response->data->service->plugin_output;

                    if(!isset($mensaje) || trim($mensaje) === '')
                    {
                        $mensaje =$response->data->service->long_plugin_output;
                        if(!isset($mensaje) || trim($mensaje) === '')
                        {
                            $mensaje ="ERROR en el servicio ".$servicios->nombre;
                        }
                    }
                    $estatus=$response->data->service->status;
                    $estatus_old = $servicios->id_estado;
                    switch($estatus)
                    {
                        case 2:
                            $estatus= 2;
                            break;
                        case 4:
                            $estatus= 4;
                            break;
                        default:
                            $estatus= 1;
                            break;
                    }
                    if (strcmp($estatus,$estatus_old)==!0)
                    {
                        echo "Cambio de estatus";
                        $dispositivo_servicio = Dispositivo_servicio::find($servicios->id_dispositivo_servicio);
                        $dispositivo_servicio->id_estado = $estatus;
                        $dispositivo_servicio->mensaje = $mensaje;
                        $dispositivo_servicio->save();

                        $dispositivo = Dispositivo::find($dispositivo_servicio->id_dispositivo);
                        $servicio = Service::find($dispositivo_servicio->id_servicio);
                        $estado = Estado::find($estatus);

                        $historico = new Historico();
                        $historico->dispositivo = $dispositivo->nombre;
                        $historico->ip = $dispositivo->ip;
                        $historico->servicio = $servicio->nombre;
                        $historico->fecha = now();
                        $historico->estatus = $estado->descripcion;
                        $historico->mensaje = $mensaje;
                        $historico->save();
                        $responsables = DB::table('responsable_dispositivo')
                            ->join('responsable','responsable.id','=','responsable_dispositivo.id_responsable')
                            ->join('persona','persona.id','=','responsable.id_persona')
                            ->join('usuario','persona.id','=','usuario.id_persona')
                            ->where('responsable_dispositivo.id_dispositivo','=',$dispositivo->id)
                            ->select('usuario.device_token','responsable.id')
                            ->get();
                        if(strcmp($estatus,1)==0) {
                            foreach($responsables as $responsable) {
                                $this->sendNotification($dispositivo->nombre, $servicio->nombre,$responsable->device_token,"ha fallado",$estatus,$responsable->id);
                            }
                        }
                        if(strcmp($estatus,2)==0) {
                            foreach($responsables as $responsable) {
                                $this->sendNotification($dispositivo->nombre, $servicio->nombre,$responsable->device_token,"se ha reactivado",$estatus,$responsable->id);
                            }
                        }
                    }
                }
                else {
                    $estatus= 3;
                    $estatus_old = $servicios->id_estado;
                    if (strcmp($estatus,$estatus_old)==!0)
                    {

                        $dispositivo_servicio = Dispositivo_servicio::find($servicios->id_dispositivo_servicio);
                        $dispositivo_servicio->id_estado = $estatus;
                        $dispositivo_servicio->mensaje = $response->result->message;
                        $dispositivo_servicio->save();

                        $dispositivo = Dispositivo::find($dispositivo_servicio->id_dispositivo);
                        $servicio = Service::find($dispositivo_servicio->id_servicio);
                        $estado = Estado::find($estatus);

                        $historico = new Historico();
                        $historico->dispositivo = $dispositivo->nombre;
                        $historico->ip = $dispositivo->ip;
                        $historico->servicio = $servicio->nombre;
                        $historico->fecha = now();
                        $historico->estatus = $estado->descripcion;
                        $historico->mensaje = $response->result->message;
                        $historico->save();
                    }
                    else{
                        $dispositivo_servicio = Dispositivo_servicio::find($servicios->id_dispositivo_servicio);
                        $dispositivo_servicio->id_estado = $estatus;
                        $dispositivo_servicio->mensaje = $response->result->message;
                        $dispositivo_servicio->save();
                    }
                }
            }
        }
    }
    public function sendNotification($dispositivo,$servicio,$device_token,$mensaje,$estado,$responsable)
    {
        echo "entro a la notificacion";
        $client = new Client(); //GuzzleHttp\Client
        $notificacion = '{
	"to": "'.$device_token.'",
	"notification":{
		"title":"Monitoreo lince",
		"body":"Notificacion de servicio",
		"image":"https://st.depositphotos.com/1186248/2751/i/450/depositphotos_27516585-stock-photo-alert.jpg"
	},
	"data":{
		"dispositivo":"'."El  " . $dispositivo. " con el servicio: " .$servicio. " ".$mensaje. " el dia: " .now().'",
		"estado": "'.$estado.'"
	}
}';

        $authHeader = [
            'body'    =>$notificacion,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization'  => 'key=AAAAVcMN6aA:APA91bHeJt3d-A1JA65E9pmMtchmCMFcTcUKF2FI_rNbFzzLFtXx6jFh26Jekmr4WowMqV4HAvHOdhkLi2wrVHHzD3gTzbwtSrpJCqFEp9rfmrPQfL9DnZdSJF0JKcL7du4ia0FOJN0Q'
            ],
        ];

        $notificion_p = new Notificacion();
        $notificion_p->id_responsable=$responsable;
        $notificion_p->fecha = now();
        $notificion_p->dispositivo = $dispositivo;
        $notificion_p->mensaje = "El  " . $dispositivo. " con el servicio: " .$servicio. " ".$mensaje. " el dia: " .now();
        $notificion_p->visto = 'f';
        $notificion_p->save();

        $response = $client->post("https://fcm.googleapis.com/fcm/send",$authHeader);
    }
    public function sendCustomNotification($dispositivo,$mensaje,$estado,$responsable,$nombre)
    {
        $client = new Client(); //GuzzleHttp\Client
        $mensaje=$mensaje.". Con fecha de ".now();
        $notificacion = '{
	"to": "'.$dispositivo.'",
	"notification":{
		"title":"Monitoreo lince",
		"body":"Notificacion personalizada",
		"image":"https://www.lancelotdigital.com/images/2018/02/aviso1.png"
			},
	"data":{
		"dispositivo":"'.$mensaje.'",
		"estado": "'.$estado.'"
	}
}';

        $authHeader = [
            'body'    =>$notificacion,
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization'  => 'key=AAAAVcMN6aA:APA91bHeJt3d-A1JA65E9pmMtchmCMFcTcUKF2FI_rNbFzzLFtXx6jFh26Jekmr4WowMqV4HAvHOdhkLi2wrVHHzD3gTzbwtSrpJCqFEp9rfmrPQfL9DnZdSJF0JKcL7du4ia0FOJN0Q'
            ],
        ];

        $notificion_p = new Notificacion();
        $notificion_p->id_responsable=$responsable;
        $notificion_p->fecha = now();
        $notificion_p->dispositivo = $nombre;
        $notificion_p->mensaje = $mensaje;
        $notificion_p->visto = 'f';
        $notificion_p->save();

        $response = $client->post("https://fcm.googleapis.com/fcm/send",$authHeader);
    }
    public function ping ($ip)
    {
         $result = shell_exec("/usr/local/nagios/libexec/check_ping -H ".$ip." -w 10,2% -c 20,5% -p 2");
         return $result;
    }
}
