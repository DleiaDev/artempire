<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <!-- Icons -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

  <!-- Icon -->
  <link rel="icon" href="/img/icon.png">

  <!-- CSS -->
  <link href="{{ asset('app.css') }}" rel="stylesheet">
</head>
<body>

  <!-- Application -->
  <div id="app">

    <!-- Top Navbar -->
    @include('auth.inc.navbar-top')

    <!-- Content -->
    <div class="container">
      @yield('content')
    </div>

    <!-- Bottom Navbar -->
    @include('auth.inc.navbar-bottom')

  </div>

  <script src="{{ asset('app.js') }}"></script>
</body>
</html>
