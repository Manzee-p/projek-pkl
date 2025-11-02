@extends('layouts.admin.master')

@section('content')
<div class="pagetitle">
    <h1>Data Tiket</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Tiket</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card">
        <div class="card-body pt-3">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title">Daftar Tiket</h5>
                <a href="{{ route('admin.tiket.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Tiket
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Kode Tiket</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Event</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tikets as $tiket)
                        <tr>
                            <td>{{ $tiket->kode_tiket }}</td>
                            <td>{{ $tiket->judul }}</td>
                            <td>{{ $tiket->kategori->nama ?? '-' }}</td>
                            <td>{{ $tiket->status->nama_status ?? '-' }}</td>
                            <td>{{ $tiket->prioritas->nama_prioritas ?? '-' }}</td>
                            <td>{{ $tiket->event->nama_event ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.tiket.show', $tiket->tiket_id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.tiket.edit', $tiket->tiket_id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.tiket.destroy', $tiket->tiket_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tiket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</section>
@endsection
