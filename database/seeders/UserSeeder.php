<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'usuario' => 'root',
            'email' => 'rubenrs.251@gmail.com',
            'password' => Hash::make('root'),
            'rol_id' => 1,
        ]);
    }
}
