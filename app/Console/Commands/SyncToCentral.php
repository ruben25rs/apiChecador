<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Docente;
use App\Models\Asistencia;

class SyncToCentral extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:central';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza datos locales con el servidor central';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $centralUrl = 'https://apichecador.carasoftweb.com/api/sincronizar'; // tu URL

        // USUARIOS
        $usuarios = User::where('sincronizado', false)->get();
        if ($usuarios->isNotEmpty()) {
            $res = Http::post("$centralUrl/usuarios", ['usuarios' => $usuarios]);
            if ($res->ok()) {
                User::where('sincronizado', false)->update(['sincronizado' => true]);
                $this->info('✅ Docentes sincronizados');
            }
        }
        
        // DOCENTES
        $docentes = Docente::where('sincronizado', false)->get();
        if ($docentes->isNotEmpty()) {
            $res = Http::post("$centralUrl/docentes", ['docentes' => $docentes]);
            if ($res->ok()) {
                Docente::where('sincronizado', false)->update(['sincronizado' => true]);
                $this->info('✅ Docentes sincronizados');
            }
        }

        // CHECADAS
        $checadas = Asistencia::where('sincronizado', false)->get();
        if ($checadas->isNotEmpty()) {
            $res = Http::post("$centralUrl/checadas", ['checadas' => $checadas]);
            if ($res->ok()) {
                Asistencia::where('sincronizado', false)->update(['sincronizado' => true]);
                $this->info('✅ Checadas sincronizadas');
            }
        }
    }
}
