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

    .prioritas-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .prioritas-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .badge-tinggi {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    .badge-sedang {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
    }

    .badge-rendah {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .badge-default {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        color: #4b5563;
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

    .number-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }
</style>

<div class="col-lg-10 mt-3 stretch-card mb-1">
    <div class="card modern-card">
        <div class="card-header-modern d-flex justify-content-between align-items-center">
            <div>
                <h4>Daftar Prioritas</h4>
                <p>Kelola tingkat prioritas tiket dalam sistem</p>
            </div>
            <a href="{{ route('prioritas.create') }}" class="btn btn-add-modern">
                <i class="mdi mdi-plus-circle"></i> Tambah Prioritas
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">#</th>
                            <th>Nama Prioritas</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prioritas as $index => $item)
                            <tr>
                                <td>
                                    <span class="number-badge">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <span class="prioritas-badge 
                                        @if(strpos(strtolower($item->nama_prioritas), 'tinggi') !== false) 
                                            badge-tinggi
                                        @elseif(strpos(strtolower($item->nama_prioritas), 'sedang') !== false) 
                                            badge-sedang
                                        @elseif(strpos(strtolower($item->nama_prioritas), 'rendah') !== false) 
                                            badge-rendah
                                        @else 
                                            badge-default
                                        @endif">
                                        <i class="mdi 
                                            @if(strpos(strtolower($item->nama_prioritas), 'tinggi') !== false) 
                                                mdi-alert-circle
                                            @elseif(strpos(strtolower($item->nama_prioritas), 'sedang') !== false) 
                                                mdi-alert
                                            @elseif(strpos(strtolower($item->nama_prioritas), 'rendah') !== false) 
                                                mdi-minus-circle
                                            @else 
                                                mdi-label
                                            @endif"></i>
                                        {{ $item->nama_prioritas }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('prioritas.edit', $item) }}" class="btn btn-action btn-edit">
                                        <i class="mdi mdi-pencil"></i> 
                                    </a>
                                    <form action="{{ route('prioritas.destroy', $item) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prioritas ini?');">
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
                                <td colspan="3" class="empty-state">
                                    <div class="empty-state-icon">📭</div>
                                    <div class="empty-state-text">Belum ada prioritas yang tersedia</div>
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