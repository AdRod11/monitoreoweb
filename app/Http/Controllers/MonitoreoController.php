<?php

namespace App\Http\Controllers;
use App\Binnacle;
use App\Dispositivo;
use App\Mail\CorreoResponsable;
use App\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DispositivoController;

class MonitoreoController extends Controller
{
    public function sesion(){
        session_start();
        if($_SESSION != null){
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
    public function index()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] != 3){
                $dispositivos = Dispositivo::all();
            }else {
                $dispositivos = Dispositivo::where('consulta',true)->get();
            }
            return view('Monitoreo.index',compact('dispositivos'));
        }else{
            return redirect('logout');
        }
    }
    public function show($id_dispositivo){
        if($this->sesion()){
            $dispositivo = DB::table('dispositivo as dis')
                ->join('ubicacion as ubi','ubi.id','=','dis.id_ubicacion')
                ->join('sistema as sis','sis.id','=','dis.id_sistema')
                ->join('categoria as cat','cat.id','=','dis.id_categoria')
                ->join('grupo as gru','gru.id','=','dis.id_grupo')
                ->select('dis.id as idDispositivo','dis.nombre as disNombre','dis.mac as disMac','dis.ip as disIp',
                    'ubi.descripcion as ubiDescripcion','ubi.lugar as ubiLugar',
                    'sis.nombre as sisNombre','sis.version as sisVersion',
                    'cat.descripcion as catDescripcion',
                    'gru.descripcion as grpDescripcion')
                ->where('dis.id','=',$id_dispositivo)->get();
            $responsables = DB::table('dispositivo as dis')
                ->join('responsable_dispositivo as resD','resD.id_dispositivo','=','dis.id')
                ->join('responsable as res','res.id','=','resD.id_responsable')
                ->join('persona as per','per.id','=','res.id_persona')
                ->where('dis.id','=',$id_dispositivo)
                ->select('per.nombre as perNombre','per.a_paterno as perPaterno','per.a_materno as perMaterno','per.correo as perCorreo')->get();
            $servicios_red = DB::table('servicio')
                ->join('dispositivo_servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->join('tipo_servicio','tipo_servicio.id','=','servicio.id_tipo_servicio')
                ->where('dispositivo_servicio.id_dispositivo','=',$id_dispositivo)
                ->where('servicio.id_tipo_servicio','=',2)->get();
            $servicios_hardware = DB::table('servicio')
                ->join('dispositivo_servicio','dispositivo_servicio.id_servicio','=','servicio.id')
                ->join('tipo_servicio','tipo_servicio.id','=','servicio.id_tipo_servicio')
                ->where('dispositivo_servicio.id_dispositivo','=',$id_dispositivo)
                ->where('servicio.id_tipo_servicio','=',3)->get();
            return view('Monitoreo.show',compact('dispositivo','responsables','servicios_red','servicios_hardware'));
        }else{
            return redirect('logout');
        }
    }
    public function sendCorreo(Request $request,$id_dispositivo)
    {
        $responsables = DB::table('dispositivo as dis')
            ->join('responsable_dispositivo as resD','resD.id_dispositivo','=','dis.id')
            ->join('responsable as res','res.id','=','resD.id_responsable')
            ->join('persona as per','per.id','=','res.id_persona')
            ->where('dis.id','=',$id_dispositivo)
            ->select('per.correo as perCorreo','per.id','dis.nombre as nombre','res.id as responsable')->get();

        foreach ($responsables as $responsable){
            $device_token = DB::table('usuario')
                ->where('id_persona','=',$responsable->id)
                ->select('device_token')
                ->get();
            Mail::to($responsable->perCorreo)->sendNow(new CorreoResponsable($request->mensaje,$request->disNombre));
            (new DispositivoController())->sendCustomNotification($device_token[0]->device_token,$request->mensaje,null,$responsable->responsable,$responsable->nombre);
        }
        return back()->with('success','El correo fue enviado');
    }
}
