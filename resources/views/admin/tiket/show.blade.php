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

                {{-- Tampilkan siapa yang ditugaskan --}}
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

                {{-- Jika ada lampiran foto --}}
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

                {{-- Jika ada waktu selesai --}}
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

@endsection
