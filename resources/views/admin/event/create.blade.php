@extends('layouts.admin.master')
@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Event</h4>
                <p class="card-description">
                    <a href="{{ route('event.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
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

                <form action="{{ route('event.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                        <label for="nama_event">Nama Event</label>
                        <input type="text" class="form-control" id="nama_event" name="nama_event" 
                               value="{{ old('nama_event') }}" placeholder="Masukkan nama event" required>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" 
                               value="{{ old('lokasi') }}" placeholder="Masukkan lokasi event" required>
                    </div>
                    <div class="form-group">
                        <label for="area">Area</label>
                        <input type="text" class="form-control" id="area" name="area" 
                               value="{{ old('area') }}" placeholder="Masukkan area event" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                               value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('event.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection