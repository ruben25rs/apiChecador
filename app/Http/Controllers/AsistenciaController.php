<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsistenciaController extends Controller
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
        //

        $request->validate([
            'tipo' => 'required|in:entrada,salida',
        ]);

        // Guarda la imagen en storage/app/public/checadas/
        $path = $request->file('foto')->store('checadas', 'public');

        //
        $docente = Docente::where('email', $request->email)->first();

        // Guarda en la base de datos solo la ruta
        $checada = Asistencia::create([
            'docente_id' => $docente->id,
            'tipo' => $request->tipo,
            'foto_url' => $path,  
            'fecha_hora' => now(),  
            'sincronizado' => false,
        ]);

        return response()->json([
            'message' => 'Checada registrada correctamente',
            'foto_url' => Storage::url($path),
            'data' => $checada
        ]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function show(Asistencia $asistencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Asistencia $asistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asistencia  $asistencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asistencia $asistencia)
    {
        //
    }
}
