@extends('layouts.admin.master')
@section('pageTitle', 'Edit Laporan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5>Edit Laporan: {{ $report->judul }}</h5>
            <a href="{{ route('tim_konten.report.index') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('tim_konten.report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- JUDUL --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Judul</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $report->judul) }}" required>
                    @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="5" class="form-control" required>{{ old('deskripsi', $report->deskripsi) }}</textarea>
                    @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- LAMPIRAN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Lampiran (opsional)</label>
                    <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    @if($report->lampiran)
                        <div class="mt-2">
                            <small>Lampiran saat ini:
                                <a href="{{ Storage::url($report->lampiran) }}" target="_blank">
                                    {{ basename($report->lampiran) }}
                                </a>
                            </small>
                        </div>
                    @endif
                    @error('lampiran') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-check"></i> Simpan
                    </button>
                    <a href="{{ route('tim_konten.report.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-close"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
