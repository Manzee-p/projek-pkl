@extends('layouts.admin.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-pencil"></i> Edit Tiket: {{ $tiket->kode_tiket }}
                    </h4>
                    <div>
                        <a href="{{ route('tim.tiket.show', $tiket->tiket_id) }}" class="btn btn-secondary btn-sm">
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

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    {{-- Informasi Tiket (Read-Only) --}}
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="mdi mdi-information"></i> Informasi Tiket
                                </h5>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="150">Kode Tiket:</th>
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
                                        <th>Dibuat Oleh:</th>
                                        <td>{{ $tiket->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Dibuat:</th>
                                        <td>{{ $tiket->waktu_dibuat->format('d M Y H:i') }}</td>
                                    </tr>
                                </table>

                                <div class="alert alert-info mt-3 mb-0">
                                    <i class="mdi mdi-information-outline"></i>
                                    <small><strong>Info:</strong> Anda hanya dapat mengubah status dan menambahkan catatan. Informasi tiket lainnya tidak dapat diubah.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form Edit Status --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="mdi mdi-pencil-box"></i> Update Status & Progress
                                </h5>

                                <form action="{{ route('tim.tiket.update', $tiket->tiket_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label>Status Saat Ini</label>
                                        <div>
                                            @if($tiket->status->nama_status == 'Baru')
                                                <span class="badge badge-primary badge-lg">{{ $tiket->status->nama_status }}</span>
                                            @elseif($tiket->status->nama_status == 'Sedang Diproses')
                                                <span class="badge badge-warning badge-lg">{{ $tiket->status->nama_status }}</span>
                                            @elseif($tiket->status->nama_status == 'Selesai')
                                                <span class="badge badge-success badge-lg">{{ $tiket->status->nama_status }}</span>
                                            @else
                                                <span class="badge badge-secondary badge-lg">{{ $tiket->status->nama_status }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Status Baru <span class="text-danger">*</span></label>
                                        <select name="status_id" class="form-control" required>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->status_id }}" 
                                                    {{ $tiket->status_id == $status->status_id ? 'selected' : '' }}>
                                                    {{ $status->nama_status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">
                                            Pilih status yang sesuai dengan progress penanganan tiket
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <label>Catatan / Update Progress</label>
                                        <textarea name="catatan" class="form-control" rows="5" 
                                            placeholder="Contoh: 
- Sedang melakukan pengecekan
- Masalah sudah ditemukan
- Solusi sudah diterapkan
- Tiket telah selesai ditangani">{{ old('catatan') }}</textarea>
                                        <small class="form-text text-muted">
                                            💡 Tambahkan detail progress untuk informasi pembuat tiket dan admin (Maks. 1000 karakter)
                                        </small>
                                    </div>

                                    {{-- Status Timeline Guide --}}
                                    <div class="alert alert-secondary">
                                        <strong>📋 Panduan Status:</strong>
                                        <ul class="mb-0 mt-2" style="font-size: 12px;">
                                            <li><strong>Baru:</strong> Tiket baru diterima, belum ditangani</li>
                                            <li><strong>Sedang Diproses:</strong> Sedang dalam penanganan</li>
                                            <li><strong>Selesai:</strong> Tiket sudah selesai ditangani</li>
                                        </ul>
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="mdi mdi-content-save"></i> Simpan Perubahan
                                        </button>
                                        <a href="{{ route('tim.tiket.show', $tiket->tiket_id) }}" class="btn btn-secondary btn-block">
                                            <i class="mdi mdi-close"></i> Batal
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection