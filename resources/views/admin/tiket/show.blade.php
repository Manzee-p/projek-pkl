@extends('layouts.admin.master')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Tiket</h4>
            <a href="{{ route('admin.tiket.index') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th style="width: 25%">Kode Tiket</th>
                    <td>{{ $tiket->kode_tiket }}</td>
                </tr>
                <tr>
                    <th>Nama User (Pembuat)</th>
                    <td>{{ $tiket->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Event</th>
                    <td>{{ $tiket->event->nama_event ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $tiket->kategori->nama_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Prioritas</th>
                    <td>{{ $tiket->prioritas->nama_prioritas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-info text-dark">{{ $tiket->status->nama_status ?? '-' }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Waktu Dibuat</th>
                    <td>{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d/m/Y H:i') }}</td>
                </tr>

                <tr>
                    <th>Ditugaskan Kepada</th>
                    <td>
                        @if($tiket->assignedTo)
                            <span class="badge bg-success">
                                {{ $tiket->assignedTo->name }} ({{ ucfirst($tiket->assignedTo->role) }})
                            </span>
                        @else
                            <span class="text-muted">Belum ditugaskan</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $tiket->deskripsi ?? '-' }}</td>
                </tr>

                @if(!empty($tiket->lampiran))
                <tr>
                    <th>Lampiran</th>
                    <td>
                        <a href="{{ Storage::url($tiket->lampiran) }}" target="_blank">
                            <img src="{{ Storage::url($tiket->lampiran) }}" alt="Lampiran" 
                                 class="img-thumbnail" width="250">
                        </a>
                    </td>
                </tr>
                @endif

                @if($tiket->waktu_selesai)
                <tr>
                    <th>Waktu Selesai</th>
                    <td>{{ \Carbon\Carbon::parse($tiket->waktu_selesai)->format('d/m/Y H:i') }}</td>
                </tr>
                @endif
                
            </table>
        </div>
    </div>
</div>


{{-- ================================ --}}
{{--    KOMENTAR USER / EVALUASI      --}}
{{-- ================================ --}}
@if($tiket->komentars && $tiket->komentars->count() > 0)
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="lni lni-comments text-primary"></i> Komentar & Evaluasi User
            </h5>
        </div>

        <div class="card-body p-4">
            @foreach($tiket->komentars as $komentar)
                <div class="border-start border-4 ps-4 py-3 mb-3
                    @if($komentar->tipe_komentar === 'feedback') border-primary bg-primary bg-opacity-10
                    @elseif($komentar->tipe_komentar === 'evaluasi') border-success bg-success bg-opacity-10
                    @else border-danger bg-danger bg-opacity-10
                    @endif
                    rounded-end">

                    <div class="row">
                        <div class="col-md-8">

                            <div class="d-flex align-items-start mb-3">
                                <div class="bg-primary text-white rounded-circle d-flex 
                                    align-items-center justify-content-center fw-bold me-3"
                                    style="width: 45px; height: 45px; font-size: 18px;">
                                    {{ strtoupper(substr($komentar->user->name ?? 'U', 0, 1)) }}
                                </div>

                                <div>
                                    <div class="fw-bold text-dark">
                                        {{ $komentar->user->name ?? 'User tidak ditemukan' }}
                                    </div>

                                    <small class="text-muted">
                                        <i class="lni lni-calendar"></i> 
                                        {{ \Carbon\Carbon::parse($komentar->waktu_komentar)->format('d M Y, H:i') }}
                                    </small>

                                    <div class="mt-1">
                                        <span class="badge 
                                            @if($komentar->tipe_komentar === 'feedback') bg-primary
                                            @elseif($komentar->tipe_komentar === 'evaluasi') bg-success
                                            @else bg-danger
                                            @endif">
                                            @if($komentar->tipe_komentar === 'feedback')
                                                <i class="lni lni-thumbs-up"></i> Feedback
                                            @elseif($komentar->tipe_komentar === 'evaluasi')
                                                <i class="lni lni-bar-chart"></i> Evaluasi
                                            @else
                                                <i class="lni lni-warning"></i> Keluhan
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <p class="mb-0 text-dark ps-5">{{ $komentar->komentar }}</p>
                        </div>

                        <div class="col-md-4 text-end">
                            <div class="mb-2" style="font-size: 2rem;">
                                {{ str_repeat('⭐', $komentar->rating ?? 0) }}
                            </div>

                            <div class="fw-bold
                                @if(($komentar->rating ?? 0) >= 4) text-success
                                @elseif(($komentar->rating ?? 0) == 3) text-warning
                                @else text-danger
                                @endif">

                                @if(($komentar->rating ?? 0) == 5) Sangat Puas
                                @elseif(($komentar->rating ?? 0) == 4) Puas
                                @elseif(($komentar->rating ?? 0) == 3) Cukup
                                @elseif(($komentar->rating ?? 0) == 2) Tidak Puas
                                @else Sangat Tidak Puas
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@endsection
