<?php
namespace App\Http\Controllers;
use App\Binnacle;
use App\Mail\UsuarioActivado;
use App\Responsable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\People;
use App\Rol;
use App\User;
use App\UserRol;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Constraint\IsTrue;

class UsuarioController extends Controller {

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
            $usersActives = DB::table('persona')
                ->join('usuario','usuario.id_persona','=','persona.id')
                ->join('usuario_rol','usuario_rol.id_usuario','=','usuario.id')
                ->join('rol','rol.id','=','usuario_rol.id_rol')
                ->where('usuario.estatus','=',true)
                ->select('persona.id',
                    'persona.nombre',
                    'persona.a_paterno',
                    'persona.a_materno',
                    'persona.curp',
                    'persona.rfc',
                    'persona.correo',
                    'persona.telefono',
                    'persona.domicilio',
                    'rol.descripcion')
                ->get();
            $usersInActives = DB::table('persona')
                ->join('usuario','usuario.id_persona','=','persona.id')
                ->join('usuario_rol','usuario_rol.id_usuario','=','usuario.id')
                ->join('rol','rol.id','=','usuario_rol.id_rol')
                ->where('usuario.estatus','=',false)
                ->select('persona.id',
                    'persona.nombre',
                    'persona.a_paterno',
                    'persona.a_materno',
                    'persona.curp',
                    'persona.rfc',
                    'persona.correo',
                    'persona.telefono',
                    'persona.domicilio',
                    'rol.descripcion')
                ->get();
            if($_SESSION['permiso'] == 1){
                return view('Usuarios.index',compact('usersActives','usersInActives'));
            }else{
                return redirect('login');
            }
        }
        else{
            return redirect('logout');
        }
    }
    public function store(Request $request)
    {
        if($this->sesion()){
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
                    return redirect('usuario')->with('success','Usuario creado');
                }
                else{
                    return back()->with('error','No coinciden las contraseñas');
                }
            }
            else{
                return back()->with('error','No existe ninguna contraseña');
            }
        }else{
            return redirect('logout');
        }
    }
    public function create()
    {
        if($this->sesion()){
            if($_SESSION['permiso'] == 1){
                return view('Usuarios.create');
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function edit($usuario)
    {
        if($this->sesion()){
            $usuario = People::find($usuario);
            if($_SESSION['permiso'] == 1){
                return view('Usuarios.update',compact('usuario'));
            }else{
                return redirect('login');
            }
        }else{
            return redirect('logout');
        }
    }
    public function  editUsuario($usuario_id){
        if($this->sesion()){
            $infoUsuario = DB::table('persona')
                ->join('usuario','usuario.id_persona','=','persona.id')
                ->select('persona.correo','usuario.usuario')
                ->where('usuario.id','=',$usuario_id)->get();
            $usuario = DB::table('usuario_rol')->where('id_usuario','=',$usuario_id)->get();
            $id_rol = $usuario[0]->id_rol;
            $rol = DB::table('rol')->where('id','=',$id_rol)->get();
            $roles = Rol::pluck('descripcion','id');
            if($_SESSION['permiso'] == 1){
                return view( 'Usuarios.updateUsuario',compact('usuario_id','infoUsuario','rol','roles'));
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
            $people = People::find($request->usuario);
            $user = User::where('id_persona',$people->id)->first();
            $user->usuario = $request->correo;
            $user->save();
            $people->update($request->all());
            return redirect('/usuario')->with('success','Usuario actualizado');
        }else{
            return redirect('logout');
        }
    }
    public function updateUsuario(Request $request)
    {
        if($this->sesion()){
            $user = User::find($request->usuario_id);
            $people = People::find($user->id_persona);
            $rol = UserRol::where('id_usuario',$user->id)->first();
            $rol->id_rol = $request->rol;
            $rol->save();
            if ($request->input('contrasena_confirmar') != null && $request->input('contrasena') != null){
                if($request->input('contrasena') == $request->input('contrasena_confirmar')){
                    //update dates and password
                    $user->contrasena = md5($request->contrasena);
                    $people->correo = $request->correo;
                    $user->usuario = $request->correo;
                    $user->save();
                    $people->save();
                    if($request->rol != 3){
                        $responsable = Responsable::where('id_persona',$people->id)->first();
                        if($responsable != null){
                            $responsable->id_rol = $request->rol;
                            $responsable->save();
                        }else{
                            $responsable = new Responsable();
                            $responsable->id_rol = $request->rol;
                            $responsable->id_persona = $people->id;
                            $responsable->save();
                        }
                    }else{
                        $responsable = Responsable::where('id_persona',$people->id);
                        if($responsable != null){
                            $responsable = Responsable::where('id_persona',$people->id);
                            $responsable->delete();
                        }
                    }
                    return redirect('/usuario')->with('success','Usuario Actualizado');
                }
                else{
                    //echo "Las contraseñas no coinciden";
                    return back()->with('error','Las contraseñas no coinciden');
                }
            }
            else{
                //Update dates without password
                $people->correo = $request->correo;
                $user->usuario = $request->correo;
                $user->save();
                $people->save();
                if($request->rol != 3){
                    $responsable = Responsable::where('id_persona',$people->id)->first();
                    if($responsable != null){
                        $responsable->id_rol = $request->rol;
                        $responsable->save();
                    }else{
                        $responsable = new Responsable();
                        $responsable->id_rol = $request->rol;
                        $responsable->id_persona = $people->id;
                        $responsable->save();
                    }
                }else{
                    $responsable = Responsable::where('id_persona',$people->id);
                    if($responsable != null){
                        $responsable = Responsable::where('id_persona',$people->id);
                        $responsable->delete();
                    }
                }
                return redirect('/usuario')->with('success','Usuario Actualizado');
            }
        }else{
            return redirect('logout');
        }
    }
    public function editStatus($usuario_id){
        if($this->sesion()){
            $user = User::where('id_persona',$usuario_id)->first();
            if($user->estatus == false)
            {
                $user->estatus = true;
                $user->save();
                Mail::to($user->usuario)->sendNow(new UsuarioActivado());
                return back()->with('success','Usuario Activado');
            }else{
                $user->estatus = false;
                $user->save();
                return back()->with('success','Usuario Desactivado');
            }
        }else{
            return redirect('logout');
        }
    }
    public function delete($id)
    {
        if($this->sesion()){
            //Hacer que el usuario se desactive
            $people = People::find($id);
            $user = User::where('id_persona',$people->id)->first();
            $user->estatus = false;
            $user->save();
            return redirect()->back()->with('error','Usuario borrado');
        }else{
            return redirect('logout');
        }
    }
    public function show($user){
        if($this->sesion()){
            $usuario = DB::table('usuario')->where('id_persona','=',$user)->get();
            $bitacoras = DB::table('bitacora')->where('id_usuario','=',$usuario[0]->id)->get();
            $user = People::where('id','=',$user)->get();
            $user[0]->usuario = $usuario[0]->usuario;
            $user[0]->id_usuario = $usuario[0]->id;
            $no_registros = sizeof($bitacoras);

            //Rol
            $rol = DB::table('usuario_rol')->where('id_usuario','=',$user[0]->id_usuario)->get();
            $id_rol = $rol[0]->id_rol;
            $rol = DB::table('rol')->where('id','=',$id_rol)->get();
            $user[0]->ultimo_acceso = $bitacoras[$no_registros - 1]->fecha_fin;
            if ($usuario[0]->estatus){
                $user[0]->estatus='Activo';
            }
            else{
                $user[0]->estatus='Inactivo';
            }
            if($_SESSION['permiso'] == 1){
                return view('Usuarios.show',compact('user','bitacoras','no_registros','rol'));
            }else{
                return redirect('login');
            }

        }else{
            return redirect('logout');
        }
    }
}
