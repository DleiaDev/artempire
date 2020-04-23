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
  <link rel="icon" href="{{ asset('img/icon.png') }}">

  <!-- CSS -->
  <link href="{{ asset('app.css') }}" rel="stylesheet">
</head>
<body>

  <!-- Application -->
  <div id="welcome-page">

    <!-- Top Navbar -->
    @include('auth.inc.navbar-top')

    <!-- Content -->
    <div class="content background">
      <div class="filter">
        <div>
          <h1>Welcome to ArtEmpire</h1>
          <p>A place where you can share your digital<br>creations with the whole world!</p>
          <div class="buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Navbar -->
    @include('auth.inc.navbar-bottom')

  </div>

  <script src="{{ asset('app.js') }}"></script>
</body>
</head>
