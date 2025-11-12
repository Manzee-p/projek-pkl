@extends('layouts.admin.master')
@section('pageTitle', 'Detail Laporan (Tim Konten)')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $report->judul }}</h5>
        </div>

        <div class="card-body">
            {{-- Informasi Umum --}}
            <p><strong>Kategori:</strong> {{ $report->kategori->nama_kategori ?? '-' }}</p>
            <p><strong>Prioritas:</strong> {{ $report->prioritas->nama_prioritas ?? '-' }}</p>

            {{-- Status --}}
            <p>
                <strong>Status:</strong>
                @php
                    $badge = match ($report->status) {
                        'review' => 'bg-warning',
                        'revisi' => 'bg-danger',
                        'dipublikasikan' => 'bg-success',
                        default => 'bg-secondary',
                    };
                @endphp
                <span class="badge {{ $badge }}">{{ ucfirst($report->status) }}</span>
            </p>

            {{-- Deskripsi --}}
            <div class="mt-3">
                <p><strong>Deskripsi / Catatan Konten:</strong></p>
                <div class="border rounded p-3 bg-light">
                    {!! nl2br(e($report->deskripsi)) !!}
                </div>
            </div>

            {{-- Lampiran --}}
            @if ($report->lampiran)
                <div class="mt-3">
                    <p><strong>Lampiran:</strong></p>
                    <a href="{{ Storage::url($report->lampiran) }}" target="_blank">
                        <img src="{{ Storage::url($report->lampiran) }}" class="img-thumbnail shadow-sm" width="250" alt="Lampiran">
                    </a>
                </div>
            @endif
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('tim_konten.report.edit', $report->id) }}" class="btn btn-warning btn-sm">
                <i class="mdi mdi-pencil"></i> Edit
            </a>
            <a href="{{ route('tim_konten.report.index') }}" class="btn btn-secondary btn-sm">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
