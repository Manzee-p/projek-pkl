<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrioritasController extends Controller
{
    public function index()
    {
        $prioritas = [
            ['id' => 1, 'nama' => 'Rendah'],
            ['id' => 2, 'nama' => 'Sedang'],
            ['id' => 3, 'nama' => 'Tinggi'],
            ['id' => 4, 'nama' => 'Urgent'],
        ];

        return response()->json([
            'status'  => 200,
            'message' => 'Data prioritas tiket berhasil diambil',
            'data'    => $prioritas,
        ]);
    }
}
