<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            DB::table('tiket_statuses')->insert([
                ['status_id' => 1, 'nama_status' => 'Pending'],
                ['status_id' => 2, 'nama_status' => 'Selesai'],
                ['status_id' => 3, 'nama_status' => 'Ditolak'],
            ]);
        }
}
