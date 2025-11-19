<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Detail Tiket - {{ $tiket->judul }}</title>

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />

    <!-- Custom CSS (inline untuk kemudahan) -->
    <style>
        :root{
            --primary:#1976ff; /* header blue */
            --primary-2:#5ab3ff; /* secondary header */
            --card-bg:#ffffff;
            --muted:#6b7280;
            --surface:#F4F5F7;
        }

        /* Page */
        body{
            background: var(--surface);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin:0;
            -webkit-font-smoothing:antialiased;
        }

        /* Navbar */
        .navbar-custom{
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .navbar-brand{
            color: var(--primary) !important;
            font-weight:700;
            font-size:1.25rem;
        }

        /* Page header card */
        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: white;
            padding: 36px 28px;
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(25,118,255,0.12);
            margin-bottom: 26px;
        }
        .page-header .header-icon {
            width:72px;
            height:72px;
            border-radius:14px;
            background: white;
            display:flex;
            align-items:center;
            justify-content:center;
            color:var(--primary);
            font-size:28px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            margin-bottom:12px;
        }
        .page-header h1{
            margin:0;
            font-size:22px;
            font-weight:700;
        }
        .page-header p{ margin:6px 0 0; opacity:0.95; }

        /* Main container / card */
        .container-main {
            max-width:1020px;
            margin: 18px auto 60px;
            padding: 0 16px;
        }

        .card-detail {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(16,24,40,0.06);
            overflow: hidden;
            border: none;
        }
        .card-body {
            padding: 22px;
        }

        .meta {
            color: var(--muted);
            font-size: 0.95rem;
        }

        /* Badges */
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight:600;
            text-transform:uppercase;
            letter-spacing:0.4px;
            display:inline-block;
            margin-right:8px;
        }
        .badge-open{ background:#DEEBFF;color:#0052CC; }
        .badge-progress{ background:#FFFAE6;color:#FF991F; }
        .badge-resolved{ background:#E3FCEF;color:#00875A; }
        .badge-closed{ background:#F4F5F7;color:#6B778C; }

        .badge-prioritas{
            padding:5px 10px;
            border-radius:14px;
            font-size:0.78rem;
            font-weight:600;
            display:inline-flex;
            align-items:center;
            gap:8px;
        }
        .badge-critical{ background:#FFEBE6;color:#DE350B; }
        .badge-high{ background:#FFFAE6;color:#FF991F; }
        .badge-medium{ background:#FFF7D6;color:#FF8B00; }
        .badge-low{ background:#E3FCEF;color:#00875A; }

        /* description box */
        .description-box{
            background:#fbfcfe;
            border-radius:10px;
            padding:14px;
            border:1px solid #eef2f7;
            color:#111827;
        }

        /* info / attachment */
        .btn-ghost {
            border-radius:10px;
            padding:6px 10px;
        }

        /* Completed CTA card */
        .cta-complete {
            border-radius:12px;
            overflow:hidden;
            color:white;
        }
        .cta-complete .card-body { padding:18px; }
        .cta-complete .btn-light {
            border-radius:10px;
            font-weight:600;
        }

        /* Comments area */
        .comments-card {
            border-radius:12px;
            overflow:visible;
        }
        .comment-box{
            background:#fff;
            border-left:6px solid var(--primary);
            border-radius: 10px;
            padding:18px;
            position:relative;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .comment-box + .comment-box { margin-top:14px; }
        .comment-box:hover{
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(16,24,40,0.08);
        }
        .comment-icon {
            position:absolute;
            left:-28px;
            top:18px;
            width:56px;
            height:56px;
            border-radius:50%;
            background: #fff;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 6px 18px rgba(16,24,40,0.08);
            font-size:20px;
            color:var(--primary);
        }
        .rating-stars { letter-spacing:2px; font-size:1.05rem; }
        .small-muted { color:var(--muted); font-size:0.86rem; }

        /* responsive tweaks */
        @media (max-width:768px){
            .page-header{ padding:28px 18px; }
            .page-header h1{ font-size:20px; }
            .container-main{ padding: 0 12px; }
            .comment-icon{ left:-22px; top:14px; width:50px; height:50px; font-size:18px; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
        @include('layouts.components-frontend.navbar')


    <!-- HEADER (blue + icon) -->
    <div class="container-main">
        <div class="page-header">
            <div class="header-icon">
                <i class="lni lni-ticket"></i>
            </div>
            <h1>Detail Tiket</h1>
            <p class="mb-0">Informasi lengkap tiket Anda</p>
        </div>

        <!-- DETAIL CARD -->
        <div class="card card-detail mb-4">
            <div class="card-body">
                <h4 class="fw-bold mb-2">{{ $tiket->judul }}</h4>

                <div class="meta mb-3">
                    <i class="lni lni-calendar"></i>
                    Dibuat: {{ \Carbon\Carbon::parse($tiket->waktu_dibuat)->format('d M Y, H:i') }}
                    <br>
                    <i class="lni lni-user"></i> Oleh: {{ $tiket->user->name }}
                </div>

                <div class="mb-3">
                    @php
                        $statusName = $tiket->status->nama_status ?? 'Open';
                        $statusClass = 'badge-open';
                        if($statusName == 'In Progress') $statusClass = 'badge-progress';
                        elseif($statusName == 'Resolved') $statusClass = 'badge-resolved';
                        elseif($statusName == 'Closed') $statusClass = 'badge-closed';
                    @endphp

                    <span class="badge-status {{ $statusClass }}">{{ $statusName }}</span>

                    @php
                        $p = strtolower($tiket->prioritas->nama_prioritas ?? '');
                        if(str_contains($p,'critical')) $pc = 'badge-critical';
                        elseif(str_contains($p,'high')) $pc = 'badge-high';
                        elseif(str_contains($p,'medium')) $pc = 'badge-medium';
                        else $pc = 'badge-low';
                    @endphp
                    <span class="badge-prioritas {{ $pc }}">
                        <i class="lni lni-flag"></i>
                        {{ $tiket->prioritas->nama_prioritas ?? '-' }}
                    </span>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-secondary">Kategori</h6>
                    <p>{{ $tiket->kategori->nama_kategori ?? '-' }}</p>

                    <h6 class="fw-bold text-secondary">Event Terkait</h6>
                    <p>{{ $tiket->event->nama_event ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-secondary">Deskripsi</h6>
                    <div class="description-box">
                        {!! nl2br(e($tiket->deskripsi)) !!}
                    </div>
                </div>

                @if($tiket->lampiran)
                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary">Lampiran</h6>
                        <a href="{{ asset('storage/lampiran/' . $tiket->lampiran) }}" target="_blank"
                           class="btn btn-outline-primary btn-ghost btn-sm">
                            <i class="lni lni-download"></i> Unduh Lampiran
                        </a>
                    </div>
                @endif

                <div class="mb-4">
                    <h6 class="fw-bold text-secondary">Riwayat Status</h6>
                    @if($tiket->riwayat && $tiket->riwayat->count() > 0)
                        <ul class="list-group">
                            @foreach($tiket->riwayat as $log)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="lni lni-timer"></i>
                                        {{ $log->status->nama_status ?? '-' }} oleh {{ $log->user->name ?? '-' }}
                                    </span>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada riwayat status.</p>
                    @endif
                </div>

                <div class="text-end">
                    <a href="{{ route('tiket.index') }}" class="btn btn-secondary">
                        <i class="lni lni-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- CTA COMMENT WHEN FINISHED -->
        @if($tiket->status->nama_status === 'Selesai')
            @if(!$tiket->hasUserComment(Auth::id()))
                <div class="card cta-complete mb-4" style="background: linear-gradient(135deg,#667eea,#764ba2);">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="lni lni-checkmark-circle" style="font-size:40px;margin-right:12px;"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Tiket Anda Telah Selesai! 🎉</h5>
                                <p class="mb-0 small">Berikan komentar dan rating untuk membantu kami meningkatkan layanan.</p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('tiket.komentar.form', $tiket->tiket_id) }}" class="btn btn-light btn-lg">
                                <i class="lni lni-comments"></i> Berikan Komentar
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-success border-0 mb-4 d-flex align-items-center">
                    <i class="lni lni-checkmark-circle fs-4 me-3"></i>
                    <div><strong>Terima Kasih!</strong> Anda sudah memberikan komentar untuk tiket ini.</div>
                </div>
            @endif
        @endif

        <!-- COMMENTS -->
        @php $userComments = $tiket->komentars->where('user_id', Auth::id()); @endphp
        @if($userComments && $userComments->count() > 0)
            <div class="card comments-card mb-5">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold"><i class="lni lni-comments text-primary"></i> Komentar Anda</h5>
                </div>

                <div class="card-body">
                    @foreach($userComments as $komentar)
                        <div class="comment-box">
                            <div class="comment-icon">
                                @if($komentar->tipe_komentar === 'feedback')
                                    <i class="lni lni-thumbs-up"></i>
                                @elseif($komentar->tipe_komentar === 'evaluasi')
                                    <i class="lni lni-bar-chart"></i>
                                @else
                                    <i class="lni lni-warning"></i>
                                @endif
                            </div>

                            <div style="margin-left:44px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge rounded-pill px-3 py-2
                                            @if($komentar->tipe_komentar === 'feedback') bg-primary
                                            @elseif($komentar->tipe_komentar === 'evaluasi') bg-success
                                            @else bg-danger
                                            @endif">
                                            @if($komentar->tipe_komentar === 'feedback') Feedback
                                            @elseif($komentar->tipe_komentar === 'evaluasi') Evaluasi
                                            @else Keluhan
                                            @endif
                                        </span>

                                        <p class="small-muted mt-2 mb-1">
                                            <i class="lni lni-calendar"></i>
                                            {{ $komentar->waktu_komentar->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                    <div class="text-end">
                                        <div class="rating-stars mb-1">{{ str_repeat('⭐', $komentar->rating) }}</div>
                                        <small class="small-muted fw-semibold">
                                            @if($komentar->rating == 5) Sangat Puas
                                            @elseif($komentar->rating == 4) Puas
                                            @elseif($komentar->rating == 3) Cukup
                                            @elseif($komentar->rating == 2) Tidak Puas
                                            @else Sangat Tidak Puas
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <p class="mt-3 mb-0">{{ $komentar->komentar }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div> <!-- .container-main -->

    <!-- Bootstrap JS -->
    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
</body>
</html>
