@extends('layouts.admin.master')
@section('pageTitle', 'Edit Laporan')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5>Edit Laporan: {{ $report->judul }}</h5>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form method="POST" action="{{ route('tim_teknisi.report.update', $report->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul', $report->judul) }}"
                            class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi / Catatan Teknis</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $report->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran Baru (Opsional)</label>
                        <input type="file" id="lampiran" name="lampiran" class="form-control">
                        @if ($report->lampiran)
                            <p class="mt-2">Lampiran lama:
                                <a href="{{ Storage::url($report->lampiran) }}" target="_blank">Lihat file</a>
                            </p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select id="kategori_id" name="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}"
                                    {{ old('kategori_id', $report->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="prioritas_id" class="form-label">Prioritas</label>
                        <select id="prioritas_id" name="prioritas_id" class="form-control" required>
                            <option value="">-- Pilih Prioritas --</option>
                            @foreach ($priorities as $prioritas)
                                <option value="{{ $prioritas->prioritas_id }}"
                                    {{ old('prioritas_id', $report->prioritas_id) == $prioritas->prioritas_id ? 'selected' : '' }}>
                                    {{ $prioritas->nama_prioritas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('tim_teknisi.report.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
