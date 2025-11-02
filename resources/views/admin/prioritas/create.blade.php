@extends('layouts.admin.master')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Prioritas</h4>
                <p class="card-description">
                    <a href="{{ route('prioritas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </p>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('prioritas.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                        <label for="nama_prioritas">Nama Prioritas</label>
                        <input type="text" class="form-control" id="nama_prioritas" name="nama_prioritas" 
                               value="{{ old('nama_prioritas') }}" placeholder="Masukkan nama prioritas (contoh: Tinggi, Sedang, Rendah)" required>
                        <small class="form-text text-muted">Contoh: Tinggi, Sedang, Rendah, Urgent</small>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('prioritas.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection