<!-- Header -->
@include('inc.header')

<!-- Application -->
<div id="app" class="auth-app">

  <!-- Messages -->
  @include('inc.messages')

  <!-- Top Navbar -->
  @include('inc.navbar-top')

  <!-- Card -->
  <div class="container">
    <div class="auth-card" id="password-email-card">

      <div class="right">

        <div class="header">
          <h1>Reset password</h1>
          <p>
            If you forgot your password, you can recover it. Just type an email
            of your ArtEmpire account and we will send you an email that contains
            password reset link. This link is important because it proves you are
            an owner of the account.
          </p>
        </div>

        <form id="password-email-form" method="POST" action="{{ route('password.email') }}">
          <!-- CSRF -->
          @csrf
          <!-- Email -->
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input
              id="email"
              type="email"
              class="my-input form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
              name="email"
              value="{{ old('email') }}"
              required
            >
          </div>
          <!-- Submit -->
          <div class="form-group auth-submit">
            <input type="submit" class="my-button-primary" value="Send Email">
          </div>
        </form>

      </div>

    </div>
  </div>

</div>
