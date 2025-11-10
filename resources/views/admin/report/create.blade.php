@extends('layouts.admin.master')
@section('pageTitle', 'Buat Laporan Baru')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Buat Laporan Baru</h4>
                    </div>
                    <div class="card-body">
                        <form id="reportForm" action="{{ route('admin.report.store') }}" method="POST"
                            enctype="multipart/form-data" class="space-y-6">

                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            <!-- Judul Laporan -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="mdi mdi-text-box-outline me-1"></i> Judul Laporan <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul" class="form-control form-control-lg shadow-sm"
                                        required maxlength="255" value="{{ old('judul') }}"
                                        placeholder="Masukkan judul laporan...">
                                    @error('judul')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kategori & Prioritas -->
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

                            <!-- Deskripsi -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="mdi mdi-text-subject me-1"></i> Deskripsi <span
                                            class="text-danger">*</span>
                                    </label>
                                    <textarea name="deskripsi" rows="6" class="form-control shadow-sm" required
                                        placeholder="Jelaskan detail masalah...">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Lampiran -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold text-dark mb-2">
                                        <i class="mdi mdi-paperclip me-1"></i> Lampiran
                                        <small class="text-muted">(JPG/PNG/PDF - max 2MB)</small>
                                    </label>
                                    <div class="input-group shadow-sm">
                                        <span class="input-group-text bg-light">
                                            <i class="mdi mdi-upload"></i>
                                        </span>
                                        <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf"
                                            class="form-control">
                                    </div>
                                    @error('lampiran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tombol -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                        <a href="{{ route('admin.report.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="mdi mdi-arrow-left me-1"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                            <i class="mdi mdi-check me-1"></i> Kirim Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
