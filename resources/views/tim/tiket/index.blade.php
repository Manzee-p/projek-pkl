@extends('layouts.admin.master')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">
                    <i class="mdi mdi-ticket"></i> Tiket yang Ditugaskan kepada Saya
                </h4>
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

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('tim.tiket.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status_id" class="form-control form-control-sm">
                            <option value="">-- Semua Status --</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->status_id }}" {{ request('status_id') == $status->status_id ? 'selected' : '' }}>
                                    {{ $status->nama_status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="kategori_id" class="form-control form-control-sm">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}" {{ request('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="prioritas_id" class="form-control form-control-sm">
                            <option value="">-- Semua Prioritas --</option>
                            @foreach($prioritas as $prio)
                                <option value="{{ $prio->prioritas_id }}" {{ request('prioritas_id') == $prio->prioritas_id ? 'selected' : '' }}>
                                    {{ $prio->nama_prioritas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-filter"></i> Filter
                        </button>
                        <a href="{{ route('tim.tiket.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-refresh"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            {{-- Tabel Tiket --}}
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Kode Tiket</th>
                            <th>Judul</th>
                            <th>Pembuat</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Waktu Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tikets as $tiket)
                            <tr>
                                <td><strong>{{ $tiket->kode_tiket }}</strong></td>
                                <td>{{ Str::limit($tiket->judul, 40) }}</td>
                                <td>{{ $tiket->user->name }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $tiket->kategori->nama_kategori }}
                                    </span>
                                </td>
                                <td>
                                    @if($tiket->prioritas->nama_prioritas == 'Tinggi')
                                        <span class="badge badge-danger">{{ $tiket->prioritas->nama_prioritas }}</span>
                                    @elseif($tiket->prioritas->nama_prioritas == 'Sedang')
                                        <span class="badge badge-warning">{{ $tiket->prioritas->nama_prioritas }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $tiket->prioritas->nama_prioritas }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($tiket->status->nama_status == 'Baru')
                                        <span class="badge badge-primary">{{ $tiket->status->nama_status }}</span>
                                    @elseif($tiket->status->nama_status == 'Sedang Diproses')
                                        <span class="badge badge-warning">{{ $tiket->status->nama_status }}</span>
                                    @elseif($tiket->status->nama_status == 'Selesai')
                                        <span class="badge badge-success">{{ $tiket->status->nama_status }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $tiket->status->nama_status }}</span>
                                    @endif
                                </td>
                                <td>{{ $tiket->waktu_dibuat->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('tim.tiket.show', $tiket->tiket_id) }}" class="btn btn-sm btn-primary">
                                        <i class="mdi mdi-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('tim.tiket.edit', $tiket->tiket_id) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="mdi mdi-information-outline" style="font-size: 48px; color: #ccc;"></i>
                                    <p class="mt-2 text-muted">Belum ada tiket yang ditugaskan kepada Anda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection