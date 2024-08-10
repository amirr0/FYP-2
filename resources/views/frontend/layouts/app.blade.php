<!doctype html>
<html>

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend-assets/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend-assets/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend-assets/images/favicon-16x16.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css">

    <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/css/style2.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/assets/css/icons.css') }}" rel="stylesheet" />

    <link href="{{ asset('vendor/flasher/flasher.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/bootstrap.css') }}">
    <script src="{{ asset('dashboard-assets/assets/plugins/jquery/jquery.min.js') }}"></script>

        <!-- Notifications js -->

    @stack('styles')
</head>

<body>
    <main>
        @include('frontend.layouts.header')


        @yield('content')

        @include('frontend.chat.index')
        @include('frontend.layouts.footer')
    </main>
</body>

</html>
<script src="{{ asset('vendor/flasher/flasher.min.js') }}"></script>
@stack('scripts')
