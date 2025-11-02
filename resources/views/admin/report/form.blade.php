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
                <i class="mdi mdi-text-box-outline me-1"></i>
                Judul Laporan <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="judul" 
                   class="form-control form-control-lg shadow-sm" 
                   required 
                   maxlength="255"
                   value="{{ old('judul', $report->judul ?? '') }}"
                   placeholder="Masukkan judul laporan...">
            @error('judul') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
        </div>
    </div>

    <!-- Kategori & Prioritas -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-tag-outline me-1"></i>
                Kategori <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="kategori" 
                   list="kategori-list" 
                   class="form-control shadow-sm" 
                   required
                   value="{{ old('kategori', $report->kategori ?? '') }}" 
                   placeholder="Pilih atau ketik kategori...">
            <datalist id="kategori-list">
                <option value="bug">
                <option value="kerusakan">
                <option value="keluhan">
                <option value="permintaan fitur">
            </datalist>
            @error('kategori') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-flag-outline me-1"></i>
                Prioritas <span class="text-danger">*</span>
            </label>
            <select name="prioritas" class="form-select shadow-sm" required>
                <option value="">-- Pilih Prioritas --</option>
                <option value="rendah" {{ old('prioritas', $report->prioritas ?? '') == 'rendah' ? 'selected' : '' }}>
                    🟢 Rendah
                </option>
                <option value="sedang" {{ old('prioritas', $report->prioritas ?? '') == 'sedang' ? 'selected' : '' }}>
                    🟡 Sedang
                </option>
                <option value="tinggi" {{ old('prioritas', $report->prioritas ?? '') == 'tinggi' ? 'selected' : '' }}>
                    🟠 Tinggi
                </option>
                <option value="urgent" {{ old('prioritas', $report->prioritas ?? '') == 'urgent' ? 'selected' : '' }}>
                    🔴 Urgent
                </option>
            </select>
            @error('prioritas') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-text-subject me-1"></i>
                Deskripsi <span class="text-danger">*</span>
            </label>
            <textarea name="deskripsi" 
                      rows="6" 
                      class="form-control shadow-sm" 
                      required 
                      placeholder="Jelaskan detail masalah yang Anda alami...">{{ old('deskripsi', $report->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror
        </div>
    </div>

    <!-- Lampiran -->
    <div class="row mb-4">
        <div class="col-md-12">
            <label class="form-label fw-semibold text-dark mb-2">
                <i class="mdi mdi-paperclip me-1"></i>
                Lampiran
                <small class="text-muted">(JPG/PNG/PDF - max 2MB)</small>
            </label>
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-light">
                    <i class="mdi mdi-upload"></i>
                </span>
                <input type="file" 
                       name="lampiran" 
                       accept=".jpg,.jpeg,.png,.pdf" 
                       class="form-control">
            </div>
            @error('lampiran') <small class="text-danger mt-1 d-block">{{ $message }}</small> @enderror

            @if(isset($report) && $report->lampiran)
                <div class="alert alert-success mt-3 py-2 px-3 d-flex align-items-center">
                    <i class="mdi mdi-check-circle me-2"></i>
                    <span>
                        Lampiran saat ini: 
                        <a href="{{ Storage::url($report->lampiran) }}" 
                           target="_blank" 
                           class="fw-semibold text-decoration-underline">
                            {{ basename($report->lampiran) }}
                        </a>
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                <a href="{{ route('admin.report.index') }}" 
                   class="btn btn-outline-secondary px-4">
                    <i class="mdi mdi-arrow-left me-1"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                    <i class="mdi mdi-check me-1"></i>
                    {{ isset($report) ? 'Update Laporan' : 'Kirim Laporan' }}
                </button>
            </div>
        </div>
    </div>
</form>

<style>
    #reportForm {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    #reportForm .form-control,
    #reportForm .form-select {
        border: 1px solid #e0e6ed;
        border-radius: 8px;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
    }
    
    #reportForm .form-control:focus,
    #reportForm .form-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
    }
    
    #reportForm .form-label {
        font-size: 0.95rem;
        color: #1e293b;
    }
    
    #reportForm textarea.form-control {
        resize: vertical;
        min-height: 150px;
    }
    
    #reportForm .input-group-text {
        border: 1px solid #e0e6ed;
        border-radius: 8px 0 0 8px;
    }
    
    #reportForm .btn {
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    #reportForm .btn-primary {
        background: linear-gradient(135deg, #4361ee 0%, #3730a3 100%);
        border: none;
    }
    
    #reportForm .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
    }
    
    #reportForm .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }
    
    #reportForm .alert-success {
        background-color: #f0fdf4;
        border: 1px solid #86efac;
        border-radius: 8px;
        color: #166534;
    }
    
    #reportForm .shadow-sm {
        box-shadow: 0 1px 3px rgba(0,0,0,0.08) !important;
    }
</style>