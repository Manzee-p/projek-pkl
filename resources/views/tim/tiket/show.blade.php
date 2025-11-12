@extends('layouts.admin.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-ticket"></i> Detail Tiket: {{ $tiket->kode_tiket }}
                    </h4>
                    <div>
                        <a href="{{ route('tim.tiket.edit', $tiket->tiket_id) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit Tiket
                        </a>
                        <a href="{{ route('tim.tiket.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    {{-- Info Tiket --}}
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Kode Tiket:</th>
                                <td><strong>{{ $tiket->kode_tiket }}</strong></td>
                            </tr>
                            <tr>
                                <th>Judul:</th>
                                <td><strong>{{ $tiket->judul }}</strong></td>
                            </tr>
                            <tr>
                                <th>Deskripsi:</th>
                                <td>{{ $tiket->deskripsi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Event:</th>
                                <td>{{ $tiket->event->nama_event }}</td>
                            </tr>
                            <tr>
                                <th>Kategori:</th>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $tiket->kategori->nama_kategori }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Prioritas:</th>
                                <td>
                                    @if($tiket->prioritas->nama_prioritas == 'Tinggi')
                                        <span class="badge badge-danger">{{ $tiket->prioritas->nama_prioritas }}</span>
                                    @elseif($tiket->prioritas->nama_prioritas == 'Sedang')
                                        <span class="badge badge-warning">{{ $tiket->prioritas->nama_prioritas }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $tiket->prioritas->nama_prioritas }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status Saat Ini:</th>
                                <td>
                                    @if($tiket->status->nama_status == 'Baru')
                                        <span class="badge badge-primary badge-lg">{{ $tiket->status->nama_status }}</span>
                                    @elseif($tiket->status->nama_status == 'Sedang Diproses')
                                        <span class="badge badge-warning badge-lg">{{ $tiket->status->nama_status }}</span>
                                    @elseif($tiket->status->nama_status == 'Selesai')
                                        <span class="badge badge-success badge-lg">{{ $tiket->status->nama_status }}</span>
                                    @else
                                        <span class="badge badge-secondary badge-lg">{{ $tiket->status->nama_status }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh:</th>
                                <td>{{ $tiket->user->name }} ({{ $tiket->user->email }})</td>
                            </tr>
                            <tr>
                                <th>Waktu Dibuat:</th>
                                <td>{{ $tiket->waktu_dibuat->format('d M Y H:i') }}</td>
                            </tr>
                            @if($tiket->waktu_selesai)
                            <tr>
                                <th>Waktu Selesai:</th>
                                <td>{{ $tiket->waktu_selesai->format('d M Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    {{-- Update Status --}}
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="mdi mdi-update"></i> Update Status
                                </h5>
                                <form action="{{ route('tim.tiket.update-status', $tiket->tiket_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group">
                                        <label>Status Baru</label>
                                        <select name="status_id" class="form-control" required>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->status_id }}" 
                                                    {{ $tiket->status_id == $status->status_id ? 'selected' : '' }}>
                                                    {{ $status->nama_status }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Catatan (Opsional)</label>
                                        <textarea name="catatan" class="form-control" rows="3" 
                                            placeholder="Tambahkan catatan atau update progress..."></textarea>
                                        <small class="form-text text-muted">
                                            Catatan akan dikirim ke pembuat tiket dan admin
                                        </small>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="mdi mdi-content-save"></i> Update Status
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Info Tips --}}
                        <div class="card bg-gradient-info text-white mt-3">
                            <div class="card-body">
                                <h6 class="font-weight-bold">
                                    <i class="mdi mdi-information"></i> Tips
                                </h6>
                                <small>
                                    • Ubah status menjadi <strong>"Sedang Diproses"</strong> saat mulai mengerjakan<br>
                                    • Ubah menjadi <strong>"Selesai"</strong> setelah menyelesaikan tiket<br>
                                    • Tambahkan catatan untuk update progress
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection