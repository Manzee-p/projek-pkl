<!-- ========================= header-6 start ========================= -->
<header class="header header-6" style="position: fixed; top: 0; width: 100%; z-index: 1000; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
  <div class="navbar-area">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ url('/') }}" style="display: flex; align-items: center;">
              <img src="{{ asset('user/img/logo/logoo.jpeg') }}" alt="Logo" style="height: 45px;" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent6" aria-controls="navbarSupportedContent6" aria-expanded="false" aria-label="Toggle navigation">
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
              <span class="toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent6">
              <ul id="nav6" class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="page-scroll {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}#home">Home</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="{{ url('/') }}#feature">Feature</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="{{ url('/') }}#about">About</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="{{ url('/') }}#pricing">Pricing</a>
                </li>
                <li class="nav-item">
                  <a class="page-scroll" href="{{ url('/') }}#contact">Contact</a>
                </li>

                @auth
                  <!-- Menu untuk user yang sudah login -->
                  <li class="nav-item">
                    <a class="page-scroll {{ request()->routeIs('tiket.*') ? 'active' : '' }}" href="{{ route('tiket.index') }}" style="display: flex; align-items: center; gap: 5px;">
                      <i class="lni lni-ticket"></i> Tiket Saya
                    </a>
                  </li>
                @endauth
              </ul>

              <!-- User Menu - Pindah ke dalam collapse untuk responsive -->
              <div class="d-flex align-items-center ms-auto navbar-user-menu">
                @auth
                  <!-- User sudah login -->
                  <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle user-dropdown-btn" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="user-avatar-nav me-2">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                      </div>
                      <span class="user-name-nav d-none d-lg-inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow user-dropdown-menu" aria-labelledby="dropdownUser">
                      <li class="dropdown-header">
                        <strong>{{ auth()->user()->name }}</strong>
                        <br>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                      </li>
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <a class="dropdown-item" href="{{ route('home') }}">
                          <i class="lni lni-dashboard"></i> Dashboard
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="{{ route('tiket.index') }}">
                          <i class="lni lni-ticket"></i> Tiket Saya
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="{{ route('tiket.create') }}">
                          <i class="lni lni-plus"></i> Buat Tiket
                        </a>
                      </li>
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                          @csrf
                          <button type="submit" class="dropdown-item text-danger">
                            <i class="lni lni-exit"></i> Logout
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                @else
                  <!-- User belum login -->
                  <a href="{{ route('login') }}" class="btn btn-login me-2">
                    <i class="lni lni-enter"></i> Login
                  </a>
                  <a href="{{ route('register') }}" class="btn btn-register">
                    <i class="lni lni-user"></i> Register
                  </a>
                @endauth
              </div>
            </div>
            <!-- navbar collapse -->
          </nav>
          <!-- navbar -->
        </div>
      </div>
      <!-- row -->
    </div>
    <!-- container -->
  </div>
  <!-- navbar area -->
</header>
<!-- ========================= header-6 end ========================= -->

<style>
  .header-action .dropdown-menu {
    min-width: 200px;
    border-radius: 12px;
    padding: 10px;
    margin-top: 10px;
  }
  .header-action .dropdown-item {
    border-radius: 8px;
    padding: 10px 15px;
    transition: all 0.3s;
  }
  .header-action .dropdown-item:hover {
    background: #EBF4FF;
    color: #0052CC;
  }
  .header-action .dropdown-item i {
    margin-right: 8px;
    width: 20px;
  }
  .page-scroll.active {
    color: #0052CC !important;
    font-weight: 600;
  }
  .navbar-nav .nav-item .page-scroll {
    display: flex;
    align-items: center;
    gap: 5px;
  }
</style>