@extends('layouts.admin.master')

@section('content')
<div class="pagetitle">
    <h1>Edit Tiket</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.tiket.index') }}">Tiket</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card">
        <div class="card-body pt-3">
            <h5 class="card-title">Form Edit Tiket</h5>

            <form action="{{ route('admin.tiket.update', $tiket->tiket_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" name="judul" class="form-control" value="{{ old('judul', $tiket->judul) }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $tiket->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status_id" class="form-select">
                            @foreach($statuses as $status)
                                <option value="{{ $status->status_id }}" {{ $tiket->status_id == $status->status_id ? 'selected' : '' }}>
                                    {{ $status->nama_status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Prioritas</label>
                    <div class="col-sm-10">
                        <select name="prioritas_id" class="form-select">
                            @foreach($prioritas as $p)
                                <option value="{{ $p->prioritas_id }}" {{ $tiket->prioritas_id == $p->prioritas_id ? 'selected' : '' }}>
                                    {{ $p->nama_prioritas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
