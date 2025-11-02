@extends('layouts.admin.master')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10"> {{-- Bikin lebih lebar, bisa diganti 12 kalau mau full--}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Buat Tiket Baru</h4>

                <form action="{{ route('admin.tiket.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Event</label>
                            <select name="event_id" class="form-control" required>
                                <option value="">-- Pilih Event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->event_id }}">{{ $event->nama_event }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Judul Tiket</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kategori</label>
                            <select name="kategori_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Prioritas</label>
                            <select name="prioritas_id" class="form-control" required>
                                <option value="">-- Pilih Prioritas --</option>
                                @foreach($prioritas as $prio)
                                    <option value="{{ $prio->prioritas_id }}">{{ $prio->nama_prioritas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="status_id" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->status_id }}">{{ $status->nama_status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
