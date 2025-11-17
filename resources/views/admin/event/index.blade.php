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

<style>
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .card-header-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border: none;
    }

    .card-header-modern h4 {
        color: white;
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }

    .card-header-modern p {
        color: rgba(255,255,255,0.9);
        margin: 0.5rem 0 0 0;
        font-size: 0.9rem;
    }

    .btn-add-modern {
        background: white;
        color: #667eea;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-add-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        color: #667eea;
    }

    .modern-table {
        margin: 0;
    }

    .modern-table thead th {
        background: #f8f9fa;
        border: none;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem;
    }

    .modern-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .modern-table tbody tr:hover {
        background: #f8f9ff;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border: none;
    }

    .event-name {
        font-weight: 700;
        color: #667eea;
        font-size: 0.95rem;
    }

    .location-badge {
        background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
        color: #4338ca;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .area-badge {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .date-box {
        background: #f9fafb;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        display: inline-block;
    }

    .date-label {
        font-size: 0.7rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        display: block;
    }

    .date-value {
        font-size: 0.9rem;
        color: #1f2937;
        font-weight: 700;
    }

    .btn-action {
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        margin: 0.2rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-detail {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-edit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state-icon {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: #94a3b8;
        font-size: 1.1rem;
    }
</style>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card modern-card">
        <div class="card-header-modern d-flex justify-content-between align-items-center">
            <div>
                <h4>Daftar Event</h4>
                <p>Kelola semua event yang terdaftar di sistem</p>
            </div>
            <a href="{{ route('event.create') }}" class="btn btn-add-modern">
                <i class="mdi mdi-plus-circle"></i> Tambah Event
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Nama Event</th>
                            <th>Lokasi</th>
                            <th>Area</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="event-name">{{ $item->nama_event }}</span>
                                </td>
                                <td>
                                    <span class="location-badge">
                                        <i class="mdi mdi-map-marker"></i>
                                        {{ $item->lokasi }}
                                    </span>
                                </td>
                                <td>
                                    <span class="area-badge">
                                        <i class="mdi mdi-earth"></i>
                                        {{ $item->area }}
                                    </span>
                                </td>
                                <td>
                                    <div class="date-box">
                                        <span class="date-label">Mulai</span>
                                        <span class="date-value">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="date-box">
                                        <span class="date-label">Selesai</span>
                                        <span class="date-value">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('event.show', $item) }}" class="btn btn-action btn-detail">
                                        <i class="mdi mdi-eye"></i> 
                                    </a>
                                    <a href="{{ route('event.edit', $item) }}" class="btn btn-action btn-edit">
                                        <i class="mdi mdi-pencil"></i> 
                                    </a>
                                    <form action="{{ route('event.destroy', $item) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action btn-delete">
                                            <i class="mdi mdi-delete"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-text">Belum ada event yang tersedia</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection