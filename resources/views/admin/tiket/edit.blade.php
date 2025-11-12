@extends('layouts.admin.master')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Tiket</h4>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.tiket.update', $tiket->tiket_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Tiket</label>
                            <input type="text" class="form-control" value="{{ $tiket->kode_tiket }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Waktu Dibuat</label>
                            <input type="text" class="form-control" value="{{ $tiket->waktu_dibuat->format('d M Y H:i') }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama User (Pembuat Tiket)</label>
                            <select name="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->user_id }}" {{ $tiket->user_id == $user->user_id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event</label>
                            <select name="event_id" class="form-control">
                                @foreach ($events as $event)
                                    <option value="{{ $event->event_id }}" {{ $tiket->event_id == $event->event_id ? 'selected' : '' }}>
                                        {{ $event->nama_event }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Judul Tiket</label>
                    <input type="text" name="judul" class="form-control" value="{{ $tiket->judul }}" required>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori_id" class="form-control" id="kategori_select">
                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat->kategori_id }}" {{ $tiket->kategori_id == $kat->kategori_id ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Prioritas</label>
                            <select name="prioritas_id" class="form-control">
                                @foreach ($prioritas as $prio)
                                    <option value="{{ $prio->prioritas_id }}" {{ $tiket->prioritas_id == $prio->prioritas_id ? 'selected' : '' }}>
                                        {{ $prio->nama_prioritas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status_id" class="form-control">
                                @foreach ($statuses as $st)
                                    <option value="{{ $st->status_id }}" {{ $tiket->status_id == $st->status_id ? 'selected' : '' }}>
                                        {{ $st->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- 🆕 ASSIGNMENT TIM TEKNISI / KONTEN --}}
                <div class="form-group">
                    <label>
                        <i class="mdi mdi-account-tie"></i> 
                        Tugaskan Ke Tim
                        <small class="text-muted">(Opsional - Pilih berdasarkan kategori tiket)</small>
                    </label>
                    <select name="assigned_to" class="form-control" id="assigned_to_select">
                        <option value="">-- Belum Ditugaskan --</option>
                        
                        <optgroup label="Tim Teknisi">
                            @foreach ($timTeknisi as $teknisi)
                                <option value="{{ $teknisi->user_id }}" {{ $tiket->assigned_to == $teknisi->user_id ? 'selected' : '' }}>
                                    {{ $teknisi->name }} (Teknisi)
                                </option>
                            @endforeach
                        </optgroup>
                        
                        <optgroup label="Tim Konten">
                            @foreach ($timKonten as $konten)
                                <option value="{{ $konten->user_id }}" {{ $tiket->assigned_to == $konten->user_id ? 'selected' : '' }}>
                                    {{ $konten->name }} (Konten)
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    <small class="form-text text-muted">
                        💡 <strong>Tips:</strong> Pilih tim teknisi untuk masalah teknis, pilih tim konten untuk masalah konten/media.
                    </small>
                </div>

                {{-- Info tim yang sedang ditugaskan --}}
                @if($tiket->assignedTo)
                <div class="alert alert-info">
                    <i class="mdi mdi-information"></i>
                    Saat ini ditugaskan ke: <strong>{{ $tiket->assignedTo->name }}</strong> 
                    ({{ ucfirst($tiket->assignedTo->role) }})
                </div>
                @endif

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4">{{ $tiket->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label>Waktu Selesai (Opsional)</label>
                    <input type="datetime-local" name="waktu_selesai" class="form-control" 
                           value="{{ $tiket->waktu_selesai ? $tiket->waktu_selesai->format('Y-m-d\TH:i') : '' }}">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-content-save"></i> Update Tiket
                    </button>
                    <a href="{{ route('admin.tiket.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 🆕 JavaScript untuk auto-select tim berdasarkan kategori --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategori_select');
    const assignedToSelect = document.getElementById('assigned_to_select');
    
    // Auto-suggest tim berdasarkan kategori
    kategoriSelect.addEventListener('change', function() {
        const kategoriText = this.options[this.selectedIndex].text.toLowerCase();
        
        // Reset selection jika sudah ada yang dipilih
        if (assignedToSelect.value !== '') {
            if (!confirm('Anda sudah menugaskan tiket ini. Apakah ingin mengubah tim yang ditugaskan berdasarkan kategori?')) {
                return;
            }
        }
        
        // Auto-select berdasarkan kategori
        const options = assignedToSelect.options;
        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].text.toLowerCase();
            
            // Jika kategori mengandung kata "teknis", "sistem", "hardware", dll -> pilih teknisi pertama
            if ((kategoriText.includes('teknis') || kategoriText.includes('sistem') || 
                 kategoriText.includes('hardware') || kategoriText.includes('software')) && 
                optionText.includes('teknisi')) {
                assignedToSelect.selectedIndex = i;
                assignedToSelect.style.borderColor = '#28a745';
                setTimeout(() => assignedToSelect.style.borderColor = '', 2000);
                break;
            }
            
            // Jika kategori mengandung kata "konten", "media", "desain" -> pilih konten pertama
            if ((kategoriText.includes('konten') || kategoriText.includes('media') || 
                 kategoriText.includes('desain')) && 
                optionText.includes('konten')) {
                assignedToSelect.selectedIndex = i;
                assignedToSelect.style.borderColor = '#28a745';
                setTimeout(() => assignedToSelect.style.borderColor = '', 2000);
                break;
            }
        }
    });
});
</script>
@endpush
@endsection