<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content=" name=" description">
    <meta content="" name="author">
    <meta name="keywords" content="">

    <!-- Title -->
    <title>Login</title>

    <!--Favicon -->
    <link rel="icon" href="" type="image/x-icon">

    <!-- Bootstrap css -->
    <link href="{{ asset('dashboard-assets/assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Style css -->
    <link href="{{ asset('dashboard-assets/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/assets/css/boxed.css')}}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/assets/css/dark.css')}}" rel="stylesheet">
    <link href="{{ asset('dashboard-assets/assets/css/skin-modes.css')}}" rel="stylesheet">

    <!-- Animate css -->
    <link href="{{ asset('dashboard-assets/assets/css/animated.css')}}" rel="stylesheet">

    <!---Icons css-->
    <link href="{{ asset('dashboard-assets/assets/css/icons.css')}}" rel="stylesheet">


   <!-- Notifications  Css -->

   <script src="{{ asset('vendor/flasher/flasher.min.css') }}"></script>
    <!-- INTERNAL Time picker css -->
    <!-- Select2 css -->
    <link href="{{ asset('dashboard-assets/assets/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="{{ asset('dashboard-assets/assets/plugins/p-scrollbar/p-scrollbar.css')}}" rel="stylesheet">

</head>

<body>

    @yield('content')

    <!-- Jquery js-->
    <script src="{{ asset('dashboard-assets/assets/plugins/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('dashboard-assets/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('dashboard-assets/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Select2 js -->
    <script src="{{ asset('dashboard-assets/assets/plugins/select2/select2.full.min.js')}}"></script>

    <!-- P-scroll js-->
    <script src="{{ asset('dashboard-assets/assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
  <!-- Notifications js -->
  <script src="{{ asset('vendor/flasher/flasher.min.js') }}"></script>
    <!-- Custom js-->
    <script src="{{ asset('dashboard-assets/assets/js/custom.js') }}"></script>

    @if ($errors->any())
        @foreach ($errors->all() as $index => $error)
            <script>
                flasher.error('{{ $error }}').priority({{ $loop->index + 1 }});
            </script>
        @endforeach
    @endif


</body>

</html>
