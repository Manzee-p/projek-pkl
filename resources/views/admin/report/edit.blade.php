@extends('layouts.admin.master')
@section('pageTitle', 'Edit Laporan')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Edit Laporan #{{ $report->id }}</h4>
                        <a href="{{ route('admin.report.index') }}" class="btn btn-secondary btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('admin.report.update', $report->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- JUDUL --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Judul Laporan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="judul" class="form-control"
                                    value="{{ old('judul', $report->judul) }}" required>
                                @error('judul')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- KATEGORI & PRIORITAS --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kategori <span
                                            class="text-danger">*</span></label>
                                    <select name="kategori_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->kategori_id }}"
                                                {{ old('kategori_id', $report->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                                {{ ucfirst($kategori->nama_kategori) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Prioritas <span
                                            class="text-danger">*</span></label>
                                    <select name="prioritas_id" class="form-select" required>
                                        <option value="">-- Pilih Prioritas --</option>
                                        @foreach ($priorities as $p)
                                            <option value="{{ $p->prioritas_id }}"
                                                {{ old('prioritas_id', $report->prioritas_id) == $p->prioritas_id ? 'selected' : '' }}>
                                                {{ ucfirst($p->nama_prioritas) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('prioritas_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- PENUGASAN --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tugaskan ke</label>
                                <select name="assigned_to" class="form-select">
                                    <option value="">-- Belum Ditugaskan --</option>
                                    <optgroup label="Tim Teknisi">
                                        @foreach ($teknisis as $t)
                                            <option value="{{ $t->user_id }}"
                                                {{ old('assigned_to', $report->assigned_to) == $t->user_id ? 'selected' : '' }}>
                                                {{ $t->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Tim Konten">
                                        @foreach ($kontens as $k)
                                            <option value="{{ $k->user_id }}"
                                                {{ old('assigned_to', $report->assigned_to) == $k->user_id ? 'selected' : '' }}>
                                                {{ $k->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('assigned_to')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="diproses"
                                        {{ old('status', $report->status) == 'diproses' ? 'selected' : '' }}>Diproses
                                    </option>
                                    <option value="selesai"
                                        {{ old('status', $report->status) == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                            </div>

                            {{-- DESKRIPSI --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" rows="5" class="form-control" required>{{ old('deskripsi', $report->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- LAMPIRAN --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Lampiran</label>
                                <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf" class="form-control">
                                @if ($report->lampiran)
                                    <div class="mt-2">
                                        <small>Lampiran saat ini:
                                            <a href="{{ Storage::url($report->lampiran) }}" target="_blank">
                                                {{ basename($report->lampiran) }}
                                            </a>
                                        </small>
                                    </div>
                                @endif
                                @error('lampiran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- BUTTON --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-check"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.report.index') }}" class="btn btn-outline-secondary">
                                    <i class="mdi mdi-close"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
