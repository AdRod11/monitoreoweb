<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\Categoria;
use App\Estado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EstadoController extends Controller {

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
            $estado = Estado::All();
            if($_SESSION['permiso'] == 1){
                return view('Estado.index',compact('estado'));
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
            $estado = new Estado();
            $estado->create($request->all());
            return redirect('/estado')->with('success','Estado agregado');;
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Estado.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($estado)
    {
        if($this->sesion()){
            $estado = Estado::find($estado);
            if($_SESSION['permiso'] == 1){
                return view('Estado.update',compact('estado'));
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
            $estado = Estado::find($request->estado);
            $estado->update($request->all());
            return redirect('/estado')->with('success','Estado actualizado');;
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $estado = Estado::find($id);
            $estado->delete();
            return redirect()->back()->with('error','Estado eliminado');;
        }else{
            return redirect('logout');
        }
    }
}
