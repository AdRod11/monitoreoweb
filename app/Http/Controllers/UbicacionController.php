<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\Ubicacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Service;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UbicacionController extends Controller {

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
            $ubicacion = Ubicacion::All();
            if($_SESSION['permiso'] == 1){
                return view('Ubicacion.index',compact('ubicacion'));
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
            $ubicacion = new Ubicacion();
            $ubicacion->create($request->all());
            return redirect('/ubicacion')->with('success','Ubicacioón agregada');;
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Ubicacion.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($ubicacion)
    {
        if($this->sesion()){
            $ubicacion = Ubicacion::find($ubicacion);
            if($_SESSION['permiso'] == 1){
                return view('Ubicacion.update',compact('ubicacion'));
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
            $ubicacion = Ubicacion::find($request->ubicacion);
            $ubicacion->update($request->all());
            return redirect('/ubicacion')->with('success','Ubicación actualizada');;
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $ubicacion = Ubicacion::find($id);
            $ubicacion->delete();
            return redirect()->back()->with('error','Ubicación elimianda');;
        }else{
            return redirect('logout');
        }
    }
}
