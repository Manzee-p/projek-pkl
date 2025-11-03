<!-- ========================= header-6 start ========================= -->
<header class="header header-6 py-2 shadow-sm bg-light">
    <div class="container">
        <nav class="navbar navbar-expand-lg align-items-center">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('user/img/logo/logoo.jpeg') }}" alt="Logo" height="50" class="me-2 rounded" />
                <h5 class="mb-0 fw-bold text-primary"></h5>
            </a>

            {{-- Toggle button for mobile --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar content --}}
            <div class="collapse navbar-collapse justify-content-center" id="navbarContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item mx-2">
                        <a class="nav-link active text-primary fw-semibold" href="#home">Home</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#feature">Feature</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#about">About</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link text-dark fw-semibold" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>

            {{-- Right section: actions + profile --}}
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-dark fs-5"><i class="lni lni-cart"></i></a>
                <a href="#" class="text-dark fs-5"><i class="lni lni-alarm"></i></a>

                {{-- Profile Dropdown --}}
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/faces/pp.jpg') }}" alt="Profile" width="40"
                            height="40" class="rounded-circle me-2" />
                        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                        aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-settings text-primary me-2"></i>Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- ========================= header-6 end ========================= -->
