<!--aside open-->
<aside class="app-sidebar">
    <div class="app-sidebar__logo">
        <a class="header-brand text-white" href="{{ route('backend.dashboard') }}">
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
    </div>
    <div class="app-sidebar3">
        <div class="app-sidebar__user">
            <div class="dropdown user-pro-body text-center">
                <div class="user-pic">
                    <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('dashboard-assets/assets/images/users/16.jpg') }}"
                        alt="user-img" class="avatar-xxl rounded-circle mb-1">

                </div>
                <div class="user-info">
                    <h5 class=" mb-2">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                    </h5>
                    <span class="text-muted app-sidebar__user-name text-sm">{{ Auth::user()->role->name }} </span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category mt-4">Dashboards</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('backend.dashboard') }}">
                    <i class="feather feather-home sidemenu_icon"></i>
                    <span class="side-menu__label"><span class="nav-list">Dashboard</span></span>
                </a>
            </li>

            @if (Gate::check('user_management', 'view_users') || Gate::check('role_management', 'view_roles'))
                {{-- @can('user_management', 'view_users|role_management', 'view_roles') --}}
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                        <i class="feather feather-users sidemenu_icon"></i>
                        <span class="side-menu__label">Users</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('user_management', 'view_users')
                            <li><a href="{{ route('backend.users.index') }}" class="slide-item">Users</a></li>
                        @endcan

                        @can('role_management', 'view_roles')
                            <li><a href="{{ route('backend.roles.index') }}" class="slide-item">Roles</a></li>
                        @endcan
                    </ul>
                </li>
            @endif
            @can('service_management', 'view_services')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('backend.services.index') }}">
                        <i class="feather feather-home sidemenu_icon"></i>
                        <span class="side-menu__label"><span class="nav-list">Services</span></span>
                    </a>

                </li>
            @endcan
            @can('package_management', 'view_packages')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('backend.packages.index') }}">
                        <i class="feather feather-home sidemenu_icon"></i>
                        <span class="side-menu__label"><span class="nav-list">Packages</span></span>
                    </a>
                </li>
            @endcan
            @can('item_management', 'view_items')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('backend.items.index') }}">
                        <i class="feather feather-home sidemenu_icon"></i>
                        <span class="side-menu__label"><span class="nav-list">Items</span></span>
                    </a>
                </li>
            @endcan

            @if (Auth::user()->role->name == 'Admin')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('backend.chat.index') }}">
                        <i class="feather feather-home sidemenu_icon"></i>
                        <span class="side-menu__label"><span class="nav-list">Chats</span></span>
                    </a>
                </li>
            @endif
            @can('order_management', 'view_orders')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('backend.orders.index') }}">
                        <i class="feather feather-home sidemenu_icon"></i>
                        <span class="side-menu__label"><span class="nav-list">Orders</span></span>
                    </a>
                </li>
            @endcan


            @php
                $hasPermissions =
                    Gate::check('user_management', 'view_users') ||
                    Gate::check('service_management', 'view_services') ||
                    Gate::check('package_management', 'view_packages') ||
                    Gate::check('item_management', 'view_items');
                Gate::check('role_management', 'view_roles');
            @endphp

            @if ($hasPermissions)
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide" href="#">
                        <i class="feather feather-trash sidemenu_icon"></i>
                        <span class="side-menu__label">Trash</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        @can('role_management', 'view_roles')
                            <li><a href="{{ route('backend.roles.index', ['trashed' => true]) }}"
                                    class="slide-item">Roles</a></li>
                        @endcan
                        @can('user_management', 'view_users')
                            <li><a href="{{ route('backend.users.index', ['trashed' => true]) }}"
                                    class="slide-item">Users</a></li>
                        @endcan
                        @can('service_management', 'view_services')
                            <li><a href="{{ route('backend.services.index', ['trashed' => true]) }}"
                                    class="slide-item">Services</a></li>
                        @endcan
                        @can('package_management', 'view_packages')
                            <li><a href="{{ route('backend.packages.index', ['trashed' => true]) }}"
                                    class="slide-item">Packages</a></li>
                        @endcan
                        @can('item_management', 'view_items')
                            <li><a href="{{ route('backend.items.index', ['trashed' => true]) }}"
                                    class="slide-item">Items</a></li>
                        @endcan
                    </ul>
                </li>
            @endif

        </ul>

    </div>
</aside>
<!--aside closed-->
