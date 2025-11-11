@extends('layouts.admin.master')
@section('pageTitle', 'Detail Laporan')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">{{ $report->judul }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Kategori:</strong> {{ $report->kategori->nama_kategori ?? '-' }}</p>
            <p><strong>Prioritas:</strong> {{ $report->prioritas->nama_prioritas ?? '-' }}</p>
            <p><strong>Dari:</strong> {{ $report->user->name ?? '-' }}</p>
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $report->deskripsi }}</p>

            @if($report->lampiran)
                <p><strong>Lampiran:</strong></p>
                <a href="{{ Storage::url($report->lampiran) }}" target="_blank">
                    <img src="{{ Storage::url($report->lampiran) }}" class="img-thumbnail" width="200">
                </a>
            @endif
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('tim_teknisi.report.edit', $report->id) }}" class="btn btn-warning btn-sm">
                <i class="mdi mdi-pencil"></i> Edit
            </a>
            <a href="{{ route('tim_teknisi.report.index') }}" class="btn btn-secondary btn-sm">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
