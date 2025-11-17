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

    textarea.form-control-create {
        resize: vertical;
        min-height: 120px;
    }

    .form-hint {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    .optional-mark {
        color: #9ca3af;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.3rem;
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
        color: white;
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

    .example-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.8rem;
    }

    .example-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .example-teknis {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e3a8a;
    }

    .example-konten {
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        color: #831843;
    }

    .example-umum {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .example-lainnya {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
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

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card create-card">
        <div class="create-header">
            <h4>Tambah Kategori</h4>
            <p>Buat kategori baru untuk mengorganisir tiket</p>
        </div>

        <div class="create-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                
                <!-- Informasi Kategori -->
                <div class="form-section-create">
                    <div class="section-title">
                        <i class="mdi mdi-folder"></i>
                        Informasi Kategori
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label-create">
                            <i class="mdi mdi-tag label-icon"></i>
                            Nama Kategori<span class="required-mark">*</span>
                        </label>
                        <input type="text" 
                               name="nama_kategori" 
                               class="form-control form-control-create" 
                               id="nama_kategori" 
                               value="{{ old('nama_kategori') }}" 
                               placeholder="Masukkan nama kategori"
                               required>
                        @error('nama_kategori')
                            <div class="error-message">
                                <i class="mdi mdi-alert-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-hint">
                            <i class="mdi mdi-information"></i>
                            <span>Contoh kategori yang umum digunakan:</span>
                        </div>
                        <div class="example-badges">
                            <span class="example-badge example-teknis">
                                <i class="mdi mdi-tools"></i> Teknis
                            </span>
                            <span class="example-badge example-konten">
                                <i class="mdi mdi-image-multiple"></i> Konten
                            </span>
                            <span class="example-badge example-umum">
                                <i class="mdi mdi-help-circle"></i> Umum
                            </span>
                            <span class="example-badge example-lainnya">
                                <i class="mdi mdi-dots-horizontal"></i> Lainnya
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label-create">
                            <i class="mdi mdi-text label-icon"></i>
                            Deskripsi<span class="optional-mark">(Opsional)</span>
                        </label>
                        <textarea name="deskripsi" 
                                  class="form-control form-control-create" 
                                  id="deskripsi" 
                                  placeholder="Jelaskan detail kategori ini..."
                                  rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="error-message">
                                <i class="mdi mdi-alert-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-hint">
                            <i class="mdi mdi-lightbulb-on"></i>
                            <span>Deskripsi akan membantu tim memahami jenis masalah dalam kategori ini</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn btn-save">
                        <i class="mdi mdi-content-save"></i> Simpan Kategori
                    </button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-cancel">
                        <i class="mdi mdi-arrow-left"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection