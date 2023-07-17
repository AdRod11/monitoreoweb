<?php
namespace App\Http\Controllers;
use App\Binnacle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Rol;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RolController extends Controller {

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
            $rol = Rol::All();
            if($_SESSION['permiso'] == 1){
                return view('Roles.index',compact('rol'));
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
            $rol = new Rol();
            $rol->create($request->all());
            return redirect('/rol')->with('success','Rol agregado');;
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Roles.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($rol)
    {
        if($this->sesion()){
            $rol = Rol::find($rol);
            if($_SESSION['permiso'] == 1){
                return view('Roles.update',compact('rol'));
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
            $rol = Rol::find($request->rol);
            $rol->update($request->all());
            return redirect('/rol')->with('success','Rol actualizado');;
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $rol = Rol::find($id);
            $rol->delete();
            return redirect()->back()->with('error','Rol eliminado');;
        }else{
            return redirect('logout');
        }
    }
}
