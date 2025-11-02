@extends('layouts.admin.master')

@section('content')
<div class="pagetitle">
    <h1>Detail Tiket</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tiket.index') }}">Tiket</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card">
        <div class="card-body pt-3">
            <h5 class="card-title">Informasi Tiket</h5>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Kode Tiket</div>
                <div class="col-sm-9">{{ $tiket->kode_tiket }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Judul</div>
                <div class="col-sm-9">{{ $tiket->judul }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Deskripsi</div>
                <div class="col-sm-9">{{ $tiket->deskripsi ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Kategori</div>
                <div class="col-sm-9">{{ $tiket->kategori->nama ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Status</div>
                <div class="col-sm-9">{{ $tiket->status->nama_status ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Prioritas</div>
                <div class="col-sm-9">{{ $tiket->prioritas->nama_prioritas ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Event</div>
                <div class="col-sm-9">{{ $tiket->event->nama_event ?? '-' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Tanggal Dibuat</div>
                <div class="col-sm-9">{{ $tiket->waktu_dibuat }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3 fw-bold">Tanggal Selesai</div>
                <div class="col-sm-9">{{ $tiket->waktu_selesai ?? '-' }}</div>
            </div>

            <div class="text-end">
                <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('admin.tiket.edit', $tiket->tiket_id) }}" class="btn btn-warning">Edit</a>
            </div>

        </div>
    </div>
</section>
@endsection
