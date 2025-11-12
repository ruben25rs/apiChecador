<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Docente;
use App\Models\Asistencia;

class SyncController extends Controller
{
    /**
     * Endpoint central para sincronizar todos los datos
     */
    
    // Sincronizar usuarios
    public function sincronizarUsuarios(Request $request)
    {
        $usuarios = $request->input('usuarios', []);
        Log::info('Payload recibido usuarios: ', $usuarios);

        foreach ($usuarios as $data) {
            User::updateOrCreate(
                ['uuid' => $data['uuid']],
                [
                    'usuario' => $data['usuario'],
                    'email' => $data['email'],
                    'rol_id' => $data['rol_id'],
                    'sincronizado' => true, // ya viene sincronizado
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    }

    // Sincronizar docentes
    public function sincronizarDocentes(Request $request)
    {
        $docentes = $request->input('docentes', []);
        Log::info('Payload recibido docentes: ', $docentes);

        foreach ($docentes as $data) {
            // Buscar el usuario asociado
            $user = User::where('uuid', $data['user_uuid'])->first();
            if (!$user) {
                Log::warning("Usuario no encontrado para docente: " . $data['uuid']);
                continue; // saltar si no existe usuario
            }

            Docente::updateOrCreate(
                ['uuid' => $data['uuid']],
                [
                    'nombre' => $data['nombre'],
                    'apellidop' => $data['apellidop'],
                    'apellidom' => $data['apellidom'],
                    'direccion' => $data['direccion'],
                    'email' => $data['email'],
                    'telefono' => $data['telefono'],
                    'descriptor' => $data['descriptor'] ?? null,
                    'plantel_id' => $data['plantel_id'],
                    'user_id' => $user->id,
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    }

    // Sincronizar checadas
    public function sincronizarChecadas(Request $request)
    {
        $checadas = $request->input('checadas', []);
        Log::info('Payload recibido checadas: ', $checadas);

        foreach ($checadas as $data) {
            $docente = Docente::where('uuid', $data['docente_uuid'])->first();
            if (!$docente) {
                Log::warning("Docente no encontrado para checada: " . $data['uuid']);
                continue;
            }

            Asistencia::updateOrCreate(
                ['uuid' => $data['uuid']],
                [
                    'tipo' => $data['tipo'],
                    'foto_url' => $data['foto_url'] ?? null,
                    'fecha_hora' => $data['fecha_hora'] ?? now(),
                    'docente_id' => $docente->id,
                    'sincronizado' => true,
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    }
}
