<header class="header-main">
    <div class="nav-area-full">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 logo-area d-flex flex-wrap justify-content-between align-items-center">
                    <div class="logo"><a href="index.php">
                        {{-- <img class="img-fluid"
                                src="{{ asset('frontend-assets/images/logo.png') }}" alt="*" />
                                 --}}
                                 <h2>FYP</h2>
                            </a>
                    </div>
                    <div>
                        <a href="{{ route('reviews.index') }}"
                            class="btn view__all px-lg-4 px-3 btn-sm btn-primary text-decoration-none text-white">Reviews</a>
                        @if (Auth::check())
                            <a href="{{ route('backend.dashboard') }}"
                                class="btn view__all px-lg-4 px-3 btn-sm btn-primary text-decoration-none text-white">Dashboard</a>
                            <a href="{{ route('logout') }}"
                                class="btn view__all px-lg-4 px-3 btn-sm btn-primary text-decoration-none text-white">Logout</a>
                        @else
                            <a href="{{ route('showLoginForm') }}"
                                class="btn view__all px-lg-4 px-3 btn-sm btn-primary text-decoration-none text-white">Log In</a>
                            <a href="{{ route('showregisterForm') }}"
                                class="btn view__all px-lg-4 px-3 btn-sm btn-primary text-decoration-none text-white">Register</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
