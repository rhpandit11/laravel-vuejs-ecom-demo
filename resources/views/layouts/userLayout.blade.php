<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel-Ecommerce</title>

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"  rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/userStyle.css')}}">
 
</head>

<body>
  <div id="homePage">                                                               
    @yield('homePage')
  </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>