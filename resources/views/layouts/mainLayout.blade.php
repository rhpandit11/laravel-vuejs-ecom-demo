<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel-Ecommerce</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('Assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
     <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/Nunito.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sb-admin-2.min.css')}}">
</head>

<body class="layout-fixed layout-navbar-fixed sidebar-mini text-sm layout-footer-fixed">
  <div id="index">                                                               
    @yield('index')
  </div>

    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/bs-init.js')}}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="{{asset('assets/js/Select2-JS-Plugin-style.js')}}"></script>
    <script src="{{asset('assets/js/Select2-JS-Plugin-run.js')}}"></script>
    <script src="{{asset('assets/js/theme.js')}}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>