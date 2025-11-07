@extends('layouts.admin.master')
@section('pageTitle', 'Detail Laporan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                    <h4 class="card-title mb-0">
                        <i class="mdi mdi-file-document-outline text-primary"></i> Detail Laporan
                    </h4>
                    <a href="{{ route('admin.report.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    {{-- Judul --}}
                    <h3 class="fw-bold mb-3">{{ $report->judul }}</h3>

                    {{-- Metadata --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Kategori:</strong> 
                                <span class="badge bg-info">{{ $report->kategori }}</span>
                            </p>
                            <p><strong>Prioritas:</strong> 
                                <span class="badge 
                                    {{ $report->prioritas == 'urgent' ? 'bg-danger' : 
                                       ($report->prioritas == 'tinggi' ? 'bg-warning' : 
                                       ($report->prioritas == 'sedang' ? 'bg-primary' : 'bg-success')) }}">
                                    {{ ucfirst($report->prioritas) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Dibuat oleh:</strong> {{ $report->user->name ?? 'Tidak diketahui' }}</p>
                            <p><strong>Tanggal:</strong> {{ $report->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <h5 class="fw-semibold">Deskripsi Masalah:</h5>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($report->deskripsi)) !!}
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    @if($report->lampiran)
                    <div class="mb-4">
                        <h5 class="fw-semibold">Lampiran:</h5>
                        <div class="border rounded p-3 bg-light text-center">
                            @php
                                $ext = pathinfo($report->lampiran, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array($ext, ['jpg','jpeg','png','gif','webp']))
                                <img src="{{ Storage::url($report->lampiran) }}" 
                                     alt="Lampiran" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px; object-fit: contain;">
                            @elseif($ext === 'pdf')
                                <iframe src="{{ Storage::url($report->lampiran) }}" 
                                        class="w-100 rounded" 
                                        height="500px"></iframe>
                            @else
                                <a href="{{ Storage::url($report->lampiran) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-info">
                                    <i class="mdi mdi-eye"></i> Lihat Lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.report.edit', $report->id) }}" 
                           class="btn btn-warning me-2">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.report.destroy', $report->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert untuk sukses --}}
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    });
</script>
@endif
@endsection
