<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prioritas;
use Illuminate\Support\Facades\Validator;

class PrioritasController extends Controller
{
    // Ambil semua data prioritas
    public function index()
    {
        $prioritas = Prioritas::all();

        return view('admin.prioritas.index', compact('prioritas'));
    }

    // Form tambah prioritas
    public function create()
    {
        return view('admin.prioritas.create');
    }

    // Tambah prioritas baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_prioritas' => 'required|string|max:50|unique:priorities,nama_prioritas',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Prioritas::create([
            'nama_prioritas' => $request->nama_prioritas,
        ]);

        return redirect()->route('prioritas.index')
            ->with('success', 'Prioritas baru berhasil ditambahkan');
    }

    // Detail prioritas
    public function show($id)
    {
        $prioritas = Prioritas::findOrFail($id);

        return view('admin.prioritas.show', compact('prioritas'));
    }

    // Form edit prioritas
    public function edit($id)
    {
        $prioritas = Prioritas::findOrFail($id);

        return view('admin.prioritas.edit', compact('prioritas'));
    }

    // Update prioritas
    public function update(Request $request, $id)
    {
        $prioritas = Prioritas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_prioritas' => 'required|string|max:50|unique:priorities,nama_prioritas,' . $id . ',prioritas_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $prioritas->update([
            'nama_prioritas' => $request->nama_prioritas,
        ]);

        return redirect()->route('prioritas.index')
            ->with('success', 'Prioritas berhasil diperbarui');
    }

    // Hapus prioritas
    public function destroy($id)
    {
        $prioritas = Prioritas::findOrFail($id);
        $prioritas->delete();

        return redirect()->route('prioritas.index')
            ->with('success', 'Prioritas berhasil dihapus');
    }
}