<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Docente;
use App\Models\Asistencia;

class SyncToCentral extends Command
{
    protected $signature = 'sync:central';
    protected $description = 'Sincroniza datos locales con el servidor central';

    public function handle()
    {
        $centralUrl = 'https://apichecador.carasoftweb.com/api/sincronizar';

        // =====================================================
        // 1️⃣ USUARIOS
        // =====================================================
        $usuarios = User::where('sincronizado', false)->get();

        if ($usuarios->count() > 0) {
            $this->info("Enviando {$usuarios->count()} usuarios...");

            $payload = $usuarios->map(function ($u) {
                return [
                    'uuid' => $u->uuid,
                    'usuario' => $u->usuario,
                    'email' => $u->email,
                    'rol_id' => $u->rol_id,
                ];
            });

            $this->info('Payload usuarios: ' . $payload->toJson());

            $response = Http::withoutVerifying()->post("$centralUrl/usuarios", [
                'usuarios' => $payload
            ]);

            $this->info('HTTP Status: ' . $response->status());
            $this->info('Response Body: ' . $response->body());

            if ($response->successful() && $response->json('status') === 'ok') {
                User::whereIn('id', $usuarios->pluck('id'))->update(['sincronizado' => true]);
                $this->info("✅ Usuarios sincronizados correctamente.");
            } else {
                $this->error("❌ Error al sincronizar usuarios.");
            }
        } else {
            $this->info("No hay usuarios pendientes por sincronizar.");
        }

        // =====================================================
        // 2️⃣ DOCENTES
        // =====================================================
        $docentes = Docente::with('user')
            ->where('sincronizado', false)
            ->whereHas('user')
            ->get();

        if ($docentes->count() > 0) {
            $this->info("Enviando {$docentes->count()} docentes...");

            $payload = $docentes->map(function ($d) {
                return [
                    'uuid' => $d->uuid,
                    'nombre' => $d->nombre,
                    'apellidop' => $d->apellidop,
                    'apellidom' => $d->apellidom,
                    'direccion' => $d->direccion,
                    'email' => $d->email,
                    'telefono' => $d->telefono,
                    'descriptor' => $d->descriptor,
                    'plantel_id' => $d->plantel_id,
                    'user_uuid' => $d->user->uuid,
                ];
            });

            $this->info('Payload docentes: ' . $payload->toJson());

            $response = Http::withoutVerifying()->post("$centralUrl/docentes", [
                'docentes' => $payload
            ]);

            $this->info('HTTP Status: ' . $response->status());
            $this->info('Response Body: ' . $response->body());

            if ($response->successful() && $response->json('status') === 'ok') {
                Docente::whereIn('id', $docentes->pluck('id'))->update(['sincronizado' => true]);
                $this->info("✅ Docentes sincronizados correctamente.");
            } else {
                $this->error("❌ Error al sincronizar docentes.");
            }
        } else {
            $this->info("No hay docentes pendientes por sincronizar.");
        }

        // =====================================================
        // 3️⃣ CHECADAS
        // =====================================================
        $checadas = Asistencia::with('docente')
            ->where('sincronizado', false)
            ->whereHas('docente')
            ->get();

        if ($checadas->count() > 0) {
            $this->info("Enviando {$checadas->count()} checadas...");

            $payload = $checadas->map(function ($a) {
                return [
                    'uuid' => $a->uuid,
                    'fecha_hora' => $a->fecha_hora
                        ? $a->fecha_hora->format('Y-m-d H:i:s')
                        : now()->format('Y-m-d H:i:s'),
                    'tipo' => $a->tipo,
                    'foto_url' => $a->foto_url,
                    'docente_uuid' => $a->docente->uuid,
                ];
            });

            $this->info('Payload checadas: ' . $payload->toJson());

            $response = Http::withoutVerifying()->post("$centralUrl/checadas", [
                'checadas' => $payload
            ]);

            $this->info('HTTP Status: ' . $response->status());
            $this->info('Response Body: ' . $response->body());

            if ($response->successful() && $response->json('status') === 'ok') {
                Asistencia::whereIn('id', $checadas->pluck('id'))->update(['sincronizado' => true]);
                $this->info("✅ Checadas sincronizadas correctamente.");
            } else {
                $this->error("❌ Error al sincronizar checadas.");
            }
        } else {
            $this->info("No hay checadas pendientes por sincronizar.");
        }

        return Command::SUCCESS;
    }
}
