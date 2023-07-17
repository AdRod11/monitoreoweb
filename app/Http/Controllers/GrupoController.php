<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Grupo;
use Carbon\Carbon;
use App\Binnacle;
use DB;
use App\Http\Requests;
use PHPUnit\Framework\Constraint\IsTrue;

class GrupoController extends Controller {

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
            $groups = Grupo::all();
            if($_SESSION['permiso'] == 1){
                return view('Grupos.index',compact('groups'));
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
            $grupo = new Grupo();
            $grupo->descripcion = $request->descripcion;
            $grupo->save();
            return redirect('/grupo')->with('success','Grupo agregado');
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Grupos.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($id_grupo)
    {
        if($this->sesion()){
            $grupo = Grupo::find($id_grupo);
            if($_SESSION['permiso'] == 1){
                return view('Grupos.update',compact('grupo'));
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
            $grupo = Grupo::find($request->grupo);
            $grupo->update($request->all());
            return redirect('/grupo')->with('success','Grupo actualizado');
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $grupo = Grupo::find($id);
            $grupo->delete();
            return redirect()->back()->with('error','Grupo borrado');
        }else{
            return redirect('logout');
        }
    }
    public function show($id){
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
