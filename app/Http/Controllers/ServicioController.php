<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\TipoServicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServicioController extends Controller {

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
    public function index() {
        if($this->sesion()){
            $servicio = DB::table('servicio')
                ->join('tipo_servicio','tipo_servicio.id','=','servicio.id_tipo_servicio')
                ->select('servicio.id','servicio.nombre','servicio.descripcion','servicio.id_comando',
                    'tipo_servicio.descripcion as tiposervicio')->get();
            if($_SESSION['permiso'] == 1){
                return view('Servicios.index',compact('servicio'));
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
            $servicio = new Service();
            $servicio->create($request->all());
            return redirect('/servicio')->with('success','Servicio agregado');
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            $tipo_servicio = TipoServicio::pluck('descripcion','id');
            if($_SESSION['permiso'] == 1){
                return view('Servicios.create',compact('tipo_servicio'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($servicio)
    {
        if($this->sesion()){
            $servicio = Service::find($servicio);
            $tipo_servicio = TipoServicio::find($servicio->id_tipo_servicio)
                ->pluck('descripcion','id');
            if($_SESSION['permiso'] == 1){
                return view('Servicios.update',compact('servicio','tipo_servicio'));
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
            $servicio = Service::find($request->servicio);
            $servicio->update($request->all());
            return redirect('/servicio')->with('success','Servicio actualizado');
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $servicio = Service::find($id);
            $servicio->delete();
            return redirect()->back()->with('error','Sistema eliminado');
        }else{
            return redirect('logout');
        }
    }
    public function show($servicio)
    {
        if($this->sesion()){
            $servicio = Service::find($servicio);
            return $servicio->descripcion;
        }else{
            return redirect('logout');
        }
    }
}
