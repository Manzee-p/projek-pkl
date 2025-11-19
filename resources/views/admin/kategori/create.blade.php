@extends('layouts.admin.master')

@section('content')

<style>
    .create-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .create-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .create-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .create-header h4 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }

    .create-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .create-body {
        padding: 2.5rem;
    }

    .form-section-create {
        background: #f8f9ff;
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 2px dashed #e0e7ff;
    }

    .section-title {
        color: #667eea;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label-create {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .label-icon {
        color: #667eea;
        font-size: 1.1rem;
    }

    .form-control-create {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-control-create:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        background: white;
        outline: none;
    }

    .form-control-create:hover {
        border-color: #cbd5e1;
        background: white;
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.4rem;
        font-weight: 600;
    }

    .required-mark {
        color: #ef4444;
        margin-left: 0.2rem;
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.8rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }

    .btn-cancel {
        background: white;
        border: 2px solid #e5e7eb;
        color: #6b7280;
        padding: 0.8rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        border-color: #667eea;
        color: #667eea;
        background: #f8f9ff;
        transform: translateY(-2px);
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f3f4f6;
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .create-body {
            padding: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .action-buttons button,
        .action-buttons a {
            width: 100%;
        }
    }
</style>

<div class="col-lg-10 mt-3 mx-auto grid-margin stretch-card">
    <div class="card create-card">

        {{-- HEADER --}}
        <div class="create-header">
            <h4>Tambah Event</h4>
            <p>Buat event baru untuk sistem ticketing</p>
        </div>

        <div class="create-body">
            <form action="{{ route('event.store') }}" method="POST">
                @csrf

                <div class="form-section-create">
                    <div class="section-title">
                        <i class="mdi mdi-calendar"></i> Informasi Event
                    </div>

                    {{-- Nama Event --}}
                    <div class="form-group">
                        <label class="form-label-create">
                            <i class="mdi mdi-tag label-icon"></i> Nama Event
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text" name="nama_event" class="form-control form-control-create"
                               placeholder="Masukkan nama event"
                               value="{{ old('nama_event') }}" required>
                        @error('nama_event')
                        <div class="error-message"><i class="mdi mdi-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div class="form-group mt-3">
                        <label class="form-label-create">
                            <i class="mdi mdi-map-marker label-icon"></i> Lokasi
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text" name="lokasi" class="form-control form-control-create"
                               placeholder="Masukkan lokasi event"
                               value="{{ old('lokasi') }}" required>
                        @error('lokasi')
                        <div class="error-message"><i class="mdi mdi-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Area --}}
                    <div class="form-group mt-3">
                        <label class="form-label-create">
                            <i class="mdi mdi-map-outline label-icon"></i> Area
                            <span class="required-mark">*</span>
                        </label>
                        <input type="text" name="area" class="form-control form-control-create"
                               placeholder="Masukkan area"
                               value="{{ old('area') }}" required>
                        @error('area')
                        <div class="error-message"><i class="mdi mdi-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="form-group mt-3">
                        <label class="form-label-create">
                            <i class="mdi mdi-calendar-start label-icon"></i> Tanggal Mulai
                            <span class="required-mark">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" class="form-control form-control-create"
                               value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')
                        <div class="error-message"><i class="mdi mdi-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="form-group mt-3">
                        <label class="form-label-create">
                            <i class="mdi mdi-calendar-end label-icon"></i> Tanggal Selesai
                            <span class="required-mark">*</span>
                        </label>
                        <input type="date" name="tanggal_selesai" class="form-control form-control-create"
                               value="{{ old('tanggal_selesai') }}" required>
                        @error('tanggal_selesai')
                        <div class="error-message"><i class="mdi mdi-alert-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-save">
                        <i class="mdi mdi-content-save"></i> Simpan Event
                    </button>
                    <a href="{{ route('event.index') }}" class="btn btn-cancel">
                        <i class="mdi mdi-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
