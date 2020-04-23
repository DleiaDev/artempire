<!-- Header -->
@include('auth.inc.header')

<!-- Main -->
<div id="auth-page">

  <!-- Top Navbar -->
  @include('auth.inc.navbar-top')

  <!-- Card -->
  <div class="card">

    <!-- Left -->
    <div class="left"></div>

    <!-- Right -->
    <div class="right">

      <div class="header">
        <h1>Login</h1>
        <p>
          You can use this sample account for accessing the application:<br><br>
          Username: &nbsp;sample<br>
          Password: &nbsp;sample123
        </p>
      </div>

      <form id="login-form" method="POST" action="{{ route('login') }}">
        <!-- CSRF -->
        @csrf
        <!-- Username -->
        <div class="form-group">
          <label for="username" class="form-label">Username</label>
          <input
            id="username"
            type="text"
            class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
            name="username"
            value="{{ old('username') ? old('username') : 'sample' }}"
            spellcheck="false"
            required
            autofocus
          >
          @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('username') }}</strong>
            </span>
          @endif
        </div>
        <!-- Password -->
        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input
            id="password"
            type="password"
            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
            name="password"
            required
            autocomplete="off"
            spellcheck="false"
            value="{{ old('password') ? '' : 'sample123' }}"
          >
          @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif
        </div>
        <!-- Remember Me -->
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Remember Me</label>
          </div>
        </div>
        <!-- Submit -->
        <div class="form-group auth-submit">
          <button class="btn btn-primary" type="submit">Login</button>
        </div>
        <!-- Register link -->
        <div class="auth-links text-center">
          <a href="{{ route('register') }}">Not a member yet?</a>
        </div>

      </form>

    </div>

  </div>

</div>
