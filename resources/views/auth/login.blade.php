@extends('layouts.app')
@section('content')

<div class="row h-100">
    <div class="col-lg-5 col-12 d-flex align-items-center justify-content-center">
        <div id="auth-left" style="width: 100%; max-width: 400px;">
            <div class="auth-logo text-center mb-4">
                <a href="/"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" width="120"></a>
            </div>

            <h1 class="auth-title text-center">Log in</h1>
            <p class="auth-subtitle mb-5 text-center">Masuk dengan akun Anda yang terdaftar.</p>

            {{-- ✅ Form Login Laravel --}}
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="email" name="email" class="form-control form-control-xl" placeholder="Email" required>
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" required>
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <div class="form-check form-check-lg d-flex align-items-end mb-4">
                    <input class="form-check-input me-2" type="checkbox" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Keep me logged in
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-3 w-100">Log in</button>
            </form>

            {{-- ✅ Divider --}}
            <div class="text-center text-muted my-3">atau</div>

            {{-- ✅ Tombol Login Google --}}
            <div class="d-grid">
                <a href="{{ url('/auth-google-redirect') }}" class="btn btn-danger btn-block btn-lg shadow-lg w-100">
                    <i class="bi bi-google me-2"></i> Login dengan Google
                </a>
            </div>

            {{-- ✅ Link bawah --}}
            <div class="text-center mt-5 text-lg fs-6">
                <p class="text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-bold">Sign up</a>.
                </p>
                <p>
                    <a class="font-bold" href="#">Forgot password?</a>.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right"></div>
    </div>
</div>

@endsection
