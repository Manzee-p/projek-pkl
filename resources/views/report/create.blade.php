<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Baru - Helpdesk</title>

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
                    <h2 class="fw-bold mb-2">📝 Buat Laporan Baru</h2>
                    <p class="text-muted">Laporkan masalah atau keluhan yang Anda alami</p>
                </div>

                {{-- Form Card --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Judul Laporan --}}
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">
                                    Judul Laporan <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('judul') is-invalid @enderror" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul') }}"
                                       placeholder="Contoh: Error saat login ke sistem"
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori & Prioritas --}}
                            <div class="row mb-4">
                                <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <label>Kategori</label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Prioritas</label>
                                    <select name="prioritas_id" class="form-control" required>
                                        <option value="">-- Pilih Prioritas --</option>
                                        @foreach ($prioritas as $prio)
                                            <option value="{{ $prio->prioritas_id }}">{{ $prio->nama_prioritas }}</option>
                                        @endforeach
                                    </select>
                                </div>
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
                                          placeholder="Jelaskan masalah yang Anda alami secara detail..."
                                          required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    <i class="lni lni-information"></i> 
                                    Berikan detail sejelas mungkin agar tim kami bisa membantu dengan cepat
                                </small>
                            </div>

                            {{-- Lampiran --}}
                            <div class="mb-4">
                                <label for="lampiran" class="form-label fw-semibold">
                                    Lampiran (Opsional)
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
                                    Format: JPG, PNG, PDF (Max: 2MB)
                                </small>
                            </div>

                            {{-- Preview Lampiran --}}
                            <div id="preview-container" class="mb-4" style="display: none;">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="lni lni-image me-2"></i>
                                    <span id="preview-name"></span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="lni lni-checkmark-circle"></i> Kirim Laporan
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
    // Preview file lampiran
    document.getElementById('lampiran').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const previewName = document.getElementById('preview-name');
        
        if (file) {
            previewName.textContent = `File terpilih: ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
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