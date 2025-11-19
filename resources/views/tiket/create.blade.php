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
     {{-- Include Navbar --}}
    @include('layouts.components-frontend.navbar')
    <div class="container">
        <div class="form-container">

            <!-- HEADER BIRU YANG BENAR -->
            <div class="form-header-blue">
                <div class="icon-circle">
                    <i class="lni lni-ticket-alt"></i>
                </div>
                <h2>Buat Tiket Baru</h2>
                <p>Isi formulir di bawah untuk membuat tiket support</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mx-4">
                    <strong><i class="lni lni-warning"></i> Terjadi Kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tiket.store') }}" method="POST" class="px-4 pb-4">
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
                        <input type="text" name="judul" id="judul" class="form-control"
                            placeholder="Contoh: Website tidak bisa diakses"
                            value="{{ old('judul') }}" maxlength="255" required>
                        <small class="text-muted">Tulis judul yang jelas dan deskriptif</small>
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12 mb-4">
                        <label for="deskripsi" class="form-label">
                            <i class="lni lni-pencil-alt"></i> Deskripsi Masalah
                        </label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6"
                            placeholder="Jelaskan masalah Anda secara detail...&#10;&#10;Contoh:&#10;- Apa yang terjadi?&#10;- Kapan masalah muncul?&#10;- Apa yang sudah dicoba?"
                        >{{ old('deskripsi') }}</textarea>
                        <small class="text-muted">Semakin detail deskripsi, semakin cepat kami bisa membantu</small>
                    </div>

                    <!-- Info box -->
                    <div class="col-12 mb-4">
                        <div class="info-box">
                            <i class="lni lni-information"></i>
                            <div>
                                <strong>Catatan:</strong>
                                <p class="mb-0">
                                    Status dan prioritas tiket akan ditentukan otomatis oleh sistem
                                    dan dapat disesuaikan oleh admin sesuai kebutuhan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
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
    body {
    background: #f5f7fa;
    font-family: "Inter", sans-serif;
}

/* Container card */
.form-container {
    max-width: 820px;
    margin: 40px auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 35px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    padding: 0;
}

/* HEADER BIRU */
.form-header-blue {
    background: linear-gradient(135deg, #1e88e5, #42a5f5);
    height: 150px;
    position: relative;
    border-radius: 0 0 40px 0;
    padding-top: 25px;
    text-align: center;
    color: white;
    margin-bottom: 20px;
}

.icon-circle {
    width: 70px;
    height: 70px;
    background: #fff;
    color: #1e88e5;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.form-header-blue h2 {
    font-weight: 700;
    margin-top: 15px;
    font-size: 24px;
}

/* Label */
.form-label {
    font-weight: 600;
    font-size: 14px;
    color: #374151;
}

/* Input */
.form-control,
.form-select {
    border-radius: 10px;
    border: 1px solid #d1d5db;
    padding: 10px 14px;
    font-size: 14px;
}

.form-control:focus,
.form-select:focus {
    border-color: #42a5f5;
    box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.25);
}

/* Info box */
.info-box {
    display: flex;
    gap: 12px;
    background: #e3f2fd;
    border-left: 5px solid #1e88e5;
    padding: 12px 15px;
    border-radius: 10px;
    color: #0d47a1;
}

.info-box i {
    font-size: 24px;
}

/* Tombol */
.btn-primary {
    background: #1e88e5;
    border: none;
    padding: 10px 30px;
    border-radius: 10px;
    font-weight: 600;
}

.btn-primary:hover {
    background: #1565c0;
}

.btn-secondary {
    background: #6b7280;
    border: none;
    padding: 10px 28px;
    border-radius: 10px;
    font-weight: 600;
}

.btn-secondary:hover {
    background: #4b5563;
}

</style>