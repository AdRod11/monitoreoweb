<?php

namespace App\Http\Controllers;
use App\Binnacle;
use App\Mail\NuevoUsuario;
use App\People;
use App\User;
use App\UserRol;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\NuevaContrasena;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
session_start();
class LoginController extends Controller
{

  public function index()
  {
      if($_SESSION != null){
          if($_SESSION['token'] != null)
            return redirect('monitoreo');
          else
            return view('Login.login');
      }else{
          return view('Login.login');
      }
  }
  public function viewForgot()
  {
      return view('Login.forgot');
  }
  public function sendEmail(Request $request)
  {
      $contrasena = md5($request->correo.now());
      $user = User::where('usuario',$request->correo)->first();
      $user->contrasena = md5($contrasena);
      $user->save();
      Mail::to($request->correo)->sendNow(new NuevaContrasena($request->correo,$contrasena));
      return redirect('/')->with('success','Se envio un correo con informacion para acceder a tu cuenta');
  }
  public function login(Request $request){
      $admin= User::where('usuario',$request->usuario)
            ->where('contrasena', md5($request->contrasena))
            ->get();
      if(sizeof($admin)>0)
      {
          if($admin[0]->estatus == true){
              $fecha_inicio = now();
              $fecha_fin = now()->addMinutes(30);
              $binnacle = new Binnacle();
              $binnacle->token = md5($admin[0]->usuario.time());
              $binnacle->id_usuario = $admin[0]->id;
              $binnacle->fecha_inicio = $fecha_inicio;
              $binnacle->fecha_fin = $fecha_fin;
              $binnacle->save();
              $session_usuario = DB::table('usuario')
                  ->join('usuario_rol','usuario_rol.id_usuario','=','usuario.id')
                  ->join('rol','rol.id','=','usuario_rol.id_rol')
                  ->join('persona','persona.id','=','usuario.id_persona')
                  ->where('usuario.usuario','=',$request->usuario)
                  ->select('rol.id','rol.descripcion','persona.nombre','persona.a_paterno')->first();
              $_SESSION['token'] = $binnacle->token;
              $_SESSION['permiso'] = $session_usuario->id;
              $_SESSION['usuario'] = $request->usuario;
              $_SESSION['permiso_descripcion'] = $session_usuario->descripcion;
              $_SESSION['nombre'] = $session_usuario->nombre.' '.$session_usuario->a_paterno;
              return redirect('monitoreo');
          }else{
              return back()->with('error','Usuario inactivo - Te hemos enviado un correo');
          }
      }
      else {
          //return view('login',compact('login'));
          return back()->with('error','Usuario o Contraseña incorrectos');
      }
  }
  public function create()
  {
      return view('Login.create');
  }
  public function store(Request $request)
  {
      if($request->input('contrasena_confirmar') != null && $request->input('contrasena') != null)
      {
          if($request->input('contrasena_confirmar') == $request->input('contrasena')){
              //insert People
              $people = new People();
              $people->create($request->all());
              //insert user
              $people = People::where('correo',$request->correo)->first();
              $user = new User();
              $user->usuario = $people->correo;
              $user->contrasena = md5($request->contrasena);
              $user->estatus = false;
              $user->id_persona = $people->id;
              $user->save();
              //insert usuario_rol with default id_rol 3
              $user = User::where('id_persona',$user->id_persona)->first();
              $userRol = new UserRol();
              $userRol->id_rol = 3;
              $userRol->id_usuario = $user->id;
              $userRol->save();
              $binnacle = new Binnacle();
              $binnacle->token = md5($user->usuario.time());
              $binnacle->id_usuario = $user->id;
              $binnacle->fecha_inicio = now();
              $binnacle->fecha_fin = now();
              $binnacle->save();
              Mail::to($request->correo)->sendNow(new NuevoUsuario());
              return redirect('/')->with('success','Usuario Creado - Te hemos enviado un correo');
          }
          else{
              return back()->with('error','No coinciden las contraseñas');
          }
      }
      else{
          return back()->with('error','No existe ninguna contraseña');
      }
  }
  public function logout()
  {
      $_SESSION['token'] = null;
      $_SESSION['permiso'] = null;
      $_SESSION['usuario'] = null;
      $_SESSION['permiso_descripcion'] = null;
      $_SESSION['nombre'] = null;
      session_write_close();
      return redirect('/')->with('error','Sesion terminada');
  }
}
