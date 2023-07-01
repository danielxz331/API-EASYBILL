<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->tipo_usuario = $request->tipo_usuario;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $archivo_solicitud = $request->file('file');
        $destinationPath = date('FY') . '/';
        $profileImage = time() . '.' . $request->file('file')->getClientOriginalExtension();
        $ruta = $archivo_solicitud->move('storage/' . $destinationPath, $profileImage);

        $user->ruta_imagen_usuario = "$ruta";
        $user->assignRole($request->tipo_usuario); //Asignar rol al usuario (administrador, cajero)
        $user->save();

        return response()->json([
            'message' => 'usuario creado exitosamente!',
            'users' => $user
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('tipo_usuario')) {
            $user->tipo_usuario = $request->tipo_usuario;
            $user->assignRole($request->tipo_usuario);
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('file')) {
            $archivo_solicitud = $request->file('file');
            $destinationPath = date('FY') . '/';
            $profileImage = time() . '.' . $request->file('file')->getClientOriginalExtension();
            $ruta = $archivo_solicitud->move('storage/' . $destinationPath, $profileImage);

            $user->ruta_imagen_usuario = $ruta;
        }

        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente!',
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token" => $token], Response::HTTP_ACCEPTED)->withCookie($cookie);
        } else {
            return response(['message' => 'credenciales invalidas'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function userProfile(Request $request)
    {
        return response()->json([
            "message" => "userProfile ok",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }

    public function logout()
    {
        $cookie = Cookie::forget('cookie_token');
        return response(["message" => "Cierre de sesion OK"], Response::HTTP_OK)->withCookie($cookie);
    }

    public function allUsers()
    {
        $users = User::where('tipo_usuario', '!=', 'administrador')->where('activo', 1)->get();
        return response()->json($users);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function deleteUser($id)
    {

        $ventas = Venta::where('id_user', $id)->get();

        $user = User::find($id);

        if (!$user) {
            return response()->json(['mensaje' => 'El usuario no existe'], 404);
        }

        if ($ventas > 0) {
            $user->activo = 0;  
            $user->save();
            return response()->json(['mensaje' => 'El usuario ha sido bloqueado'], 200);
        } else {
            $user->delete();
            return response()->json(['mensaje' => 'El usuario ha sido eliminado'], 200);
        }

    }

    public function recuperar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'No se encontró ningún usuario con esa dirección de correo electrónico'], 404);
        }

        $token = app('auth.password.broker')->createToken($user);

        // Generar la URL para restablecer la contraseña
        $resetPasswordUrl = url(config('app.url') . route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ], false));

        // Envío del correo electrónico
        Mail::to($user->email)->send(new ResetPassword($resetPasswordUrl));

        return response()->json(['message' => 'Se ha enviado un enlace para restablecer la contraseña al correo electrónico proporcionado']);
    }
}
