@extends('layouts.admin.master')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Tiket</h4>

            <form action="{{ route('admin.tiket.update', $tiket) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Kode Tiket</label>
                    <input type="text" class="form-control" value="{{ $tiket->kode_tiket }}" disabled>
                </div>

                <div class="form-group">
                    <label>Nama User</label>
                    <select name="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $tiket->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Event</label>
                    <select name="event_id" class="form-control">
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" {{ $tiket->event_id == $event->id ? 'selected' : '' }}>
                                {{ $event->nama_event }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ $tiket->kategori_id == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Prioritas</label>
                    <select name="prioritas_id" class="form-control">
                        @foreach ($prioritas as $prio)
                            <option value="{{ $prio->id }}" {{ $tiket->prioritas_id == $prio->id ? 'selected' : '' }}>
                                {{ $prio->nama_prioritas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status_id" class="form-control">
                        @foreach ($statuses as $st)
                            <option value="{{ $st->id }}" {{ $tiket->status_id == $st->id ? 'selected' : '' }}>
                                {{ $st->nama_status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ $tiket->deskripsi }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm mt-2">Update Tiket</button>
                <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary btn-sm mt-2">Kembali</a>

            </form>
        </div>
    </div>
</div>

@endsection
