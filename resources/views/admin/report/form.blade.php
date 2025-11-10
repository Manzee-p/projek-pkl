<form id="reportForm"
      action="{{ isset($report) ? route('admin.report.update', $report->id) : route('admin.report.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-6">

    @csrf
    @if(isset($report)) @method('PUT') @endif

    <!-- Judul Laporan -->
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-text-box-outline me-1"></i> Judul Laporan <span class="text-danger">*</span>
            </label>
            <input type="text" name="judul" class="form-control form-control-lg shadow-sm"
                required maxlength="255"
                value="{{ old('judul', $report->judul ?? '') }}"
                placeholder="Masukkan judul laporan...">
            @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <!-- Kategori & Prioritas -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-tag-outline me-1"></i> Kategori <span class="text-danger">*</span>
            </label>
            <input type="text" name="kategori" list="kategori-list" class="form-control shadow-sm"
                required value="{{ old('kategori', $report->kategori ?? '') }}"
                placeholder="Pilih atau ketik kategori...">
            <datalist id="kategori-list">
                <option value="bug">
                <option value="kerusakan">
                <option value="keluhan">
                <option value="permintaan fitur">
            </datalist>
            @error('kategori') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-flag-outline me-1"></i> Prioritas <span class="text-danger">*</span>
            </label>
            <select name="prioritas" class="form-select shadow-sm" required>
                <option value="">-- Pilih Prioritas --</option>
                @foreach(['rendah'=>'🟢 Rendah','sedang'=>'🟡 Sedang','tinggi'=>'🟠 Tinggi','urgent'=>'🔴 Urgent'] as $val => $label)
                    <option value="{{ $val }}" {{ old('prioritas', $report->prioritas ?? '') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('prioritas') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    <!-- ✅ Tambahan: Menugaskan Laporan ke Role -->
<div class="mb-3">
    <label for="assigned_to" class="form-label">Tugaskan ke</label>
    <select name="assigned_to" id="assigned_to" class="form-select">
        <option value="">-- Pilih Petugas --</option>
        <optgroup label="Tim Teknisi">
            @foreach($teknisis as $t)
                <option value="{{ $t->user_id }}" {{ $report->assigned_to == $t->user_id ? 'selected' : '' }}>
                    {{ $t->name }}
                </option>
            @endforeach
        </optgroup>
        <optgroup label="Tim Konten">
            @foreach($kontens as $k)
                <option value="{{ $k->user_id }}" {{ $report->assigned_to == $k->user_id ? 'selected' : '' }}>
                    {{ $k->name }}
                </option>
            @endforeach
        </optgroup>
    </select>
</div>


    <!-- Deskripsi -->
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-text-subject me-1"></i> Deskripsi <span class="text-danger">*</span>
            </label>
            <textarea name="deskripsi" rows="6" class="form-control shadow-sm" required
                placeholder="Jelaskan detail masalah...">{{ old('deskripsi', $report->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
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
                <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf" class="form-control">
            </div>
            @if(isset($report) && $report->lampiran)
                <div class="alert alert-success mt-3 py-2 px-3 d-flex align-items-center">
                    <i class="mdi mdi-check-circle me-2"></i>
                    <span>Lampiran saat ini:
                        <a href="{{ Storage::url($report->lampiran) }}" target="_blank" class="fw-semibold text-decoration-underline">
                            {{ basename($report->lampiran) }}
                        </a>
                    </span>
                </div>
            @endif
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
                    <i class="mdi mdi-check me-1"></i>
                    {{ isset($report) ? 'Update Laporan' : 'Kirim Laporan' }}
                </button>
            </div>
        </div>
    </div>
</form>
