<?php


namespace App\Http\Controllers;

use App\Binnacle;
use App\Dispositivo;
use App\Notificacion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiLoginController extends Controller {
    public function generarToken(String $user,String $password)
    {
        $admin= User::where('usuario',$user)
            ->where('contrasena', md5($password))
            ->get();
        if(sizeof($admin)>0)
        {
            if($admin[0]->estatus == true){
                $token = md5($admin[0]->usuario.time());
                $fecha_inicio = now();
                $fecha_fin = now()->addMinutes(30);
                $binnacle = new Binnacle();
                $binnacle->token = $token;
                $binnacle->id_usuario = $admin[0]->id;
                $binnacle->fecha_inicio = $fecha_inicio;
                $binnacle->fecha_fin = $fecha_fin;
                $binnacle->save();
                return $token;
            }else{
                return 'Usuario in activo';
            }
        }
        else {
            return null;
        }
    }
    public function sendEmail($email)
    {
        $contrasena = md5(correo.now());
        $user = User::where('usuario',$email)->first();
        if(sixeof($user)>0)
        {
            $user->contrasena = md5($contrasena);
            $user->save();
            Mail::to($email)->sendNow(new NuevaContrasena($email,$contrasena));
            return "El correo ha sido enviado correctamente";
        }
        else{
            return "El correo no existe";
        }
    }
    public function iniciarSesion(String $token)
    {
        $current = now();
        $sesion = Binnacle::where('token',$token)
            ->where('fecha_inicio','<=',$current)
            ->where('fecha_fin','>=',$current)->get();
        if(sizeof($sesion) > 0){
            $info = DB::table('usuario')
                ->join('usuario_rol','usuario_rol.id_usuario','=','usuario.id')
                ->join('rol','rol.id','=','usuario_rol.id_rol')
                ->where('usuario.id','=',$sesion[0]->id_usuario)
                ->select('usuario.usuario','usuario.estatus','rol.descripcion')->get();
            $dispositivos = DB::table('dispositivo as dis')
                ->join('ubicacion as ubi','ubi.id','=','dis.id_ubicacion')
                ->join('sistema as sis','sis.id','=','dis.id_sistema')
                ->join('categoria as cat','cat.id','=','dis.id_categoria')
                ->join('grupo as gru','gru.id','=','dis.id_grupo')
                ->join('responsable_dispositivo as resD','resD.id_dispositivo','=','dis.id')
                ->join('responsable as res','res.id','=','resD.id_responsable')
                ->join('persona as per','per.id','=','res.id_persona')
                ->where('per.correo','=',$info[0]->usuario)
                ->select('dis.id as idDispositivo','dis.nombre as disNombre','dis.mac as disMac','dis.ip as disIp',
                    'ubi.descripcion as ubiDescripcion',
                    'sis.nombre as sisNombre','sis.version as sisVersion',
                    'cat.descripcion as catDescripcion',
                    'gru.descripcion as gruDescripcion')->get();
            if (sizeof($info)>0 && sizeof($dispositivos)>0){
                $info[0]->dispositivos = $dispositivos;
                return json_encode($info[0]);
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
    public function userInfo(String $token)
    {
        $current = now();
        $sesion = Binnacle::where('token', $token)
            ->where('fecha_inicio', '<=', $current)
            ->where('fecha_fin', '>=', $current)->get();
        if (sizeof($sesion) > 0) {
            $user = DB::table('usuario')
                ->join('usuario_rol','usuario_rol.id_usuario','=','usuario.id')
                ->join('persona','persona.id','=','usuario.id_persona')
                ->join('rol','rol.id','=','usuario_rol.id_rol')
                ->where('usuario.id','=',$sesion[0]->id_usuario)
                ->select('persona.correo as correo',
                    'rol.descripcion as rol',
                    'persona.nombre as nombre',
                    'persona.a_paterno as aPaterno',
                    'persona.a_materno as aMaterno',
                    'persona.curp as curp',
                    'persona.telefono as telefono',
                    'persona.domicilio as direccion'
                    )->get();
            $userInf['userInfo'] = $user;
            return json_encode($userInf);
        }else{
            return null;
        }
    }

    public function userNoti(String $token)
    {
        $current = now();
        $sesion = Binnacle::where('token', $token)
            ->where('fecha_inicio', '<=', $current)
            ->where('fecha_fin', '>=', $current)->get();
        if (sizeof($sesion) > 0) {
            $noti = DB::table('usuario')
                ->join('persona','persona.id','=','usuario.id_persona')
                ->join('responsable','responsable.id_persona','=','persona.id')
                ->join('notificacion_personalizada as noti','noti.id_responsable','=','responsable.id')
                ->where('usuario.id','=',$sesion[0]->id_usuario)
                ->select('noti.dispositivo',
                    'noti.mensaje','noti.visto','noti.id')
                ->orderBy('fecha','DESC')
                ->get();
            $userNoti['userNoti'] = $noti;
            foreach($userNoti['userNoti'] as $noti)
            {
             $notificacion =  Notificacion::find($noti->id);
             $notificacion->visto = "t";
             $notificacion->save();
            }
            return json_encode($userNoti);
        }else{
            return null;
        }
    }

    public function infoDevice(String $token,Request $request)
    {
        $current = now();
        $sesion = Binnacle::where('token', $token)
            ->where('fecha_inicio', '<=', $current)
            ->where('fecha_fin', '>=', $current)->get();
        if (sizeof($sesion) > 0) {
            $servicios_red = DB::table('servicio')
                ->join('dispositivo_servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->join('tipo_servicio','tipo_servicio.id','=','servicio.id_tipo_servicio')
                ->where('dispositivo_servicio.id_dispositivo','=',$request->id_dispositivo)
                ->where('servicio.id_tipo_servicio','=',2)->get();
            $servicios_hardware = DB::table('servicio')
                ->join('dispositivo_servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->join('tipo_servicio','tipo_servicio.id','=','servicio.id_tipo_servicio')
                ->where('dispositivo_servicio.id_dispositivo','=',$request->id_dispositivo)
                ->where('servicio.id_tipo_servicio','=',3)->get();
            $dispositivo=Dispositivo::where($request->id_dispositivo);
            if(sizeof($servicios_red) > 0) {
                $dispositivo->servicios_red = $servicios_red;
                if(sizeof($servicios_hardware) > 0) {
                    $dispositivo->servicios_hardware = $servicios_hardware;
                }
                return json_encode($dispositivo);
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function saveDeviceToken(Request $request){
        $user = $request->user;
        $deviceToken = $request->deviceToken;
        $user = User::where('usuario',$user)->first();
        $user->device_token = $deviceToken;
        $user->save();
    }
}
