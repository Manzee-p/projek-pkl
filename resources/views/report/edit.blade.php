<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan - Helpdesk</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    
    <!-- LineIcons CDN -->
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
</head>
<body>
    {{-- Include Navbar --}}
    @include('layouts.components-frontend.navbar')

    <div class="container py-5" style="min-height: calc(100vh - 200px);">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Header --}}
                <div class="mb-4">
                    <a href="{{ route('report.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
                        <i class="lni lni-arrow-left"></i> Kembali
                    </a>
                    <h2 class="fw-bold mb-2">✏️ Edit Laporan</h2>
                    <p class="text-muted">Update informasi laporan Anda</p>
                </div>

                {{-- Form Card --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('report.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Judul Laporan --}}
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">
                                    Judul Laporan <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('judul') is-invalid @enderror" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul', $report->judul) }}"
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori & Prioritas --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label fw-semibold">
                                        Kategori <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" 
                                            id="kategori" 
                                            name="kategori" 
                                            required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Teknis" {{ old('kategori', $report->kategori) == 'Teknis' ? 'selected' : '' }}>
                                            🔧 Teknis
                                        </option>
                                        <option value="Akun" {{ old('kategori', $report->kategori) == 'Akun' ? 'selected' : '' }}>
                                            👤 Akun
                                        </option>
                                        <option value="Fitur" {{ old('kategori', $report->kategori) == 'Fitur' ? 'selected' : '' }}>
                                            ⚙️ Fitur
                                        </option>
                                        <option value="Bug" {{ old('kategori', $report->kategori) == 'Bug' ? 'selected' : '' }}>
                                            🐛 Bug
                                        </option>
                                        <option value="Lainnya" {{ old('kategori', $report->kategori) == 'Lainnya' ? 'selected' : '' }}>
                                            📌 Lainnya
                                        </option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="prioritas" class="form-label fw-semibold">
                                        Prioritas <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('prioritas') is-invalid @enderror" 
                                            id="prioritas" 
                                            name="prioritas" 
                                            required>
                                        <option value="">-- Pilih Prioritas --</option>
                                        <option value="rendah" {{ old('prioritas', $report->prioritas) == 'rendah' ? 'selected' : '' }}>
                                            🟢 Rendah
                                        </option>
                                        <option value="sedang" {{ old('prioritas', $report->prioritas) == 'sedang' ? 'selected' : '' }}>
                                            🔵 Sedang
                                        </option>
                                        <option value="tinggi" {{ old('prioritas', $report->prioritas) == 'tinggi' ? 'selected' : '' }}>
                                            🟠 Tinggi
                                        </option>
                                        <option value="urgent" {{ old('prioritas', $report->prioritas) == 'urgent' ? 'selected' : '' }}>
                                            🔴 Urgent
                                        </option>
                                    </select>
                                    @error('prioritas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold">
                                    Deskripsi Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" 
                                          name="deskripsi" 
                                          rows="6"
                                          required>{{ old('deskripsi', $report->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Lampiran Lama --}}
                            @if($report->lampiran)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Lampiran Saat Ini</label>
                                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="lni lni-paperclip me-2"></i>
                                            <span>{{ basename($report->lampiran) }}</span>
                                        </div>
                                        <a href="{{ Storage::url($report->lampiran) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="lni lni-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- Upload Lampiran Baru --}}
                            <div class="mb-4">
                                <label for="lampiran" class="form-label fw-semibold">
                                    Upload Lampiran Baru (Opsional)
                                </label>
                                <input type="file" 
                                       class="form-control @error('lampiran') is-invalid @enderror" 
                                       id="lampiran" 
                                       name="lampiran"
                                       accept=".jpg,.jpeg,.png,.pdf">
                                @error('lampiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Format: JPG, PNG, PDF (Max: 2MB). Kosongkan jika tidak ingin mengubah lampiran.
                                </small>
                            </div>

                            {{-- Preview Lampiran Baru --}}
                            <div id="preview-container" class="mb-4" style="display: none;">
                                <div class="alert alert-success d-flex align-items-center">
                                    <i class="lni lni-image me-2"></i>
                                    <span id="preview-name"></span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="lni lni-save"></i> Update Laporan
                                </button>
                                <a href="{{ route('report.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Footer --}}
    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2021 © Mazer</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Crafted with <span class="text-danger">❤️</span> by 
                        <a href="http://ahmadsaugi.com" class="text-decoration-none">A. Saugi</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
    // Preview file lampiran baru
    document.getElementById('lampiran').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const previewName = document.getElementById('preview-name');
        
        if (file) {
            previewName.textContent = `File baru: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            previewContainer.style.display = 'block';
        } else {
            previewContainer.style.display = 'none';
        }
    });
    </script>

    <style>
    .card {
        border-radius: 12px;
    }
    .form-label {
        color: #333;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0052CC;
        box-shadow: 0 0 0 0.2rem rgba(0, 82, 204, 0.15);
    }
    </style>
</body>
</html>