<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tiket Baru - Web Helpdesk</title>
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
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
                    <!-- Event -->
                    <div class="col-md-6 mb-3">
                        <label for="event_id" class="form-label">
                            <i class="lni lni-calendar"></i> Event <span class="required">*</span>
                        </label>
                        <select name="event_id" id="event_id" class="form-select" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->event_id }}" {{ old('event_id') == $event->event_id ? 'selected' : '' }}>
                                    {{ $event->nama_event }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih event terkait masalah Anda</small>
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="kategori_id" class="form-label">
                            <i class="lni lni-tag"></i> Kategori <span class="required">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Pilih kategori yang sesuai</small>
                    </div>

                    <!-- Judul Tiket -->
                    <div class="col-12 mb-3">
                        <label for="judul" class="form-label">
                            <i class="lni lni-text-format"></i> Judul Tiket <span class="required">*</span>
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
                        <small class="text-muted">Tulis judul yang jelas dan deskriptif</small>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12 mb-4">
                        <label for="deskripsi" class="form-label">
                            <i class="lni lni-pencil-alt"></i> Deskripsi Masalah
                        </label>
                        <textarea 
                            name="deskripsi" 
                            id="deskripsi" 
                            class="form-control" 
                            rows="6" 
                            placeholder="Jelaskan masalah Anda secara detail...&#10;&#10;Contoh:&#10;- Apa yang terjadi?&#10;- Kapan masalah muncul?&#10;- Apa yang sudah dicoba?"
                        >{{ old('deskripsi') }}</textarea>
                        <small class="text-muted">Semakin detail deskripsi, semakin cepat kami bisa membantu</small>
                    </div>

                    <!-- Info Box -->
                    <div class="col-12 mb-4">
                        <div class="info-box">
                            <i class="lni lni-information"></i>
                            <div>
                                <strong>Catatan:</strong>
                                <p class="mb-0">Status dan prioritas tiket akan ditentukan otomatis oleh sistem dan dapat disesuaikan oleh admin sesuai kebutuhan.</p>
                            </div>
                        </div>
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
        --success: #00875A;
        --info: #0065FF;
    }
    
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }
    
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        max-width: 800px;
        margin: 0 auto;
        animation: slideUp 0.5s ease;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .form-header h2 {
        color: var(--secondary);
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 28px;
    }
    
    .form-header p {
        color: #6c757d;
        font-size: 16px;
    }
    
    .icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 8px 20px rgba(0, 82, 204, 0.3);
    }
    
    .icon-wrapper i {
        font-size: 35px;
        color: white;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .form-label i {
        color: var(--primary);
        margin-right: 5px;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
        font-size: 14px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 82, 204, 0.15);
        outline: none;
    }
    
    .form-control::placeholder {
        color: #adb5bd;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--info));
        border: none;
        padding: 12px 40px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 82, 204, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--info), var(--primary));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 82, 204, 0.4);
    }
    
    .btn-secondary {
        padding: 12px 40px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .required {
        color: #dc3545;
        font-weight: bold;
    }
    
    .alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
    }
    
    .alert-danger {
        background: #fff5f5;
        color: #dc3545;
    }
    
    small.text-muted {
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }
    
    .info-box {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
        border-left: 4px solid var(--info);
        padding: 16px 20px;
        border-radius: 10px;
        display: flex;
        gap: 15px;
        align-items: flex-start;
    }
    
    .info-box i {
        font-size: 24px;
        color: var(--info);
        flex-shrink: 0;
        margin-top: 2px;
    }
    
    .info-box strong {
        color: var(--secondary);
        display: block;
        margin-bottom: 5px;
    }
    
    .info-box p {
        color: #6c757d;
        font-size: 13px;
        line-height: 1.6;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 30px 20px;
        }
        
        .form-header h2 {
            font-size: 24px;
        }
        
        .btn-primary, .btn-secondary {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column-reverse;
        }
    }
</style>