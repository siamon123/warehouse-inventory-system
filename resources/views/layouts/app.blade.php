<!DOCTYPE html>
<html>
<head>
  <title>Inventory Management System - @yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  @yield('content')
  <script src="{{asset('js/app.js')}}"></script>
</body>
</html>