<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket - Web Helpdesk</title>
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-custom navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="lni lni-ticket-alt"></i> Web Helpdesk
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tiket.index') }}">Kembali ke Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="container">
            <div class="page-header">
                <h1><i class="lni lni-pencil"></i> Edit Tiket</h1>
                <p class="text-muted mb-0">Ubah informasi tiket sesuai kebutuhan Anda</p>
            </div>

            <div class="form-card">
                <form action="{{ route('tiket.update', $tiket->tiket_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Tiket</label>
                        <input type="text" name="judul" value="{{ old('judul', $tiket->judul) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" rows="5" class="form-control" required>{{ old('deskripsi', $tiket->deskripsi) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}" {{ $tiket->kategori_id == $kategori->kategori_id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Prioritas</label>
                            <select name="prioritas_id" class="form-select" required>
                                <option value="">Pilih Prioritas</option>
                                @foreach($prioritas as $prior)
                                    <option value="{{ $prior->prioritas_id }}" {{ $tiket->prioritas_id == $prior->prioritas_id ? 'selected' : '' }}>
                                        {{ $prior->nama_prioritas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status_id" class="form-select" required>
                                <option value="">Pilih Status</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->status_id }}" {{ $tiket->status_id == $status->status_id ? 'selected' : '' }}>
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('tiket.show', $tiket->tiket_id) }}" class="btn btn-secondary-custom">
                            <i class="lni lni-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="lni lni-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
</body>
</html>

<style>
    :root {
        --primary: #0052CC;
        --secondary: #172B4D;
    }
    body {
        background: #F4F5F7;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    }
    .navbar-custom {
        background: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 1rem 0;
    }
    .navbar-brand {
        font-weight: 700;
        color: var(--primary) !important;
        font-size: 1.5rem;
    }
    .main-container {
        padding: 40px 0;
        min-height: calc(100vh - 80px);
    }
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    .btn-primary-custom {
        background: var(--primary);
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }
    .btn-primary-custom:hover {
        background: var(--secondary);
        transform: translateY(-2px);
    }
    .btn-secondary-custom {
        background: #6B778C;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        color: white;
        transition: all 0.3s;
    }
    .btn-secondary-custom:hover {
        background: #4E5D73;
    }
    .form-select, .form-control {
        border-radius: 8px;
        border: 2px solid #DFE1E6;
        padding: 10px 15px;
    }
    .form-select:focus, .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
    }
</style>
