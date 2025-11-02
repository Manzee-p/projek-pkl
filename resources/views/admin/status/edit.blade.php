@extends('layouts.admin.master')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Status Tiket</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.status.update', $status) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_status">Nama Status</label>
                    <input type="text" class="form-control" id="nama_status" name="nama_status"
                           value="{{ old('nama_status', $status->nama_status) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.status.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection