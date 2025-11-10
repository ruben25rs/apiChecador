<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use Illuminate\Http\Request;

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


       

        $user = User::create([
            'usuario' => $request->registros['usuario'],
            'email' => $request->registros['email'],
            'password' => $request->registros['password'],
        ]);
        
        $docente = Docente::create([
            'nombre'=> $request->registros['nombre'],
            'apellidop'=> 'rub',
            'apellidom'=> 'ruiz',
            'direccion'=> 'huaya',
            'email'=> 'rub@gmail.com',
            'telefono'=> '951763267237',
            'descriptor'=>json_encode($request->registros['descriptor']),
            'user_id'=>$user->id
        ]);


        return response()->json($docente);
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

        $user  = User::where('usuario', $user)->first();

        $docente = Docente::where('user_id', $user->id)->first();

        return response()->json($docente);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function edit(Docente $docente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Docente $docente)
    {
        //
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
