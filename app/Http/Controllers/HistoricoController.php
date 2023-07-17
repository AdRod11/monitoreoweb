<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\Historico;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Grupo;
use DB;
use App\Http\Requests;
use PHPUnit\Framework\Constraint\IsTrue;

class HistoricoController extends Controller {

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
            $historicos = Historico::all();
            if($_SESSION['permiso'] == 1){
                return view('Historico.index',compact('historicos'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
}
