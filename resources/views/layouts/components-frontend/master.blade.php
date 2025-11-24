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
    @stack('styles')

</head>

<body>
  <div class="container-scroller">

    <div class="container-scroller">
  <!-- SIDEBAR (tetap pakai yang lama, tapi sekarang fixed kiri) -->
  <div class="sidebar-wrapper position-fixed start-0 top-0 h-100">
    @include('layouts.components-frontend.sidebar')
  </div>

  <!-- MAIN PANEL (agar konten tidak tertutup sidebar) -->
  <div class="page-body-wrapper" style="margin-left: 260px;">
    <!-- NAVBAR (tetap pakai yang lama, tapi sekarang fixed top) -->
    <div class="position-fixed top-0 start-0 end-0 z-index-1030">
      @include('layouts.components-frontend.navbar')
    </div>

    <!-- CONTENT (diberi padding atas agar tidak tertutup navbar) -->
    <div class="main-panel mt-5 pt-4">
      @yield('content')
    </div>
  </div>
</div>


  </div>

 <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
    <script src="{{ asset('user/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>
</body>
</html>