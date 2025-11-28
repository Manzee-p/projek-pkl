<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket - {{ $tiket->judul }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
</head>
<body>
    @include('layouts.components-frontend.navbar')

    <div class="container py-4" style="min-height: calc(100vh - 200px);">
        {{-- Breadcrumb / Back Button --}}
        <div class="mb-4">
            <a href="{{ route('tiket.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="ti ti-arrow-left"></i> Kembali ke Tiket
            </a>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Header Card with Title and Badges --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-2 text-dark">{{ $tiket->judul }}</h2>
                        <div class="d-flex flex-wrap gap-3 align-items-center text-muted small">
                            <span>
                                <i class="ti ti-calendar-event me-1"></i>
                                Dibuat {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }}
                            </span>
                            <span>
                                <i class="ti ti-user me-1"></i>
                                {{ $tiket->user->name }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap align-items-start">
                        {{-- Badge Prioritas --}}
                        @php
                            $p = strtolower($tiket->prioritas->nama_prioritas ?? '');
                            $prioritasColor = 'secondary';
                            if(str_contains($p,'critical')) $prioritasColor = 'danger';
                            elseif(str_contains($p,'high')) $prioritasColor = 'danger';
                            elseif(str_contains($p,'medium')) $prioritasColor = 'warning';
                            else $prioritasColor = 'info';
                        @endphp
                        <span class="badge px-3 py-2 bg-{{ $prioritasColor }}">
                            <i class="ti ti-flag-filled me-1"></i>
                            {{ $tiket->prioritas->nama_prioritas ?? 'Medium' }}
                        </span>
                        
                        {{-- Badge Status --}}
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
                        <span class="badge px-3 py-2 bg-{{ $statusColor }}">
                            <i class="ti ti-{{ $statusIcon }} me-1"></i>
                            {{ $statusName }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description Card --}}
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3 text-uppercase small text-muted">
                    <i class="ti ti-align-left me-2"></i>Deskripsi Tiket
                </h6>
                <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.7;">{{ $tiket->deskripsi }}</p>
            </div>
        </div>

        {{-- Info Cards Row --}}
        <div class="row g-3 mb-3">
            {{-- Kategori --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-opacity-10 rounded-circle p-3">
                                    <i class="ti ti-tag text-primary fs-5"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small fw-semibold text-uppercase">Kategori</p>
                                <h6 class="mb-0 fw-bold">{{ $tiket->kategori->nama_kategori ?? 'Tidak ada' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Event Terkait --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-opacity-10 rounded-circle p-3">
                                    <i class="ti ti-calendar-event text-info fs-5"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small fw-semibold text-uppercase">Event Terkait</p>
                                <h6 class="mb-0 fw-bold">{{ $tiket->event->nama_event ?? 'Tidak ada' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Created Date --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class=" bg-opacity-10 rounded-circle p-3">
                                    <i class="ti ti-clock text-success fs-5"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-muted mb-1 small fw-semibold text-uppercase">Dibuat</p>
                                <h6 class="mb-0 fw-bold">{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->diffForHumans() }}</h6>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lampiran Section --}}
        @if($tiket->lampiran)
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-3 text-uppercase small text-muted">
                        <i class="ti ti-paperclip me-2"></i>Lampiran
                    </h6>
                    <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3">
                        <div class="flex-shrink-0">
                            <i class="ti ti-file-text fs-1 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1 fw-semibold">File Lampiran</p>
                            <small class="text-muted">{{ basename($tiket->lampiran) }}</small>
                        </div>
                        <a href="{{ asset('storage/lampiran/' . $tiket->lampiran) }}" target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="ti ti-eye me-1"></i> Lihat File
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- CTA COMMENT WHEN FINISHED --}}
        @if($tiket->status->nama_status === 'Selesai')
            @if(!$tiket->hasUserComment(Auth::id()))
                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden" style="background: linear-gradient(135deg,#667eea,#764ba2);">
                    <div class="card-body p-4">
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
                </div>
            @else
                <div class="alert alert-success border-0 mb-3 d-flex align-items-center rounded-4">
                    <i class="ti ti-circle-check fs-4 me-3"></i>
                    <div><strong>Terima Kasih!</strong> Anda sudah memberikan komentar untuk tiket ini.</div>
                </div>
            @endif
        @endif

        {{-- Timeline Section (Riwayat Status) --}}
        @if($tiket->riwayat && $tiket->riwayat->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-4 text-uppercase small text-muted">
                    <i class="ti ti-history me-2"></i>Riwayat Status
                </h6>
                <div class="timeline-container">
                    @foreach($tiket->riwayat as $index => $log)
                        <div class="timeline-item">
                            <div class="timeline-dot bg-{{ $index === 0 ? 'success' : 'primary' }}"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-semibold mb-1">{{ $log->status->nama_status ?? '-' }}</h6>
                                        <small class="text-muted">
                                            <i class="ti ti-user me-1"></i>
                                            {{ $log->user->name ?? '-' }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }} WIB
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $index === 0 ? 'success' : 'primary' }}-subtle text-{{ $index === 0 ? 'success' : 'primary' }}">
                                        {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- COMMENTS --}}
        @php $userComments = $tiket->komentars->where('user_id', Auth::id()); @endphp
        @if($userComments && $userComments->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-4 text-uppercase small text-muted">
                    <i class="ti ti-message-circle me-2"></i>Komentar Anda
                </h6>
                
                @foreach($userComments as $komentar)
                    <div class="comment-box mb-3 p-4 bg-light rounded-3 border-start border-4 border-{{ 
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

    {{-- Footer --}}
    <footer class="bg-light py-4 mt-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">2025 © Helpdesk System</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">
                        Dibuat dengan <span class="text-danger">❤️</span> oleh Tim Developer
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <style>
        body {
            background-color: #f5f7fa;
        }

        .card {
            transition: all 0.3s ease;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rounded-4 {
            border-radius: 16px !important;
        }

        h2 {
            color: #2c3e50;
            line-height: 1.4;
        }

        h6 {
            color: #495057;
        }

        p {
            line-height: 1.7;
            color: #4a5568;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
            font-size: 0.875rem;
        }

        .timeline-container {
            position: relative;
            padding-left: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 45px;
            padding-bottom: 30px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 24px;
            height: calc(100% - 12px);
            width: 2px;
            background: linear-gradient(180deg, #e0e7ff 0%, #f0f4f8 100%);
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 16px;
            border-radius: 12px;
            border-left: 3px solid #e0e7ff;
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            background: #fff;
            border-left-color: #6366f1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transform: translateX(2px);
        }

        .badge.bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.1) !important;
            color: #15803d !important;
        }

        .badge.bg-primary-subtle {
            background-color: rgba(59, 130, 246, 0.1) !important;
            color: #1e40af !important;
        }

        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .btn-lg {
            padding: 12px 24px;
            font-size: 1rem;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Card hover effect */
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animation delay for cards */
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:nth-child(5) { animation-delay: 0.5s; }
        .card:nth-child(6) { animation-delay: 0.6s; }

        /* Comment box styling */
        .comment-box {
            transition: all 0.3s ease;
        }

        .comment-box:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
    </style>
</body>
</html>