@extends('layouts.admin.master')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Event</h4>
                <p class="card-description">
                    <a href="{{ route('event.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                    <a href="{{ route('event.edit', $event) }}" class="btn btn-success btn-sm">Ubah</a>
                </p>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="200">Nama Event</th>
                                <td>{{ $event->nama_event }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>{{ $event->lokasi }}</td>
                            </tr>
                            <tr>
                                <th>Area</th>
                                <td>{{ $event->area }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>{{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ \Carbon\Carbon::parse($event->created_at)->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate Pada</th>
                                <td>{{ \Carbon\Carbon::parse($event->updated_at)->format('d F Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection