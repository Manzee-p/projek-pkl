@extends('layouts.admin.master')

@section('content')
<div class="pagetitle">
    <h1>Tambah Tiket</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tiket.index') }}">Tiket</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card">
        <div class="card-body pt-3">
            <h5 class="card-title">Form Tambah Tiket</h5>

            <form action="{{ route('admin.tiket.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Judul Tiket</label>
                    <div class="col-sm-10">
                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Event</label>
                    <div class="col-sm-10">
                        <select name="event_id" class="form-select" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->event_id }}">{{ $event->nama_event }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status_id" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->status_id }}">{{ $status->nama_status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Prioritas</label>
                    <div class="col-sm-10">
                        <select name="prioritas_id" class="form-select" required>
                            <option value="">-- Pilih Prioritas --</option>
                            @foreach($prioritas as $p)
                                <option value="{{ $p->prioritas_id }}">{{ $p->nama_prioritas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
