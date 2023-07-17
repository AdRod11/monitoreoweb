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

class TipoServicioController extends Controller {

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
            $tiposervicios = TipoServicio::all();
            if($_SESSION['permiso'] == 1){
                return view('TipoServicio.index',compact('tiposervicios'));
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
            $tiposervicio = new TipoServicio();
            $tiposervicio->create($request->all());
            return redirect('/tiposervicio')->with('success','Tipo de Servicio agregado');
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('TipoServicio.create',compact('tipo_servicio'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($tipo)
    {
        if($this->sesion()){
            $tiposervicio = TipoServicio::find($tipo);
            if($_SESSION['permiso'] == 1){
                return view('TipoServicio.update',compact('tiposervicio'));
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
            $tiposervicio = TipoServicio::find($request->tiposervicio);
            $tiposervicio->update($request->all());
            return redirect('/tiposervicio')->with('success','Tipo de Servicio actualizado');
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $tiposervicio = TipoServicio::find($id);
            $tiposervicio->delete();
            return redirect()->back()->with('error','Tipo de Servicio eliminado');
        }else{
            return redirect('logout');
        }
    }
    public function show($servicio)
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){

            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
}
