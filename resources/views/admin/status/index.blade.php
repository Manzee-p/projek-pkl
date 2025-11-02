@extends('layouts.admin.master')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Status Tiket</h4>
            <p class="card-description">
                <a href="{{ route('admin.status.create') }}" class="btn btn-primary btn-sm">Tambah Status</a>
            </p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($statuses as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_status }}</td>
                                <td>
                                    <a href="{{ route('admin.status.edit', $item) }}"
                                       class="btn btn-success btn-sm">Ubah</a>

                                    <form action="{{ route('admin.status.destroy', $item) }}"
                                          method="POST"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Yakin hapus status ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada status tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection