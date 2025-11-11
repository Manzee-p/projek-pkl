@extends('layouts.admin.master')
@section('pageTitle', 'Laporan Ditugaskan kepada Saya')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Laporan Ditugaskan kepada Saya</h4>
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
                                <p class="text-muted">Belum ada laporan yang ditugaskan kepadamu.</p>
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
                                            <th>Status</th>
                                            <th>Dari</th>
                                            <th>Tanggal</th>
                                            <th width="10%">Aksi</th>
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

                                                {{-- DESKRIPSI RINGKAS --}}
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

                                                <td>
    @php
        $badge = match($r->status) {
            'pending'  => 'bg-warning',
            'diproses' => 'bg-info',
            'selesai'  => 'bg-success',
            'ditolak'  => 'bg-danger',
            default    => 'bg-secondary'
        };
    @endphp
    <span class="badge {{ $badge }} rounded-pill">{{ ucfirst($r->status) }}</span>
</td>

                                                {{-- DARI (PEMBUAT LAPORAN) --}}
                                                <td>{{ $r->user->name ?? '-' }}</td>

                                                {{-- TANGGAL --}}
                                                <td>{{ $r->created_at->format('d M Y') }}</td>

                                                

                                                {{-- AKSI --}}
                                                <td>
                                                    <a href="{{ route('tim_teknisi.report.show', $r->id) }}"
                                                        class="btn btn-sm btn-info" title="Detail">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tim_teknisi.report.edit', $r->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
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
