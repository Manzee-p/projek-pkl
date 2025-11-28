@extends('layouts.components-frontend.master')
@section('pageTitle', 'Detail Tiket')

@section('content')

    @include('layouts.components-frontend.navbar')

    <div class="container py-5" style="min-height: calc(100vh - 200px);">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="{{ route('tiket.index') }}" class="text-decoration-none"><i class="ti ti-home me-1"></i>Tiket</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="ti ti-check-circle fs-4 me-3"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- CTA COMMENT WHEN FINISHED --}}
        @if($tiket->status->nama_status === 'Selesai')
            @if(!$tiket->hasUserComment(Auth::id()))
                <div class="alert alert-primary border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg,#667eea,#764ba2);">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 text-white">
                        <div class="d-flex align-items-center gap-3">
                            <i class="ti ti-circle-check" style="font-size:48px;"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Tiket Anda Telah Selesai! 🎉</h5>
                                <p class="mb-0 small opacity-90">Berikan komentar dan rating untuk membantu kami meningkatkan layanan.</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('tiket.komentar.form', $tiket->tiket_id) }}" class="btn btn-light btn-lg">
                                <i class="ti ti-message-circle me-1"></i> Berikan Komentar
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center rounded-4">
                    <i class="ti ti-circle-check fs-4 me-3"></i>
                    <div><strong>Terima Kasih!</strong> Anda sudah memberikan komentar untuk tiket ini.</div>
                </div>
            @endif
        @endif

        <div class="row g-4">
            {{-- Main Content --}}
            <div class="col-lg-8">
                {{-- Header Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white p-4 border-0">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div class="flex-grow-1">
                                <h1 class="h3 fw-bold mb-3">{{ $tiket->judul }}</h1>
                                <div class="d-flex flex-wrap gap-3 align-items-center small opacity-90">
                                    <span>
                                        <i class="ti ti-user-circle me-1"></i>
                                        {{ $tiket->user->name ?? 'Unknown' }}
                                    </span>
                                    <span>
                                        <i class="ti ti-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                @php
                                    $p = strtolower($tiket->prioritas->nama_prioritas ?? '');
                                    $prioritasColor = 'secondary';
                                    if(str_contains($p,'critical') || str_contains($p,'high') || str_contains($p,'tinggi')) {
                                        $prioritasColor = 'danger';
                                    } elseif(str_contains($p,'medium') || str_contains($p,'sedang')) {
                                        $prioritasColor = 'warning';
                                    } else {
                                        $prioritasColor = 'info';
                                    }
                                @endphp
                                <span class="badge badge-priority bg-{{ $prioritasColor }}">
                                    <i class="ti ti-flag-filled me-1"></i>
                                    {{ $tiket->prioritas->nama_prioritas ?? 'Medium' }}
                                </span>
                                
                                @php
                                    $statusName = $tiket->status->nama_status ?? 'Open';
                                    $statusColor = 'secondary';
                                    $statusIcon = 'help';
                                    if($statusName == 'In Progress') {
                                        $statusColor = 'primary';
                                        $statusIcon = 'loader';
                                    } elseif($statusName == 'Resolved' || $statusName == 'Selesai') {
                                        $statusColor = 'success';
                                        $statusIcon = 'check';
                                    } elseif($statusName == 'Closed') {
                                        $statusColor = 'secondary';
                                        $statusIcon = 'x';
                                    } elseif($statusName == 'Open') {
                                        $statusColor = 'warning';
                                        $statusIcon = 'clock';
                                    }
                                @endphp
                                <span class="badge badge-status bg-{{ $statusColor }}">
                                    <i class="ti ti-{{ $statusIcon }} me-1"></i>
                                    {{ $statusName }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-opacity-10 rounded-3 me-3">
                                <i class="ti ti-file-text text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Deskripsi Tiket</h5>
                        </div>
                        <div class="description-content">
                            <p class="mb-0 text-secondary" style="white-space: pre-line; line-height: 1.8;">{{ $tiket->deskripsi }}</p>
                        </div>
                    </div>
                </div>

                {{-- Lampiran Section --}}
                @if($tiket->lampiran)
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box bg-opacity-10 rounded-3 me-3">
                                    <i class="ti ti-paperclip text-info fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Lampiran</h5>
                            </div>
                            <div class="attachment-box">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="file-icon">
                                            <i class="ti ti-file-text"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-semibold">File Lampiran</p>
                                            <small class="text-muted">{{ basename($tiket->lampiran) }}</small>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/lampiran/' . $tiket->lampiran) }}" target="_blank" 
                                       class="btn btn-primary btn-sm rounded-pill">
                                        <i class="ti ti-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- COMMENTS SECTION --}}
                @php $userComments = $tiket->komentars->where('user_id', Auth::id()); @endphp
                @if($userComments && $userComments->count() > 0)
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box bg-opacity-10 rounded-3 me-3">
                                <i class="ti ti-message-circle text-success fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Komentar Anda</h5>
                        </div>
                        
                        @foreach($userComments as $komentar)
                            <div class="comment-box mb-3 p-4 rounded-3 border-start border-4 border-{{ 
                                $komentar->tipe_komentar === 'feedback' ? 'primary' : 
                                ($komentar->tipe_komentar === 'evaluasi' ? 'success' : 'danger') 
                            }}">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-{{ 
                                            $komentar->tipe_komentar === 'feedback' ? 'primary' : 
                                            ($komentar->tipe_komentar === 'evaluasi' ? 'success' : 'danger') 
                                        }}">
                                            <i class="ti ti-{{ 
                                                $komentar->tipe_komentar === 'feedback' ? 'thumb-up' : 
                                                ($komentar->tipe_komentar === 'evaluasi' ? 'chart-bar' : 'alert-circle') 
                                            }} me-1"></i>
                                            @if($komentar->tipe_komentar === 'feedback') Feedback
                                            @elseif($komentar->tipe_komentar === 'evaluasi') Evaluasi
                                            @else Keluhan
                                            @endif
                                        </span>
                                        <small class="text-muted">
                                            <i class="ti ti-calendar me-1"></i>
                                            {{ $komentar->waktu_komentar->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    
                                    <div class="text-end">
                                        <div class="rating-stars mb-1" style="color: #fbbf24; font-size: 1.1rem;">
                                            {{ str_repeat('⭐', $komentar->rating) }}
                                        </div>
                                        <small class="text-muted fw-semibold">
                                            @if($komentar->rating == 5) Sangat Puas
                                            @elseif($komentar->rating == 4) Puas
                                            @elseif($komentar->rating == 3) Cukup
                                            @elseif($komentar->rating == 2) Tidak Puas
                                            @else Sangat Tidak Puas
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                
                                <p class="mb-0 text-dark">{{ $komentar->komentar }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                {{-- Info Cards --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 info-card">
                    <div class="card-body p-4">
                        <div class="info-item">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box-sm bg-opacity-10 rounded-circle me-3">
                                    <i class="ti ti-tag text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Kategori</small>
                                    <h6 class="mb-0 fw-bold">{{ $tiket->kategori->nama_kategori ?? 'Tidak ada' }}</h6>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="info-item">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box-sm bg-opacity-10 rounded-circle me-3">
                                    <i class="ti ti-calendar-event text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Event Terkait</small>
                                    <h6 class="mb-0 fw-bold">{{ $tiket->event->nama_event ?? 'Tidak ada' }}</h6>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="info-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-box-sm bg-opacity-10 rounded-circle me-3">
                                    <i class="ti ti-clock text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block mb-1">Dibuat</small>
                                    <h6 class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->diffForHumans() }}</h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="ti ti-history me-2 text-primary"></i>Riwayat Status
                        </h5>
                        <div class="timeline-modern">
                            @if($tiket->riwayat && $tiket->riwayat->count() > 0)
                                @foreach($tiket->riwayat as $index => $log)
                                    <div class="timeline-item-modern">
                                        <div class="timeline-dot-modern bg-{{ $index === 0 ? 'success' : 'primary' }}"></div>
                                        <div class="timeline-content-modern">
                                            <span class="badge bg-{{ $index === 0 ? 'success' : 'primary' }}-subtle text-{{ $index === 0 ? 'success' : 'primary' }} mb-2">
                                                {{ $log->status->nama_status ?? '-' }}
                                            </span>
                                            <h6 class="fw-semibold mb-1">{{ $log->status->nama_status ?? 'Status Update' }}</h6>
                                            <small class="text-muted d-block mb-1">
                                                <i class="ti ti-user me-1"></i>
                                                {{ $log->user->name ?? '-' }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="ti ti-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }} WIB
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="timeline-item-modern">
                                    <div class="timeline-dot-modern bg-success"></div>
                                    <div class="timeline-content-modern">
                                        <span class="badge bg-success-subtle text-success mb-2">Created</span>
                                        <h6 class="fw-semibold mb-1">Tiket Dibuat</h6>
                                        <small class="text-muted">
                                            <i class="ti ti-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }} WIB
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="footer-modern">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">© 2025 Helpdesk System. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Crafted with <span class="text-danger">❤️</span> by Development Team
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #06b6d4;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Breadcrumb */
        .breadcrumb-item a {
            color: #667eea;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: #764ba2;
        }

        /* Cards */
        .card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
        }

        .rounded-4 {
            border-radius: 20px !important;
        }

        /* Header Card */
        .bg-gradient-primary {
            background: var(--primary-gradient);
        }

        .card-header h1 {
            line-height: 1.4;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Badges */
        .badge-priority,
        .badge-status {
            padding: 10px 18px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
            border-radius: 50px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Icon Boxes */
        .icon-box {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-box-sm {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Description Content */
        .description-content {
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            border-left: 4px solid #667eea;
        }

        /* Attachment Box */
        .attachment-box {
            padding: 20px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 16px;
            border: 2px dashed #06b6d4;
            transition: all 0.3s ease;
        }

        .attachment-box:hover {
            border-color: #0891b2;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        }

        .file-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .file-icon i {
            font-size: 24px;
            color: #06b6d4;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        }

        .info-item {
            transition: all 0.3s ease;
        }

        /* Comment Box */
        .comment-box {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transition: all 0.3s ease;
        }

        .comment-box:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            background: white;
        }

        /* Timeline Modern */
        .timeline-modern {
            position: relative;
            padding-left: 0;
        }

        .timeline-item-modern {
            position: relative;
            padding-left: 50px;
            padding-bottom: 30px;
        }

        .timeline-item-modern:last-child {
            padding-bottom: 0;
        }

        .timeline-item-modern::before {
            content: '';
            position: absolute;
            left: 16px;
            top: 40px;
            height: calc(100% - 30px);
            width: 2px;
            background: linear-gradient(180deg, #667eea 0%, #e9ecef 100%);
        }

        .timeline-item-modern:last-child::before {
            display: none;
        }

        .timeline-dot-modern {
            position: absolute;
            left: 0;
            top: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1;
        }

        .timeline-content-modern {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .timeline-content-modern:hover {
            background: white;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transform: translateX(5px);
        }

        /* Buttons */
        .btn {
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: var(--primary-gradient);
        }

        .btn-light {
            background: white;
            color: #6c757d;
        }

        .btn-light:hover {
            background: #f8f9fa;
            color: #495057;
        }

        .rounded-pill {
            border-radius: 50px !important;
        }

        /* Badge Subtle */
        .bg-success-subtle {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: var(--success-color) !important;
        }

        .bg-primary-subtle {
            background-color: rgba(102, 126, 234, 0.1) !important;
            color: #667eea !important;
        }

        /* Footer */
        .footer-modern {
            background: white;
            padding: 30px 0;
            margin-top: 60px;
            border-top: 1px solid #e9ecef;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.03);
        }

        /* Alert */
        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            border-radius: 16px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Animation Delays */
        .col-lg-8 .card:nth-child(1) { animation-delay: 0.1s; }
        .col-lg-8 .card:nth-child(2) { animation-delay: 0.2s; }
        .col-lg-8 .card:nth-child(3) { animation-delay: 0.3s; }
        .col-lg-8 .card:nth-child(4) { animation-delay: 0.4s; }
        .col-lg-4 .card:nth-child(1) { animation-delay: 0.2s; }
        .col-lg-4 .card:nth-child(2) { animation-delay: 0.3s; }

        /* Responsive */
        @media (max-width: 768px) {
            .card-header h1 {
                font-size: 1.5rem;
            }

            .badge-priority,
            .badge-status {
                padding: 8px 14px;
                font-size: 0.8rem;
            }

            .timeline-item-modern {
                padding-left: 40px;
            }

            .timeline-dot-modern {
                width: 28px;
                height: 28px;
            }
        }
    </style>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

@endsection