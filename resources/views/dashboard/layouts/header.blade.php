<!--app header-->
<div class="app-header header">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="header-brand" href="{{ route('backend.dashboard') }}">
                {{-- <img src="{{ asset('dashboard-assets/assets/images/brand/logo.png') }}"
                    class="header-brand-img desktop-lgo" alt="Dayonelogo">
                <img src="{{ asset('dashboard-assets/assets/images/brand/logo-white.png') }}"
                    class="header-brand-img dark-logo" alt="Dayonelogo">
                <img src="{{ asset('dashboard-assets/assets/images/brand/favicon.png') }}"
                    class="header-brand-img mobile-logo" alt="Dayonelogo">
                <img src="{{ asset('dashboard-assets/assets/images/brand/favicon1.png') }}"
                    class="header-brand-img darkmobile-logo" alt="Dayonelogo"> --}}

                FYP
            </a>
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="#">
                    <i class="feather feather-menu"></i>
                </a>
                <a class="close-toggle" href="#">
                    <i class="feather feather-x"></i>
                </a>
            </div>

            <div class="d-flex order-lg-2 my-auto ms-auto">
                <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex ms-auto">

                            <div class="dropdown header-fullscreen mt-1">
                                <a class="nav-link icon full-screen-link">
                                    <i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                                    <i
                                        class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                                </a>
                            </div>
                            <div class="dropdown header-fullscreen mt-1">
                                <a class="nav-link icon full-screen-link" href="{{ route('services.index') }}">
                                    <i class="feather feather-home sidemenu_icon"></i>
                                </a>
                            </div>

                            <div class="dropdown profile-dropdown">
                                <a href="#" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
                                    <span>
                                        <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('dashboard-assets/assets/images/users/16.jpg') }}" alt="img" class="avatar avatar-md bradius">

                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                                    <div class="p-3 text-center border-bottom">
                                        <a href="profile-1.html"
                                            class="text-center user pb-0 font-weight-bold">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                                        </a>
                                        <p class="text-center user-semi-title">{{ Auth::user()->role->name }}</p>
                                    </div>

                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#updateProfileModal"><i class="feather feather-user me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Profile</div></a>

                                    <a class="dropdown-item d-flex" href="{{ route('logout') }}">
                                        <i class="feather feather-power me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Sign Out</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app header -->
