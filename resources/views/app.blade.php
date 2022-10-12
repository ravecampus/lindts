<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <meta name="keywords" content="au theme template">
    <title>{{env('MIX_APP_NAME')}}</title>


    <!-- Fontfaces CSS-->
    <link href="{{ asset(url('css/font-face.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/font-awesome-4.7/css/font-awesome.min.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/font-awesome-5/css/fontawesome-all.min.css'))}}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/mdi-font/css/material-design-iconic-font.min.css')) }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset(url('vendor/bootstrap-4.1/bootstrap.min.css')) }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset(url('vendor/animsition/animsition.min.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/wow/animate.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/css-hamburgers/hamburgers.min.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/slick/slick.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/select2/select2.min.css')) }}" rel="stylesheet" media="all">
    <link href="{{ asset(url('vendor/perfect-scrollbar/perfect-scrollbar.css')) }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset(url('css/theme.css'))}}" rel="stylesheet" media="all">
   

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset(url('assets/vendor/animate.css/animate.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/bootstrap/css/bootstrap.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/bootstrap-icons/bootstrap-icons.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/boxicons/css/boxicons.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/glightbox/css/glightbox.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(url('assets/vendor/swiper/swiper-bundle.min.css')) }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset(url('assets/css/style.css')) }}" rel="stylesheet">


    <!-- <link rel="stylesheet" type="text/css" href="{{ asset(url('/css/font-awesome/css/font-awesome.min.css')) }}"> -->
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body class="animsition" id="app">
@if (Auth::check())
    @php
    $user_auth_data = [
        'isLoggedin' => true,
        'user' =>  Auth::user()
    ];
    @endphp
@else
    @php
    $user_auth_data = [
        'isLoggedin' => false
    ];
    @endphp
@endif


<script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap JS-->
<script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
<!-- Vendor JS       -->
<script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset(url('vendor/wow/wow.min.js')) }}"></script>
<script src="{{ asset(url('vendor/animsition/animsition.min.js')) }}"></script>
<script src="{{ asset(url('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')) }}">
</script>
<script src="{{ asset(url('vendor/counter-up/jquery.waypoints.min.js')) }}"></script>
<script src="{{ asset(url('vendor/counter-up/jquery.counterup.min.js')) }}">
</script>
<script src="{{ asset(url('vendor/circle-progress/circle-progress.min.js')) }}"></script>
<script src="{{ asset( url('vendor/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset( url('vendor/chartjs/Chart.bundle.min.js')) }}"></script>
<script src="{{ asset(url('vendor/select2/select2.min.js')) }}">
</script>

<!-- Main JS-->
<script src="{{ asset(url('js/main.js')) }}"></script>


    <script src="{{ asset(url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')) }}"></script>
    <script src="{{ asset(url('assets/vendor/glightbox/js/glightbox.min.js')) }}"></script>
    <script src="{{ asset(url('assets/vendor/isotope-layout/isotope.pkgd.min.js')) }}"></script>
    <script src="{{ asset(url('assets/vendor/swiper/swiper-bundle.min.js')) }}"></script>
    <script src="{{ asset(url('assets/vendor/php-email-form/validate.js')) }}"></script>

    <!-- Template Main JS File -->
    


<script>
    window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
</script>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset(url('assets/js/main.js')) }}"></script> -->
</body>
</html>