<?php
namespace App\Http\Controllers;
use App\Binnacle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPUnit\Framework\Constraint\IsTrue;

class DispositivoServicioController extends Controller {

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
            if($_SESSION['permiso'] == 1){
                return view('Dispositivo.index',compact('dispositivo','responsable'));
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
            $user = new User();
            $user->create($request->all());
            return redirect('/usuario');
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Usuarios.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($usuario)
    {
        if($this->sesion()){
            $usuario = User::find($usuario);
            if($_SESSION['permiso'] == 1){
                return view('Usuarios.update',compact('usuario'));
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
            $user = User::find($request->usuario);
            $user->update($request->all());
            return redirect('/usuario');
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $user = User::find($id);
            $user->delete();
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
            if($_SESSION['permiso'] == 1){
                return view('Dispositivo.show',compact('dispositivo','responsable','servicios','servicio_disponible'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function addService(Request $request)
    {
        if($this->sesion()){
            $user = new User();
            $user->create($request->all());
            return redirect('/usuario');
        }else{
            return redirect('logout');
        }
    }
}
