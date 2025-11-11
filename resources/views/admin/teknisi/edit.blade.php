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
                <form method="POST" action="{{ route('tim_teknisi.report.update', $report->id) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    @method('PUT')

    <!-- Judul (readonly) -->
    <div class="mb-3">
        <label>Judul</label>
        <input type="text" name="judul" value="{{ $report->judul }}" class="form-control" readonly>
    </div>

    <!-- Deskripsi -->
    <div class="mb-3">
        <label>Catatan Teknis / Progress</label>
        <textarea name="deskripsi" rows="6" class="form-control">{{ old('deskripsi', $report->deskripsi) }}</textarea>
    </div>

    <!-- STATUS KHUSUS TEKNISI -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select" required>
            <option value="diproses" {{ old('status', $report->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai" {{ old('status', $report->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <!-- Lampiran baru -->
    <div class="mb-3">
        <label>Lampiran Baru</label>
        <input type="file" name="lampiran" class="form-control">
        @if($report->lampiran)
            <p>Lampiran lama: <a href="{{ Storage::url($report->lampiran) }}" target="_blank">Lihat</a></p>
        @endif
    </div>

    <button type="submit" class="btn btn-success">Simpan & Update Status</button>
</form>
            </div>
        </div>
    </div>
@endsection
