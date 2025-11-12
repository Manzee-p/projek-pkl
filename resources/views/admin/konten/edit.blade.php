@extends('layouts.admin.master')
@section('pageTitle', 'Edit Laporan (Tim Konten)')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Edit Laporan: {{ $report->judul }}</h5>
            </div>

            {{-- ERROR VALIDATION --}}
            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form method="POST" action="{{ route('tim_konten.report.update', $report->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" value="{{ $report->judul }}" class="form-control" readonly>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi / Catatan Konten</label>
                        <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi', $report->deskripsi) }}</textarea>
                    </div>

                    {{-- Status khusus tim konten --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Laporan <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="diproses" {{ old('status', $report->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ old('status', $report->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Lampiran baru --}}
                    <div class="mb-3">
                        <label class="form-label">Lampiran Baru (Opsional)</label>
                        <input type="file" name="lampiran" class="form-control">
                        @if ($report->lampiran)
                            <p class="mt-2">
                                Lampiran lama:
                                <a href="{{ Storage::url($report->lampiran) }}" target="_blank" class="text-primary">
                                    Lihat Lampiran
                                </a>
                            </p>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tim_konten.report.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-content-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
