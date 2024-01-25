<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class userController extends Controller
{
    /*
     * Registra un usuario
     */
    function register(Request $request)
    {
        $errors=$this->getCustomErrors();
        $data = $request->validate(['name' => 'required|max:10', 'username' => 'required|unique:users',
            'password' => 'required|max:20', 'email' =>'required|email|unique:users'],$errors
        );

        $data['profile_image']='user-avatars/default-avatar.jpg';$data['admin']=false;$data['followers']=0;
        $data['follows']=0;
        //si el rol es mayor a 0, significa que el usuario es administrador, por lo que podrá añadir o quitar administradores
        if (auth()->user() && auth()->user()->admin>0){
            if ($request['rol']=='admin') $data['admin']=1;
            else $data['admin']=0;
          User::create($data);
          return back();
        }
            User::create($data);
            return $this->login($request);

    }

    /**
     * Inicia sesión y permite iniciar sesión automáticamente si hay una cookie. Esta se añade automáticamente, por lo que
     * si se cierra la sesión por inactividad, la cookie hace que se inicie de nuevo la sesión.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function login (Request $request)   {
        $credentials = $request->only('username','password');
        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $currentDateTime= date("Y-m-d").'T'.date('h:m');
            if ($currentDateTime<auth()->user()->bannedAccount) {
                $request->session()->invalidate();
                return back()->withErrors('Tu cuenta ha sido suspendida hasta: '.auth()->user()->bannedAccount);
            }

            $rememberToken = Str::random(60); //Cookie que permite recordar al usuario
                $user=auth()->user();
                DB::table('users')->where('id', $user->id)->update(['remember_token' => $rememberToken]);
                $userFollows=DB::table('follows')->where('userFollows_id', $user->id)->pluck('userFollowed_id');
                $likedGames=DB::table('likes')->where('userId', $user->id)->pluck('idGame')->all();

                //Sesiones que guardan los usuarios que se siguen y los juegos favoritos, con el fin de no hacer tantas consultas
            // a la base de datos y optimizar la velicidad de las peticiones asíncronas
                session(['userFollows' => $userFollows]);
            session(['likedGames' => $likedGames]);
               return redirect(url()->previous())->withCookie(cookie()->forever('remember_me', $rememberToken));
        }
        else return back()->withErrors('No se ha podido iniciar sesión. Introduce los datos correctamente');
    }
    /*
     * Permite al usuario cerrar la sesión
     * */
    function logout (Request $request)   {
        if (!auth()->check()) return redirect('/');
        $user=auth()->user();
        DB::table('users')->where('id', $user->id)->update(['remember_token' => null]);
        $request->session()->invalidate();
        return redirect(url()->previous())->withCookie(Cookie::forget('remember_me'));
    }
    /*
     * Lista de todos los errores personalizados
     */
    function getCustomErrors(){
        return [
            'name.required'=>'Nombre requerido',
            'name.max'=>'Nombre demasiado largo, introduce uno nuevo',
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'username.required' => 'Nombre de usuario requerido',
            'email.required' => 'Correo electrónico requerido',
            'email.unique' => 'La dirección de correo electrónico ya está registrada.',
            'password.required' => 'Contraseña requerida',
            'email.email'=>'No has introducido una dirección de correo electrónico',
            'password.max'=>'Contraseña demasiado larga, introduce una nueva'
        ];
    }
    /*
     * Elimina un usuario de la base de datos
     */
    function deleteUser($id){
        $user = User::find($id);
        if ($user && $user->id != auth()->user()->id){
            if (auth()->user()->admin==2){
                if ($user->admin>1) return back()->withErrors('No puedes eliminar a un súper usuario');
                $user->delete();
                return back();
            }
            else{
                if ($user->admin>1) return back()->withErrors('No puedes eliminar a súper usuario');
                if ($user->admin==1) return back()->withErrors('No puedes eliminar a otro administrador');
                $user->delete();
                return back();
            }
        }
        else return back()->withErrors('No puedes eliminarte desde el panel de control. Accede a los ajustes de tu perfil');

    }
    /*
     * Elimina o añade el rol de administrador
     */
    function toggleAdmin($id){
        $user = User::find($id);
        if ($user && $user->id != auth()->user()->id){
           if (auth()->user()->admin==2){
               if ($user->admin>1) return back()->withErrors('No puedes cambiarle el rol a un súper usuario');
               if ($user->admin==0)$user->admin=1;
               else $user->admin=0;
               $user->save();
               return back();
           }
           else{
               if ($user->admin>1) return back()->withErrors('No puedes cambiarle el rol a un súper usuario');
               if ($user->admin==1) return back()->withErrors('No puedes cambiarle el rol a otro administrador');
               $user->admin=1;
               $user->save();
               return back();
           }
        }
        else return back()->withErrors('No puedes cambiarte de rol a ti mismo');
    }
    /*
     * Aplica restricciones a un usuario
     */
    function banUser(Request $request){
        $data=$request->validate(['username'=>'required','banDateTime'=>'required'],[
            'username.required'=>'Por favor, escribe todos los datos',
            'banDateTime.required'=>'Por favor, escribe todos los datos',]);
        $currentDateTime= date("Y-m-d").'T'.date('h:m');
        if ($currentDateTime>$data['banDateTime']) return back()->withErrors('Introduce una fecha válida');

           $userID= DB::table('users')->where('username', $data['username'])->value('id');
           $user = User::find($userID);
        if ($user && $user->id != auth()->user()->id){
            if (auth()->user()->admin==2){
                if ($user->admin>1) return back()->withErrors('No puedes cambiarle el rol a un súper usuario');
                $user->bannedAccount=$data['banDateTime'];
                $user->save();
                return back();
            }
            else{
                if ($user->admin>1) return back()->withErrors('No puedes sancionar a un súper usuario');
                if ($user->admin==1) return back()->withErrors('No puedes sancionar a otro administrador');
                $user->bannedAccount=$data['banDateTime'];
                $user->save();
                return back();
            }
        }
        else return back()->withErrors('No puedes sancionarte a ti mismo');
    }
    /*
     * Elimina las restricciones aplicadas a un usuario desde administrador
     */
function removeBan(Request $request){
    $data=$request->validate(['username'=>'required'],['No has especificado un usuario al que eliminar las sanciones']);
    $currentDateTime= date("Y-m-d").'T'.date('h:m');
    $userID= DB::table('users')->where('username', $data['username'])->value('id');
    $user = User::find($userID);
    if ($user && $user->id != auth()->user()->id){
        if (auth()->user()->admin==2){
            if ($user->admin>1) return back()->withErrors('No puedes eliminar sanciones a un súper usuario');
            $user->bannedAccount=null;
            $user->save();
            return back();
        }
        else{
            if ($user->admin>1) return back()->withErrors('No puedes eliminar sanciones a un súper usuario');
            if ($user->admin==1) return back()->withErrors('No puedes eliminar sanciones a otro administrador');
            $user->bannedAccount=null;
            $user->save();
            return back();
        }
    }
}
/*
 * Permite seguir y dejar de seguir a los usuarios. Se activa con una petición asíncrona desde javascript. Al hacer login,
 * se creó una sesión que consiste en un array con las id de usuario que se siguen para no tener que leer dicha información
 * constantemente y para que la petición asíncrona se realize más rápido. Esta sesión se modifica cada vez que se sigue o se deja de seguir
 */
function toggleFollow(Request $request)
{
    /*
     * Si da error, es porque ya se sigue al usuario, por lo que no se puede volver a introducir los mismos datos en la misma
     * tabla, así que se ejecuta el código dentro de catch
     */
    try {


        DB::table('follows')->insert([
            'userFollows_id' => auth()->user()->id,
            'userFollowed_id' => $_POST['visitedUser'],
        ]);
        $userFollows=session('userFollows');
        if (is_null($userFollows))$userFollows=DB::table('follows')->where('userFollows_id', auth()->user()->id)->pluck('userFollowed_id');
        if (gettype($userFollows)!='array') $userFollows = $userFollows->all();
      //  if (gettype($userFollows!='array')) $userFollows = $userFollows->all();
        $userFollows[]= intval($_POST['visitedUser']);
        session(['userFollows' => $userFollows]);
        return json_encode( 1   );

    } catch (\Exception $e) {
        DB::table('follows')->where('userFollows_id', '=', $_POST['loggedInUser'])->
        where('userFollowed_id', '=', $_POST['visitedUser'])->delete();
        $userFollows=session('userFollows');
            if (gettype($userFollows)!='array') $userFollows = $userFollows->all();
        $index= array_search($_POST['visitedUser'],$userFollows);
        unset($userFollows[$index]);
        $userFollows = array_values($userFollows);
        session(['userFollows' => $userFollows]);
        return json_encode(0);
    }
}
/*
 * Actualiza y valida la nueva contraseña
 */
    function updatePassword(Request $request){
        $errors=$this->getCustomErrors();
        $request->validate(['password' => 'required|max:20', 'passwordConfirm' => 'required'],['password.required'=>'Rellena los dos campos',
            'password.max'=>'La contraseña no puede superar los 20 caracteres','password.confirm'=>'Debes confirmar la contraseña']);
        if ($request['password']===$request['passwordConfirm']) {
            $user=auth()->user();
            $user['password']=$request['password'];
            $user->save();
            return back()->with(['success'=>'<span class="errors" style="color: green">Contraseña actualizada con éxito</span>']);
        }
        else return back()->withErrors('Las contraseñas no coinciden');
    }
    /*
     * Actualiza la información del usuario
     */
    function updateUser(Request $request){
        $errors=$this->getCustomErrors();
        $request->validate(['name' => 'required|max:10', 'username' => 'required','email'=>'required'],$errors);
        $user=auth()->user();
        if ($request->hasFile('imgUpload')){ //Si se ha subido imagen, se actualiza, si no se mantiene
            $image=$request->file('imgUpload');
            //uniqid genera un id único por si se varios usuarios suben un archivo con el mismo nombre.
        $name=uniqid( $request['name']). '.' . $image->getClientOriginalExtension();
        $imgDbName='user-avatars/'.$name;
        $image->move(public_path('/user-avatars'),$name);
        $user->profile_image=$imgDbName;
        }
        $user->name=$request['name'];
        $user->username=$request['username'];
        $user->email=$request['email'];
        $user->save();
        return back()->with(['success'=>'<span class="errors" style="color: green">Datos actualizados con éxito</span>']);
    }
}

