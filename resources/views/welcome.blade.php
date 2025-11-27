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

        /* ===== SIDEBAR ===== */
        .navbar-height { height: 70px !important; }
        .sidebar {
            width: 260px;
            height: calc(100vh - 70px);
            position: fixed;
            left: 0;
            top: 70px;
            background: #ffffff;
            border-right: 1px solid #e5e5e5;
            padding: 20px 15px 0 15px;
            transition: all .3s ease;
            z-index: 9998;
        }
        .sidebar-inner {
            height: calc(100vh - 120px);
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .logo h5,
        .sidebar.collapsed .sidebar-menu span {
            display: none !important;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            color: #333;
            font-weight: 600;
            transition: .2s;
            text-decoration: none;
            white-space: nowrap;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #EBF4FF;
            color: #0052CC;
        }
        .sidebar-menu i { font-size: 20px; }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            transition: margin-left 0.3s ease;
            margin-left: 260px; /* default sidebar width */
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: 80px; /* collapsed width */
        }

        /* MOBILE */
        @media(max-width: 992px) {
            .sidebar { left: -260px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; }
            .sidebar.show ~ .main-content { margin-left: 260px; }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
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

    <!-- ========================= SIDEBAR ========================= -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-menu">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="lni lni-home"></i> <span>Home</span>
                </a>
                @auth
                <hr>
                <a href="{{ route('tiket.index') }}" class="{{ request()->routeIs('tiket.*') ? 'active' : '' }}">
                    <i class="lni lni-ticket"></i> <span>Tiket Saya</span>
                </a>
                <a href="{{ route('report.index') }}" class="{{ request()->routeIs('report.*') ? 'active' : '' }}">
                    <i class="lni lni-files"></i> <span>Laporan</span>
                </a>
                <a href="{{ route('notifications.index') }}"><i class="lni lni-alarm"></i> <span>Notifikasi</span></a>
                <hr>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="lni lni-exit"></i> <span>Logout</span>
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
                @endauth
                @guest
                <hr>
                <a href="{{ route('login') }}"><i class="lni lni-enter"></i> <span>Login</span></a>
                <a href="{{ route('register') }}"><i class="lni lni-user"></i> <span>Register</span></a>
                @endguest
            </div>
        </div>
    </div>

    <!-- ========================= NAVBAR ========================= -->
    @include('layouts.components-frontend.navbar')

    <!-- ========================= MAIN CONTENT ========================= -->
    <div id="main-content" class="main-content">
        <!-- Hero Section -->
        <section id="home" class="hero-section-wrapper-5">
            <div class="hero-section hero-style-5 img-bg" style="background-image: url('{{ asset('user/img/hero/hero-5/hero-bg.svg') }}')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero-content-wrapper">
                                <h2 class="mb-30 wow fadeInUp" data-wow-delay=".2s">Web Helpdesk Platform</h2>
                                <p class="mb-30 wow fadeInUp" data-wow-delay=".4s">
                                    Satu pintu untuk seluruh tiket client & vendor, dilengkapi SLA otomatis dan dashboard real-time.
                                </p>
                                <a href="{{ route('tiket.create') }}" class="button button-lg radius-50 wow fadeInUp" data-wow-delay=".6s">
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

        <!-- Feature Section -->
        <section id="feature" class="feature-section feature-style-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-8">
            <div class="section-title text-center mb-60">
              <h3 class="mb-15 wow fadeInUp" data-wow-delay=".2s">Specializing In</h3>
              <p class="wow fadeInUp" data-wow-delay=".4s">Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed!</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6">
            <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
              <div class="icon">
                <i class="lni lni-vector"></i>
                <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                  </svg>                  
              </div>
              <div class="content">
                <h5>Graphics Design</h5>
                <p>Short description for the ones who look for something new.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
              <div class="icon">
                <i class="lni lni-pallet"></i>
                <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                  </svg> 
              </div>
              <div class="content">
                <h5>Print Design</h5>
                <p>Short description for the ones who look for something new.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
              <div class="icon">
                <i class="lni lni-stats-up"></i>
                <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                  </svg> 
              </div>
              <div class="content">
                <h5>Business Analysis</h5>
                <p>Short description for the ones who look for something new.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
              <div class="icon">
                <i class="lni lni-code-alt"></i>
                <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                  </svg> 
              </div>
              <div class="content">
                <h5>Web Development</h5>
                <p>Short description for the ones who look for something new.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
              <div class="icon">
                <i class="lni lni-lock"></i>
                <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                  </svg> 
              </div>
              <div class="content">
                <h5>Best Security</h5>
                <p>Short description for the ones who look for something new.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
              <div class="icon">
                <i class="lni lni-code"></i>
                <svg width="110" height="72" viewBox="0 0 110 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M110 54.7589C110 85.0014 85.3757 66.2583 55 66.2583C24.6243 66.2583 0 85.0014 0 54.7589C0 24.5164 24.6243 0 55 0C85.3757 0 110 24.5164 110 54.7589Z" fill="#EBF4FF"/>
                  </svg> 
              </div>
              <div class="content">
                <h5>Web Design</h5>
                <p>Short description for the ones who look for something new.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

        <!-- About Section -->
        <section id="about" class="about-section about-style-4">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-5 col-lg-6">
            <div class="about-content-wrapper">
              <div class="section-title mb-30">
                <h3 class="mb-25 wow fadeInUp" data-wow-delay=".2s">The future of designing starts here</h3>
                <p class="wow fadeInUp" data-wow-delay=".3s">Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed,</p>
              </div>
              <ul>
                <li class="wow fadeInUp" data-wow-delay=".35s">
                  <i class="lni lni-checkmark-circle"></i>
                  Stop wasting time and money designing and managing a website that doesn’t get results.
                </li>
                <li class="wow fadeInUp" data-wow-delay=".4s">
                  <i class="lni lni-checkmark-circle"></i>
                  Stop wasting time and money designing and managing.
                </li>
                <li class="wow fadeInUp" data-wow-delay=".45s">
                  <i class="lni lni-checkmark-circle"></i>
                  Stop wasting time and money designing and managing a website that doesn’t get results.
                </li>
              </ul>
              <a href="#0" class="button button-lg radius-10 wow fadeInUp" data-wow-delay=".5s">Learn More</a>
            </div>
          </div>
          <div class="col-xl-7 col-lg-6">
            <div class="about-image text-lg-right wow fadeInUp" data-wow-delay=".5s">
              <img src="assets/img/about/about-4/about-img.svg" alt="">
            </div>
          </div>
        </div>
      </div>
    </section>

        <!-- Contact Section -->
        <section id="contact" class="contact-section contact-style-3">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xxl-5 col-xl-5 col-lg-7 col-md-10">
            <div class="section-title text-center mb-50">
              <h3 class="mb-15">Get in touch</h3>
              <p>Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed!</p>
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
                      <input type="text" id="name" name="name" class="form-input" placeholder="Name">
                      <i class="lni lni-user"></i>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="single-input">
                      <input type="email" id="email" name="email" class="form-input" placeholder="Email">
                      <i class="lni lni-envelope"></i>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="single-input">
                      <input type="text" id="number" name="number" class="form-input" placeholder="Number">
                      <i class="lni lni-phone"></i>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="single-input">
                      <input type="text" id="subject" name="subject" class="form-input" placeholder="Subject">
                      <i class="lni lni-text-format"></i>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="single-input">
                      <textarea name="message" id="message" class="form-input" placeholder="Message" rows="6"></textarea>
                      <i class="lni lni-comments-alt"></i>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-button">
                      <button type="submit" class="button"> <i class="lni lni-telegram-original"></i> Submit</button>
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
                    <div class="icon">
                      <i class="lni lni-phone"></i>
                    </div>
                    <div class="text">
                      <p>0045939863784</p>
                      <p>+004389478327</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 col-md-6">
                  <div class="single-item">
                    <div class="icon">
                      <i class="lni lni-envelope"></i>
                    </div>
                    <div class="text">
                      <p>yourmail@gmail.com</p>
                      <p>admin@yourwebsite.com</p>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12 col-md-6">
                  <div class="single-item">
                    <div class="icon">
                      <i class="lni lni-map-marker"></i>
                    </div>
                    <div class="text">
                      <p>John's House, 13/5 Road, Sidny United State Of America</p>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </section>

        <!-- Clients Logo -->
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
    </div>

    <!-- Scroll Top -->
    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>

    <!-- ========================= JS ========================= -->
    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
    <script src="{{ asset('user/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
            sidebar.classList.toggle("show");
        }
    </script>
</body>
</html>