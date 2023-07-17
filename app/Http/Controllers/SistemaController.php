<?php
namespace App\Http\Controllers;
use App\Binnacle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Sistema;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SistemaController extends Controller {

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
            $sistema = Sistema::All();
            if($_SESSION['permiso'] == 1){
                return view('Sistemas.index',compact('sistema'));
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
            $sistema = new Sistema();
            $sistema->create($request->all());
            return redirect('/sistema')->with('success','Sistema agregado');;
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Sistemas.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($sistema)
    {
        if($this->sesion()){
            $sistema = Sistema::find($sistema);
            if($_SESSION['permiso'] == 1){
                return view('Sistemas.update',compact('sistema'));
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
            $sistema = Sistema::find($request->sistema);
            $sistema->update($request->all());
            return redirect('/sistema')->with('success','Sistema actualizado');;
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            $sistema = Sistema::find($id);
            $sistema->delete();
            return redirect()->back()->with('error','Sistema elimiando');;
        }else{
            return redirect('logout');
        }
    }
}
