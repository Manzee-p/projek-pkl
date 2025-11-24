@extends('layouts.components-frontend.master')
@section('pageTitle', 'Daftar Tiket Saya')

@section('content')
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

    @endsection