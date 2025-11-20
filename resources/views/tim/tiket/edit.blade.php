@extends('layouts.admin.master')

@section('content')
<style>
    :root{
        --primary-1: #667eea;
        --primary-2: #764ba2;
        --glass-bg: rgba(255,255,255,0.72);
        --muted: #6b7280;
    }

    .page-hero {
        background: linear-gradient(135deg, var(--primary-1) 0%, var(--primary-2) 100%);
        color: white;
        border-radius: 20px;
        padding: 36px 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(102, 126, 234, 0.12);
        margin-bottom: 28px;
    }

    /* decorative circle/image (uses uploaded image path below) */
    .hero-deco {
        position: absolute;
        right: -20px;
        top: -30px;
        width: 320px;
        height: 320px;
        opacity: 0.12;
        background-size: cover;
        background-position: center;
        filter: blur(6px);
        transform: rotate(10deg);
    }

    .hero-title {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 0 0 6px 0;
        letter-spacing: -0.3px;
    }

    .hero-sub {
        margin: 0;
        opacity: 0.95;
        color: rgba(255,255,255,0.95);
        font-weight: 500;
    }

    .main-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.98));
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(32, 38, 52, 0.06);
    }

    .row-gap {
        gap: 20px;
    }

    .info-panel {
        background: linear-gradient(180deg, #f8f9ff, #ffffff);
        border-radius: 14px;
        padding: 18px;
        border: 1px solid rgba(102,126,234,0.06);
    }

    .label-title { font-weight: 700; color: #374151; font-size: 0.9rem; }
    .muted { color: var(--muted); font-size: 0.9rem; }

    .badge-modern {
        display: inline-flex; align-items:center; gap:8px;
        padding: 8px 12px; border-radius: 999px; font-weight:700;
        font-size: 0.85rem; box-shadow: 0 6px 18px rgba(16,24,40,0.04);
    }
    .badge-cat { background: linear-gradient(90deg,#dcfce7,#d1fae5); color:#065f46; }
    .badge-prio-high { background: linear-gradient(90deg,#fee2e2,#fecaca); color:#991b1b; }
    .badge-prio-mid { background: linear-gradient(90deg,#fff4e6,#feeccf); color:#92400e; }
    .badge-prio-low { background: linear-gradient(90deg,#dbeafe,#bfdbfe); color:#1e3a8a; }

    .form-control, .form-select, textarea.form-control {
        border-radius: 12px;
        border: 1px solid rgba(15,23,42,0.06);
        padding: 12px 14px;
        background: white;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
    }

    .form-control:focus, .form-select:focus, textarea.form-control:focus{
        outline: none;
        box-shadow: 0 6px 20px rgba(102,126,234,0.12);
        border-color: var(--primary-1);
    }

    .btn-cta {
        background: linear-gradient(135deg,var(--primary-1),var(--primary-2));
        color: #fff;
        border-radius: 12px;
        padding: 10px 18px;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(118,75,162,0.18);
        border: none;
    }

    .btn-ghost {
        background: white;
        border-radius: 12px;
        padding: 10px 18px;
        color: #374151;
        border: 1px solid rgba(15,23,42,0.06);
        font-weight: 700;
    }

    .small-muted { font-size: 0.85rem; color: var(--muted); }

    .file-preview {
        max-width: 160px;
        border-radius: 10px;
        margin-top: 8px;
        box-shadow: 0 8px 18px rgba(15,23,42,0.06);
    }

    @media (max-width: 992px) {
        .hero-deco { display: none; }
    }
</style>

<div class="container-fluid px-3">

    {{-- hero/header --}}
    <div class="page-hero">
        <div class="hero-deco" style="background-image: url('/mnt/data/6d551fd3-cc28-4cdf-b89f-4d534169e15a.png');"></div>

        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="hero-title"><i class="mdi mdi-ticket-outline"></i> Edit Tiket</h1>
                <p class="hero-sub">Perbarui status, tambahkan catatan, dan selesaikan tiket dengan cepat.</p>
            </div>

            <div class="text-end">
                <a href="{{ route('tim.tiket.index') }}" class="btn btn-ghost">
                    <i class="mdi mdi-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    {{-- main card --}}
    <div class="main-card">

        {{-- alerts --}}
        @if ($errors->any())
            <div class="alert alert-danger rounded-pill">
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success rounded-pill">{{ session('success') }}</div>
        @endif

        {{-- content two-column --}}
        <form action="{{ route('tim.tiket.update', $tiket->tiket_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row row-gap">
                {{-- left info --}}
                <div class="col-lg-5">
                    <div class="info-panel">
                        <h5 class="mb-3"><i class="mdi mdi-information-outline"></i> Informasi Tiket</h5>

                        <p class="mb-2"><span class="label-title">Kode Tiket</span><br>
                            <strong class="muted">{{ $tiket->kode_tiket }}</strong></p>

                        <p class="mb-2"><span class="label-title">Judul</span><br>
                            <strong>{{ $tiket->judul }}</strong></p>

                        <p class="mb-2"><span class="label-title">Deskripsi</span><br>
                            <span class="muted">{{ $tiket->deskripsi ?? '-' }}</span></p>

                        <p class="mb-2"><span class="label-title">Event</span><br>
                            <span class="muted">{{ optional($tiket->event)->nama_event ?? '-' }}</span></p>

                        <p class="mb-2"><span class="label-title">Kategori</span><br>
                            <span class="badge-modern badge-cat">{{ $tiket->kategori->nama_kategori }}</span>
                        </p>

                        <p class="mb-2"><span class="label-title">Prioritas</span><br>
                            @php $p = strtolower($tiket->prioritas->nama_prioritas ?? 'low'); @endphp
                            @if(str_contains($p, 'high') || str_contains($p,'tinggi'))
                                <span class="badge-modern badge-prio-high">{{ $tiket->prioritas->nama_prioritas }}</span>
                            @elseif(str_contains($p,'med') || str_contains($p,'sedang'))
                                <span class="badge-modern badge-prio-mid">{{ $tiket->prioritas->nama_prioritas }}</span>
                            @else
                                <span class="badge-modern badge-prio-low">{{ $tiket->prioritas->nama_prioritas }}</span>
                            @endif
                        </p>

                        <p class="mb-2"><span class="label-title">Dibuat Oleh</span><br>
                            <span class="muted">{{ $tiket->user->name }}</span></p>

                        <p class="mb-0"><span class="label-title">Waktu Dibuat</span><br>
                            <span class="muted">{{ $tiket->waktu_dibuat->format('d M Y H:i') }}</span></p>

                        <hr>

                        <label class="label-title">Lampiran Saat Ini</label>
                        @if($tiket->lampiran)
                            @php
                                $ext = pathinfo($tiket->lampiran, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($ext), ['png','jpg','jpeg','gif']))
                                <img src="{{ asset('storage/'.$tiket->lampiran) }}" alt="lampiran" class="file-preview">
                            @else
                                <div class="small-muted">File: <a href="{{ asset('storage/'.$tiket->lampiran) }}" target="_blank">{{ basename($tiket->lampiran) }}</a></div>
                            @endif
                        @else
                            <div class="small-muted">Tidak ada lampiran</div>
                        @endif

                        <div class="alert alert-info mt-3 mb-0">
                            <strong>Catatan:</strong> Hanya status dan catatan yang dapat diubah oleh tim.
                        </div>
                    </div>
                </div>

                {{-- right form --}}
                <div class="col-lg-7">
                    <div class="p-3" style="background: linear-gradient(180deg, rgba(246,247,255,0.6), rgba(255,255,255,0.7)); border-radius:12px; border:1px solid rgba(102,126,234,0.04)">
                        <h5 class="mb-3"><i class="mdi mdi-wrench"></i> Update Status & Progress</h5>

                        {{-- current status --}}
                        <div class="mb-3">
                            <label class="label-title d-block">Status Saat Ini</label>
                            <div style="display:inline-block">
                                <span class="badge-modern" style="background: linear-gradient(90deg,#eef2ff,#eef4ff); color:#4338ca;">
                                    <i class="mdi mdi-information-outline"></i>&nbsp; {{ $tiket->status->nama_status }}
                                </span>
                            </div>
                        </div>

                        {{-- status baru --}}
                        <div class="mb-3">
                            <label class="label-title">Status Baru <span class="text-danger">*</span></label>
                            <select name="status_id" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->status_id }}" {{ $tiket->status_id == $status->status_id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- catatan --}}
                        <div class="mb-3">
                            <label class="label-title">Catatan / Progress</label>
                            <textarea name="catatan" class="form-control" rows="6" maxlength="1000" placeholder="- Contoh: Sedang melakukan pengecekan...">{{ old('catatan') }}</textarea>
                            <div class="small-muted mt-1">Maks 1000 karakter — akan terlihat oleh pembuat tiket dan admin.</div>
                        </div>

                        {{-- lampiran baru --}}
                        <div class="mb-3">
                            <label class="label-title">Unggah Lampiran Baru (opsional)</label>
                            <input type="file" name="lampiran" class="form-control">
                            <div class="small-muted mt-1">Format: jpg, png, pdf (max 2MB). Mengunggah akan mengganti lampiran lama.</div>
                        </div>

                        {{-- actions --}}
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn-cta">
                                <i class="mdi mdi-content-save"></i> Simpan Perubahan
                            </button>

                            <a href="{{ route('tim.tiket.show', $tiket->tiket_id) }}" class="btn-ghost">
                                <i class="mdi mdi-close"></i> Batal
                            </a>
                        </div>
                    </div> {{-- right panel --}}
                </div>
            </div> {{-- row --}}
        </form>

    </div> {{-- main card --}}
</div> {{-- container --}}
@endsection
