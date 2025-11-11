@extends('layouts.admin.master')
@section('pageTitle', 'Detail Laporan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5>Detail Laporan #{{ $report->id }}</h5>
            <a href="{{ route('tim_konten.report.index') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Judul:</strong> {{ $report->judul }}</p>
                    <p><strong>Kategori:</strong> {{ $report->kategori->nama_kategori ?? '-' }}</p>
                    <p><strong>Prioritas:</strong> {{ $report->prioritas->nama_prioritas ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Dibuat oleh:</strong> {{ $report->user->name ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $report->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <div class="mb-3">
                <h6>Deskripsi:</h6>
                <p>{{ $report->deskripsi }}</p>
            </div>

            @if($report->lampiran)
                <div class="mb-3">
                    <h6>Lampiran:</h6>
                    <a href="{{ Storage::url($report->lampiran) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="mdi mdi-file"></i> Lihat Lampiran
                    </a>
                </div>
            @endif

            <div class="text-end">
                <a href="{{ route('tim_konten.report.edit', $report->id) }}" class="btn btn-warning">
                    <i class="mdi mdi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
