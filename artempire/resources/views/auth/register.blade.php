<!-- Header -->
@include('auth.inc.header')

<!-- Application -->
<div id="auth-page">

  <!-- Top Navbar -->
  @include('auth.inc.navbar-top')

  <!-- Card -->
  <div class="card" id="register-card">

    <div class="right">

      <div class="header">
        <h1>Register</h1>
        <p>Join the awesome showcase<br>platform for digital media artists.</p>
      </div>

      <form id="register-form" method="POST" action="{{ route('register') }}">

        <!-- CSRF -->
        @csrf

        <div class="row">
          <!-- Full name -->
          <div class="col col-sm-6 col-12">
            <div class="form-group">
              <label for="fullName" class="form-label">Full name</label>
              <input
                id="fullName"
                type="text"
                class="my-input form-control{{ $errors->has('fullName') ? ' is-invalid' : '' }}"
                name="fullName"
                value="{{ old('fullName') }}"
                autocomplete="off"
                spellcheck="false"
                required
              >
              @if ($errors->has('fullName'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('fullName') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <!-- Email -->
          <div class="col col-sm-6 col-12">
            <div class="form-group">
              <label for="email" class="form-label">Email</label>
              <input
                id="email"
                type="email"
                class="my-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                value="{{ old('email') }}"
                autocomplete="off"
                spellcheck="false"
                required
              >
              @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col col-sm-6 col-12">
            <!-- Username -->
            <div class="form-group">
              <label for="username" class="form-label">Username</label>
              <input
                id="username"
                type="text"
                class="my-input form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                name="username"
                value="{{ old('username') }}"
                autocomplete="off"
                spellcheck="false"
                required
              >
              @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('username') }}</strong>
                </span>
              @endif
              <span class="hint">(this will be displayed all the time)</span>
            </div>
          </div>
          <div class="col col-sm-6 col-12">
            <!-- Password -->
            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input
                id="password"
                type="password"
                class="my-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password"
                required
              >
              @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col col-sm-6 col-12">
            <!-- Repeat password -->
            <div class="form-group">
              <label for="password-confirm" class="form-label">Confirm Password</label>
              <input
                id="password-confirm"
                type="password"
                class="my-input form-control"
                name="password_confirmation"
                required
              >
              @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div>

        <!-- Button -->
        <button class="btn btn-primary" type="submit">Register</button>

        <div class="auth-links">
          <a href="{{ route('login') }}">Already have an account?</a>
        </div>

      </form>

    </div>

  </div>

</div>
