@extends('layouts.admin.master')
@section('pageTitle', 'Daftar Laporan Saya')

@section('content')

<style>
    .index-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .index-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .index-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .header-title {
        position: relative;
        z-index: 1;
    }

    .header-title h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }

    .header-title p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .btn-add-report {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255,255,255,0.3);
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255,255,255,0.4);
        color: #764ba2;
    }

    .index-body {
        padding: 2rem;
    }

    .table-container {
        background: white;
        border-radius: 16px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .modern-table {
        margin: 0;
        width: 100%;
        min-width: 1200px;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8eaff 100%);
    }

    .modern-table thead th {
        border: none;
        color: #4338ca;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        white-space: nowrap;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.001);
    }

    .modern-table tbody tr:last-child {
        border-bottom: none;
    }

    .modern-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #4b5563;
        border: none;
    }

    .number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .image-preview {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    .image-preview:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .no-image-box {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .judul-text {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .kategori-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #166534;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .prioritas-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .prioritas-tinggi {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .prioritas-sedang {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
    }

    .prioritas-rendah {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .deskripsi-text {
        font-size: 0.85rem;
        color: #6b7280;
        max-width: 200px;
    }

    .read-more {
        color: #667eea;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
    }

    .read-more:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .assigned-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-diproses {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .status-selesai {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-ditolak {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .date-text {
        font-size: 0.85rem;
        color: #6b7280;
        white-space: nowrap;
    }

    .btn-detail {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-detail:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        color: white;
    }

    .action-buttons-group {
        display: flex;
        gap: 0.4rem;
        flex-wrap: wrap;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
    }

    .empty-state img {
        max-width: 200px;
        margin-bottom: 1.5rem;
        opacity: 0.7;
    }

    .empty-state h5 {
        color: #6b7280;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
    }

    .empty-state p {
        color: #9ca3af;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    .btn-create-first {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-create-first:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .pagination {
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .index-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .btn-add-report {
            width: 100%;
            justify-content: center;
        }

        .index-body {
            padding: 1rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 mt-3">
            <div class="card index-card">
                <div class="index-header">
                    <div class="header-title">
                        <h4>Daftar Laporan Saya</h4>
                        <p>Kelola semua laporan yang telah Anda buat</p>
                    </div>
                    <a href="{{ route('admin.report.create') }}" class="btn-add-report">
                        <i class="mdi mdi-plus-circle"></i>
                        Buat Laporan
                    </a>
                </div>

                <div class="index-body">
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
                        <div class="empty-state">
                            <img src="{{ asset('assets/images/empty.svg') }}" alt="Empty">
                            <h5>Belum Ada Laporan</h5>
                            <p>Mulai buat laporan pertama Anda untuk melacak progress</p>
                            <a href="{{ route('admin.report.create') }}" class="btn-create-first">
                                <i class="mdi mdi-plus-circle"></i> Buat Laporan Pertama
                            </a>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th style="width: 80px;">Foto</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Prioritas</th>
                                        <th>Deskripsi</th>
                                        <th>Ditugaskan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th style="width: 180px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $r)
                                        <tr>
                                            <td>
                                                <span class="number-badge">{{ $loop->iteration }}</span>
                                            </td>

                                            {{-- FOTO / LAMPIRAN --}}
                                            <td>
                                                @if ($r->lampiran)
                                                    <img src="{{ Storage::url($r->lampiran) }}" 
                                                         class="image-preview"
                                                         onclick="previewImage('{{ Storage::url($r->lampiran) }}')"
                                                         alt="Lampiran">
                                                @else
                                                    <div class="no-image-box">
                                                        <i class="mdi mdi-image-off mdi-24px text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- JUDUL --}}
                                            <td><span class="judul-text">{{ $r->judul }}</span></td>

                                            {{-- KATEGORI --}}
                                            <td>
                                                <span class="kategori-badge">
                                                    <i class="mdi mdi-folder"></i>
                                                    {{ $r->kategori->nama_kategori ?? '-' }}
                                                </span>
                                            </td>

                                            {{-- PRIORITAS --}}
                                            <td>
                                                @php
                                                    $prioritas = $r->prioritas->nama_prioritas ?? '-';
                                                    $prioritasClass = match(strtolower($prioritas)) {
                                                        'tinggi', 'urgent' => 'prioritas-tinggi',
                                                        'sedang', 'medium' => 'prioritas-sedang',
                                                        'rendah', 'low' => 'prioritas-rendah',
                                                        default => 'prioritas-sedang'
                                                    };
                                                @endphp
                                                <span class="prioritas-badge {{ $prioritasClass }}">
                                                    <i class="mdi mdi-alert-circle"></i>
                                                    {{ $prioritas }}
                                                </span>
                                            </td>

                                            {{-- DESKRIPSI --}}
                                            <td>
                                                <span class="deskripsi-text">
                                                    {{ Str::limit($r->deskripsi, 60) }}
                                                    @if (strlen($r->deskripsi) > 60)
                                                        <a href="javascript:void(0)"
                                                            class="read-more"
                                                            onclick="Swal.fire({
                                                                title: '{{ $r->judul }}',
                                                                html: '{{ nl2br(e($r->deskripsi)) }}',
                                                                icon: 'info',
                                                                confirmButtonColor: '#667eea'
                                                            })">
                                                            selengkapnya
                                                        </a>
                                                    @endif
                                                </span>
                                            </td>

                                            {{-- DITUGASKAN KE --}}
                                            <td>
                                                @if($r->assigned_to)
                                                    <span class="assigned-badge">
                                                        <i class="mdi mdi-account"></i>
                                                        {{ $r->assignedUser->name }}
                                                    </span>
                                                @else
                                                    <span style="color: #9ca3af;">-</span>
                                                @endif
                                            </td>

                                            {{-- STATUS --}}
                                            <td>
                                                @php
                                                    $statusClass = match ($r->status) {
                                                        'pending' => 'status-pending',
                                                        'diproses' => 'status-diproses',
                                                        'selesai' => 'status-selesai',
                                                        'ditolak' => 'status-ditolak',
                                                        default => 'status-pending',
                                                    };
                                                    $statusIcon = match ($r->status) {
                                                        'pending' => 'mdi-clock-outline',
                                                        'diproses' => 'mdi-progress-clock',
                                                        'selesai' => 'mdi-check-circle',
                                                        'ditolak' => 'mdi-close-circle',
                                                        default => 'mdi-help-circle',
                                                    };
                                                @endphp
                                                <span class="status-badge {{ $statusClass }}">
                                                    <i class="mdi {{ $statusIcon }}"></i>
                                                    {{ ucfirst($r->status) }}
                                                </span>
                                            </td>

                                            {{-- TANGGAL --}}
                                            <td>
                                                <span class="date-text">{{ $r->created_at->format('d M Y') }}</span>
                                            </td>

                                            {{-- AKSI --}}
                                            <td>
                                                <div class="action-buttons-group">
                                                    <a href="{{ route('admin.report.show', $r->id) }}"
                                                        class="btn-detail" title="Detail">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.report.edit', $r->id) }}"
                                                        class="btn-edit" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    <form method="POST"
                                                        action="{{ route('admin.report.destroy', $r->id) }}"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn-delete"
                                                            onclick="return confirm('Yakin ingin menghapus laporan ini?')"
                                                            title="Hapus">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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