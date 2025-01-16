<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cargos')->insert([
            ['nombre_cargo' => 'Gerente'],
            ['nombre_cargo' => 'Analista'],
            ['nombre_cargo' => 'Desarrollador'],
        ]);
    }
}
