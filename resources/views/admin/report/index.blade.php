@extends('layouts.admin.master')
@section('pageTitle', 'Daftar Laporan Saya')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Laporan Saya</h4>
                        <a href="{{ route('admin.report.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Buat Laporan
                        </a>
                    </div>

                    <div class="card-body">
                        {{-- SWEETALERT OTOMATIS --}}
                        @if (session('success'))
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil! 🎉',
                                        text: '{{ session('success') }}',
                                        timer: 2500,
                                        showConfirmButton: false
                                    });
                                });
                            </script>
                        @endif

                        {{-- CEK JIKA BELUM ADA LAPORAN --}}
                        @if ($reports->count() == 0)
                            <div class="text-center py-5">
                                <img src="{{ asset('assets/images/empty.svg') }}" width="150" class="mb-3">
                                <p class="text-muted">Belum ada laporan.</p>
                                <a href="{{ route('admin.report.create') }}" class="btn btn-outline-primary">
                                    Buat Laporan Pertama
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="10%">Foto</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Prioritas</th>
                                            <th>Deskripsi</th>
                                            <th>Ditugaskan ke</th>
                                            <th>Tanggal</th>
                                            <th width="12%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $r)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                {{-- FOTO / LAMPIRAN --}}
                                                <td>
                                                    @if ($r->lampiran)
                                                        <a href="javascript:void(0)"
                                                            onclick="previewImage('{{ Storage::url($r->lampiran) }}')">
                                                            <img src="{{ Storage::url($r->lampiran) }}" class="rounded"
                                                                style="width:60px; height:60px; object-fit:cover;">
                                                        </a>
                                                    @else
                                                        <div
                                                            class="avatar-lg bg-light rounded d-flex align-items-center justify-content-center">
                                                            <i class="mdi mdi-image-off mdi-24px text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>

                                                {{-- JUDUL --}}
                                                <td><strong>{{ $r->judul }}</strong></td>
                                                <td>{{ $r->kategori->nama_kategori ?? '-' }}</td>
                                                <td>{{ $r->prioritas->nama_prioritas ?? '-' }}</td>
                                                {{-- DESKRIPSI DENGAN POPUP --}}
                                                <td>
                                                    <small class="text-muted">
                                                        {{ Str::limit($r->deskripsi, 80) }}
                                                        @if (strlen($r->deskripsi) > 80)
                                                            <a href="javascript:void(0)"
                                                                onclick="Swal.fire({
                                                           title: '{{ $r->judul }}',
                                                           html: '{{ nl2br(e($r->deskripsi)) }}',
                                                           icon: 'info'
                                                       })">
                                                                ... baca selengkapnya
                                                            </a>
                                                        @endif
                                                    </small>
                                                </td>

                                                {{-- DITUGASKAN KE --}}
                                                <td>
                                                    {{ $r->assigned_to ? $r->assignedUser->name : '-' }}
                                                </td>


                                                {{-- TANGGAL --}}
                                                <td>{{ $r->created_at->format('d M Y') }}</td>

                                                {{-- AKSI --}}
                                                <td>
                                                    <a href="{{ route('admin.report.show', $r->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.report.edit', $r->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('admin.report.destroy', $r->id) }}"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')"
                                                            title="Hapus">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center">
                                    {{ $reports->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PREVIEW GAMBAR --}}
    <script>
        function previewImage(url) {
            Swal.fire({
                title: 'Preview Lampiran',
                imageUrl: url,
                imageAlt: 'Lampiran',
                showCloseButton: true,
                showConfirmButton: false,
                width: 'auto',
                background: '#fff',
                padding: '1rem',
                customClass: {
                    image: 'rounded'
                }
            });
        }
    </script>
@endsection
