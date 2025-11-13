<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'rol_id' => 'required|numeric',
        ]);

        $user = User::create([
            'usuario' => $request->usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();



        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        // Obtener docente relacionado con solo los campos necesarios
        $docente = $user->docente()->select('id', 'nombre', 'apellidop', 'apellidom', 'plantel_id')->first();

        // Obtener plantel del docente con solo los campos necesarios
        $plantel = null;
        if ($docente && $docente->plantel_id) {
            $plantel = $docente->plantel()->select('id', 'nombrePlantel', 'clavePlantel')->first();
        }

        // Devolver solo los campos de user
        $userData = [
            'email' => $user->email,
            'usuario' => $user->usuario,
            'rol_id' => $user->rol_id,
            'docente' => $docente,
            'plantel' => $plantel,
        ];

        return response()->json(['user' => $userData, 'token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    public function userProfile(Request $request)
    {
        return response()->json($request->user());
    }
}
