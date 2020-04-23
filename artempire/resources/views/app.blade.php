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

  <!-- Vue -->
  <div id="vue"></div>

  <script>
    window.user = JSON.parse('{!! $userJSON !!}'.replace(/[\r]?[\n]/g, '\\n'));
    @if (isset($profileJSON))
      window.profile = JSON.parse('{!! $profileJSON !!}'.replace(/[\r]?[\n]/g, '\\n'));
    @endif
  </script>

  {{-- <script src="http://localhost:8080/app.js"></script> --}}
  <script src="{{ asset('app.js') }}"></script>
</body>
</html>
