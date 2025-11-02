@extends('layouts.admin.master')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Tiket</h4>

            <table class="table table-bordered">
                <tr>
                    <th>Kode Tiket</th>
                    <td>{{ $tiket->kode_tiket }}</td>
                </tr>
                <tr>
                    <th>Nama User</th>
                    <td>{{ $tiket->user->name }}</td>
                </tr>
                <tr>
                    <th>Event</th>
                    <td>{{ $tiket->event->nama_event }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $tiket->kategori->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Prioritas</th>
                    <td>{{ $tiket->prioritas->nama_prioritas }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $tiket->status->nama_status }}</td>
                </tr>
                <tr>
                    <th>Waktu Dibuat</th>
                    <td>{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d/m/Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $tiket->deskripsi }}</td>
                </tr>
            </table>

            <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary btn-sm mt-3">Kembali</a>
        </div>
    </div>
</div>

@endsection
