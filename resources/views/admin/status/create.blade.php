@extends('layouts.admin.master')

@section('content')
<div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tambah Status Tiket</h4>

            <form action="{{ route('admin.status.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_status">Nama Status</label>
                    <input type="text" name="nama_status" class="form-control" id="nama_status"
                           value="{{ old('nama_status') }}" required>
                    @error('nama_status')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.status.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection