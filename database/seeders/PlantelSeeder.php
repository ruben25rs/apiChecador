<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PlantelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        for ($i=1; $i < 269; $i++) { 
            // code...
            DB::table('planteles')->insert([
                'numPlantel' => str_pad($i, 3, '0', STR_PAD_LEFT),
                'nombrePlantel' => Str::random(10)
            ]);
        }
    }
}
