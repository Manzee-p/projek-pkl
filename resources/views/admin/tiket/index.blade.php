@extends('layouts.admin.master')
@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Yeay! 🎉',
            text: '{{ session('success') }}',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
</script>
@endif

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Daftar Tiket User</h4>
            <p class="card-description">
                <a href="{{ route('admin.tiket.create') }}" class="btn btn-primary btn-sm">Tambah Tiket</a>
            </p>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Tiket</th>
                            <th>User</th>
                            <th>Event</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Waktu Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tikets as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->kode_tiket }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->event->nama_event }}</td>
                                <td>{{ $item->kategori->nama_kategori }}</td>
                                <td>{{ $item->prioritas->nama_prioritas }}</td>
                                <td>{{ $item->status->nama_status }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->waktu_dibuat)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.tiket.show', $item->tiket_id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('admin.tiket.edit', $item->tiket_id) }}" class="btn btn-info btn-sm">Edit</a>


                                    <form action="{{ route('admin.tiket.destroy', $item->tiket_id) }}" 
                                          method="POST" style="display:inline-block;"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?');">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

@endsection
