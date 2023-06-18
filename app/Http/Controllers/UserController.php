<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use App\Models\Producto;
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
        $users = User::all();
        return response()->json($users);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();

        if (!$user) {
            return response()->json(['mensaje' => 'El usuario no existe'], 404);
        }

        $user->delete();

        return response()->json(['mensaje' => 'usuario eliminado con éxito'], 200);
    }
}
