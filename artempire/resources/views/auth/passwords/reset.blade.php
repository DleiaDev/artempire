@extends('layouts.app')

@section('content')

  <div class="page-header text-center">
    <h1>Reset password</h1>
    <p>
      You have proved you are the email owner.<br>
      You can safely update your password now.<br>
      We just need your email one more time.
    </p>
  </div>

  <form id="reset-password-form" class="auth-form text-center" method="POST" action="{{ route('password.update') }}">

    <!-- CSRF -->
    @csrf

    <!-- Password reset token -->
    <input type="hidden" name="token" value="{{ $token }}">

    <!-- Email -->
    <div class="form-group">
      <label for="email" class="form-label">Email</label>
      <input
        id="email"
        type="email"
        class="auth-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
        name="email"
        value="{{ $email ?? old('email') }}"
        required
        autofocus
      >
    </div>

    <!-- New password -->
    <div class="form-group">
      <label for="password" class="form-label">New Password</label>
      <input
        id="password"
        type="password"
        class="auth-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
        name="password"
        required
      >
    </div>

    <!-- Repeat new password -->
    <div class="form-group">
      <label for="password-confirm" class="form-label">Repeat New Password</label>
      <input
        id="password-confirm"
        type="password"
        class="auth-input form-control"
        name="password_confirmation"
        required
      >
    </div>

    <!-- Submit -->
    <div class="form-group">
      <a class="my-button-primary" onclick="document.getElementById('reset-password-form').submit();">Reset Password</a>
    </div>

  </form>
@endsection
