<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\Categoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoriaController extends Controller {

    public function sesion()
    {
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
        } else {
            redirect('/login');
        }
    }
    public function index() {
        if($this->sesion()){
            $categoria = Categoria::All();
            if($_SESSION['permiso'] == 1){
                return view('Categoria.index',compact('categoria'));
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
            $categoria = new Categoria();
            $categoria->create($request->all());
            return redirect('/categoria')->with('success','Categoria agregada');;
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Categoria.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($categoria)
    {
        if($this->sesion()){
            $categoria = Categoria::find($categoria);
            if($_SESSION['permiso'] == 1){
                return view('Categoria.update',compact('categoria'));
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
            $categoria = Categoria::find($request->categorium);
            $categoria->update($request->all());
            return redirect('/categoria')->with('success','Categoria actualizada');;
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $categoria = Categoria::find($id);
            $categoria->delete();
            return redirect()->back()->with('error','Categoria eliminada');;
        }else{
            return redirect('logout');
        }
    }
}
