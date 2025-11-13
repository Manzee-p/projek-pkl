<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tiket Baru - Web Helpdesk</title>
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/lindy-uikit.css') }}" />
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <div class="icon-wrapper">
                    <i class="lni lni-ticket-alt"></i>
                </div>
                <h2>Buat Tiket Baru</h2>
                <p>Isi formulir di bawah untuk membuat tiket support</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong><i class="lni lni-warning"></i> Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tiket.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- User ID (Hidden, akan diisi otomatis dari auth) -->
                    <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">

                    <!-- Event -->
                    <div class="col-md-6 mb-3">
                        <label for="event_id" class="form-label">
                            Event <span class="required">*</span>
                        </label>
                        <select name="event_id" id="event_id" class="form-select" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->event_id }}" {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                    {{ $event->nama_event }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="kategori_id" class="form-label">
                            Kategori <span class="required">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Judul Tiket -->
                    <div class="col-12 mb-3">
                        <label for="judul" class="form-label">
                            Judul Tiket <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="judul" 
                            id="judul" 
                            class="form-control" 
                            placeholder="Contoh: Website tidak bisa diakses"
                            value="{{ old('judul') }}"
                            maxlength="255"
                            required
                        >
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12 mb-4">
                        <label for="deskripsi" class="form-label">
                            Deskripsi Masalah
                        </label>
                        <textarea 
                            name="deskripsi" 
                            id="deskripsi" 
                            class="form-control" 
                            rows="6" 
                            placeholder="Jelaskan masalah Anda secara detail..."
                        >{{ old('deskripsi') }}</textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tiket.index') }}" class="btn btn-secondary">
                                <i class="lni lni-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="lni lni-checkmark-circle"></i> Buat Tiket
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
</body>
</html>

<style>
        :root {
            --primary: #0052CC;
            --secondary: #172B4D;
            --accent: #00B8D9;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .form-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            margin: 0 auto;
        }
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .form-header h2 {
            color: var(--secondary);
            font-weight: 700;
            margin-bottom: 10px;
        }
        .form-header p {
            color: #6c757d;
        }
        .form-label {
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 82, 204, 0.15);
        }
        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 12px 40px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            padding: 12px 40px;
            border-radius: 10px;
            font-weight: 600;
        }
        .required {
            color: #dc3545;
        }
        .alert {
            border-radius: 10px;
            border: none;
        }
        .icon-wrapper {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .icon-wrapper i {
            font-size: 30px;
            color: white;
        }
    </style>