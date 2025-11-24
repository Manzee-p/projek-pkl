<!DOCTYPE html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Web Helpdesk – Platform Support Client & Vendor</title>
    <meta name="description" content="Sistem tiket modern untuk client dan vendor dengan SLA real-time." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/lindy-uikit.css') }}" />
    <style>
        :root{--primary:#0052CC;--secondary:#172B4D;--accent:#00B8D9;}
        .button{background:var(--primary);border-color:var(--primary);}
        .button:hover{background:var(--secondary);}
    </style>
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">
            You are using an <strong>outdated</strong> browser. Please
            <a href="https://browsehappy.com/">upgrade your browser</a> to improve
            your experience and security.
        </p>
    <![endif]-->

    <!-- ========================= preloader start ========================= -->
    <div class="preloader">
        <div class="loader">
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================= preloader end ========================= -->

    <!-- ========================= hero-section-wrapper-5 start ========================= -->
    <section id="home" class="hero-section-wrapper-5">
         @include('layouts.components-frontend.navbar')
        @include('layouts.components-frontend.sidebar')

        <div class="hero-section hero-style-5 img-bg" style="background-image: url('{{ asset('user/img/hero/hero-5/hero-bg.svg') }}')">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero-content-wrapper">
                            <h2 class="mb-30 wow fadeInUp" data-wow-delay=".2s">Web Helpdesk Platform</h2>
                            <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">
                                Satu pintu untuk seluruh tiket client & vendor, dilengkapi SLA otomatis dan dashboard real-time.
                            </p>
                            <a href="{{ route('tiket.create') }}" class B="button button-lg radius-50 wow fadeInUp" data-wow-delay=".6s">
                                Buat Tiket Baru <i class="lni lni-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 align-self-end">
                        <div class="hero-image wow fadeInUp" data-wow-delay=".5s">
                            <img src="{{ asset('user/img/hero/hero-5/hero-img.svg') }}" alt="Dashboard Helpdesk">
                        </div>
                    </div>
                </div>
            </div>
</div>
    </section>

    <!-- ========================= feature style-5 start ========================= -->
    <section id="feature" class="feature-section feature-style-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-8">
                    <div class="section-title text-center mb-60">
                        <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">Fitur Inti Helpdesk</h3>
                        <p class="wow fadeInUp" data-wow-delay=".4s">
                            Dirancang khusus untuk client dan vendor dengan SLA ketat.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="icon">
                            <i class="lni lni-ticket-alt"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Pembuatan Tiket Instan</h5>
                            <p>Client & vendor buat tiket dalam 3 klik, otomatis masuk antrian SLA.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                        <div class="icon">
                            <i class="lni lni-timer"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>SLA Otomatis</h5>
                            <p>Timer countdown per level prioritas, notifikasi escalation real-time.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                        <div class="icon">
                            <i class="lni lni-dashboard"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Dashboard Agent</h5>
                            <p>Lihat semua tiket, status, dan performa tim dalam satu layar.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="icon">
                            <i class="lni lni-package"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Knowledge Base</h5>
                            <p>Artikel solusi yang bisa diakses client sebelum buat tiket.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                        <div class="icon">
                            <i class="lni lni-shield"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Secure & Audit Trail</h5>
                            <p>Setiap aksi terekam, enkripsi data, SSO enterprise ready.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                        <div class="icon">
                            <i class="lni lni-mobile"></i>
                            <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                            </svg>
                        </div>
                        <div class="content">
                            <h5>Responsif Total</h5>
                            <p>Akses tiket dari ponsel, tablet, atau desktop tanpa hambatan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================= about style-4 start ========================= -->
    <section id="about" class="about-section about-style-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6">
                    <div class="about-content-wrapper">
                        <div class="section-title mb-30">
                            <h3 class="mb-25 wow fadeInUp" data-wow-delay=".2s">Helpdesk Dimulai Dari Sini</h3>
                            <p class="wow fadeInUp" data-wow-delay=".3s">
                                Satu platform untuk mengelola ribuan tiket client & vendor dengan SLA ketat.
                            </p>
                        </div>
                        <ul>
                            <li class="wow fadeInUp" data-wow-delay=".35s">
                                <i class="lni lni-checkmark-circle"></i>
                                Tiket masuk → otomatis routing ke agent sesuai skill.
                            </li>
                            <li class="wow fadeInUp" data-wow-delay=".4s">
                                <i class="lni lni-checkmark-circle"></i>
                                Dashboard KPI: First Response Time, Resolution Time, CSAT.
                            </li>
                            <li class="wow fadeInUp" data-wow-delay=".45s">
                                <i class="lni lni-checkmark-circle"></i>
                                Laporan ekspor PDF/Excel untuk audit bulanan.
                            </li>
                        </ul>
                        <a href="#0" class="button button-lg radius-10 wow fadeInUp" data-wow-delay=".5s">
                            Lihat Demo SLA
                        </a>
                    </div>
                </div>
                <div class="col-xl- 7 col-lg-6">
                    <div class="about-image text-lg-right wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset('user/img/about/about-4/about-img.svg') }}" alt="Workflow Helpdesk">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================= contact-style-3 start ========================= -->
    <section id="contact" class="contact-section contact-style-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-10">
                    <div class="section-title text-center mb-50">
                        <h3 class="mb-15">Butuh Demo?</h3>
                        <p>Tim kami siap demo 15 menit, langsung dari dashboard Anda.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <form action="" method="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" name="name" class="form-input" placeholder="Nama Lengkap">
                                        <i class="lni lni-user"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="email" name="email" class="form-input" placeholder="Email Kerja">
                                        <i class="lni lni-envelope"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" name="company" class="form-input" placeholder="Perusahaan">
                                        <i class="lni lni-apartment"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-input">
                                        <input type="text" name="phone" class="form-input" placeholder="No. WhatsApp">
                                        <i class="lni lni-whatsapp"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-input">
                                        <textarea name="message" class="form-input" placeholder="Jumlah agent & kebutuhan khusus" rows="6"></textarea>
                                        <i class="lni lni-comments-alt"></i>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-button">
                                        <button type="submit" class="button">
                                            <i class="lni lni-telegram-original"></i> Minta Demo
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="left-wrapper">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon"><i class="lni lni-headphone-alt"></i></div>
                                    <div class="text">
                                        <p>021-3456-7890</p>
                                        <p>+62 812-9999-8888</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon"><i class="lni lni-envelope"></i></div>
                                    <div class="text">
                                        <p>sales@webhelpdesk.id</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="single-item">
                                    <div class="icon"><i class="lni lni-map-marker"></i></div>
                                    <div class="text">
                                        <p>Gedung Cyber 2 Lt.18, Jakarta</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================= clients-logo start ========================= -->
    <section class="clients-logo-section pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="client-logo wow fadeInUp" data-wow-delay=".2s">
                        <img src="{{ asset('user/img/clients/brands.svg') }}" alt="Client Helpdesk" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.components-frontend.footer')

    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>

    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
    <script src="{{ asset('user/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>
</body>
</html>