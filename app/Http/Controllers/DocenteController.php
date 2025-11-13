<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'registros.email'       => 'required|email|unique:users,email'
        ], [
            'registros.email.required'  => 'El correo electrónico es obligatorio.',
            'registros.email.unique'    => 'Este correo ya está registrado.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }



        $user = User::create([
            'usuario' => $request->registros['nombre'],
            'email' => $request->registros['email'],
            'password' => Hash::make($request->registros['password']),
            'rol_id' => $request->registros['rol_id'],
        ]);
        
        $docente = Docente::create([
            'nombre'=> $request->registros['nombre'],
            'apellidop'=> 'rub',
            'apellidom'=> 'ruiz',
            'direccion'=> 'huaya',
            'email'=> $request->registros['email'],
            'telefono'=> '00000',
            'descriptor'=>json_encode($request->registros['descriptor']),
            'user_id'=>$user->id,
            'plantel_id'=>$request->registros['plantel_id'],
        ]);


        return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function docenteUser($user)
    {
        //

        $user  = User::where('email', $user)->first();

        $docente = Docente::where('user_id', $user->id)->first();

        return response()->json($docente);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function updateDocente(Request $docente)
    {
        //
        $docente = Docente::find($request->plantel_id);  

        if (!$docente) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $docente->descriptor = json_encode($request->descriptor);
        $docente->save();

        return response()->json(['message' => 'Descriptor actualizado correctamente']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $docente = Docente::find($request->plantel_id);  

        if (!$docente) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $docente->descriptor = json_encode($request->descriptor);
        $docente->save();

        return response()->json(['message' => 'Descriptor actualizado correctamente']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Docente $docente)
    {
        //
    }
}
