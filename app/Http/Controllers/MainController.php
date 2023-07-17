<?php
namespace App\Http\Controllers;
use App\Binnacle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
session_start();
class MainController extends Controller
{
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
    public function index()
    {
        if($this->sesion()){
            return view('Main.index');
        }else{
            return redirect('logout');
        }
    }
}
