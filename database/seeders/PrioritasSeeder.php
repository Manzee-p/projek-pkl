<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritasSeeder extends Seeder
{
    public function run()
    {
        DB::table('priorities')->insert([
            ['prioritas_id' => 1, 'nama_prioritas' => 'Low'],
            ['prioritas_id' => 2, 'nama_prioritas' => 'Medium'],
            ['prioritas_id' => 3, 'nama_prioritas' => 'High'],
            ['prioritas_id' => 4, 'nama_prioritas' => 'Critical'],
        ]);
    }
}

