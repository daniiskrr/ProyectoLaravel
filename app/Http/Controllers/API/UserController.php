<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller{
    public function index(){
        // Se recuperan todos los usuarios y sus roles con el método with de Eloquent
        $users = User::with('roles')->get()->toArray();
        // Se utiliza array_map para aplicar una función a cada usuario
        $users = array_map(function($user) {
            // Se agrega el nombre del rol al array del usuario
            $user['rol'] = $user['roles'][0]['nombre'];
            // Se elimina la propiedad 'roles' del array del usuario para evitar redundancias
            unset($user['roles']);
            return $user;
        }, $users);
        return $users;
    }


    public function login(Request $request){
        $credentials=[
            'email' => $request->email,
            'password' => $request->password
        ];


        if (Auth::attempt($credentials)) {
            $success = true;
            $message = "Usuario logeado correctamente";
        }else {
            $success = false;
            $message = "Usuario no autorizado";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }

    public function register(Request $request){
        try{
            $user = new User();
            $user->nombre = $request->nombre;
            $user->apellidos = $request->apellidos;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->fecha_nacimiento = $request->fecha_nacimiento;
            $user->direccion = $request->direccion;
            $user->telefono = $request->telefono;
            $user->save();
            $user->roles()->sync(1);

            $success = true;
            $message = "Usuario registrado correctamente";
        } catch(\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response=[
            'success' => $success,
            'message' => $message,
        ];

        return response()->json($response);
    }

    public function logout(){
        try{
            Session::flush();

            $success = true;
            $message = "Logout correcto";
        }catch(\Illuminate\Database\QueryException $ex){
            $success = false;
            $message = $ex->getMessage();
        }

        $response=[
            'success' => $success,
            'message' => $message,
        ];


        return response()->json($response);
    }

    public function add(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required',
            'telefono' => 'required',
            'tipo_suscripcion' => 'required',
            'duracion' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        if ($request->rol == '1') {
            $user->roles()->sync([1]); // Asignar rol de Administrador
        } else {
            $user->roles()->sync([2]); // Asignar rol de Usuario
        }

        return response()->json(['success' => 'Usuario creado correctamente']);
    }

    public function edit($id)
    {
        $usuario = User::find($id);

        //Se recupera el usuario con el ID correspondiente y su rol
        $usuario = User::with('roles')->find($id);

        // Se agrega el nombre del rol al array del usuario
        $usuario['rol'] = $usuario['roles'][0]['nombre'];

        // Se elimina la propiedad 'roles' del array del usuario para evitar redundancias
        unset($usuario['roles']);

        return response()->json($usuario);

    }


    public function update(Request $request, $id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json(['error' => 'El usuario no existe'], 404);
        }
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'fecha_nacimiento' => 'required|date',
            'direccion' => 'required',
            'telefono' => 'required|numeric',
            'tipo_suscripcion' => 'required',
            'duracion' => 'nullable',
            'email' => 'required',
            'password' => 'nullable',
            'rol' => 'required' // Agrega validación para el campo 'rol'
        ]);

        $input = $request->all();


        if($request->has('password')){
            $input['password'] = bcrypt($input['password']);
        }

        $usuario->update($input);
        //Actualiza el rol del usuario
        $usuario->roles()->sync(Role::where('nombre', $request->input('rol'))->firstOrFail()->id);

        return response()->json(['success'=> 'Usuario Actualizado!']);
    }

    public function eliminaUsuario($id)
    {
        $usuario = User::findOrFail($id);

        // Elimina todos los registros en la tabla `users_roles` para este usuario
        $usuario->roles()->detach();

        $usuario->delete();
    }


}


