<nav id="navbar-top">

  <div class="dropdown mobile">
    <!-- Mobile menu icon -->
    <div id="menu-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-bars icon"></i>
    </div>
    @guest
      <div class="dropdown-menu" aria-labelledby="menu-icon">
        <a href="{{ route('login') }}" class="{{ Request::is('login') ? 'active' : '' }} dropdown-item">
          Login
        </a>
        <a href="{{ route('register') }}" class="{{ Request::is('register') ? 'active' : '' }} dropdown-item">
          Register
        </a>
      </div>
    @else
      <div class="dropdown-menu" aria-labelledby="menu-icon">
        <a href="{{ route('account.edit') }}" class="{{ Request::is('account.edit') ? 'active' : '' }} dropdown-item">
          <i class="fas fa-cog icon"></i>Settings
        </a>
        <a
          class="dropdown-item"
          href="{{ route('logout') }}"
          onclick="event.preventDefault(); loader.fire(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt icon"></i>Logout
        </a>
      </div>
    @endguest
  </div>

  <!-- Logo -->
  <a href="{{ Auth::check() ? route('home') : route('welcome') }}" class="logo">
    Art<span class="empire">Empire</span>
  </a>

  @guest
    <!-- Page links -->
    <div class="links">
      <a href="{{ route('login') }}" class="{{ Request::is('login') ? 'active' : '' }}">Login</a>
      <a href="{{ route('register') }}" class="{{ Request::is('register') ? 'active' : '' }}">Register</a>
    </div>
  @else
    <!-- Main links -->
    <div class="links icons">
      <a href="{{ route('home') }}" class="{{ Request::is('home') ? 'active' : '' }}">
        <i class="fas fa-home"></i>
      </a>
      <a href="{{ route('upload') }}" class="{{ Request::is('upload') ? 'active' : '' }}">
        <i class="fas fa-plus-square"></i>
      </a>
      <a href="{{ route('search') }}" class="{{ Request::is('search') ? 'active' : '' }}">
        <i class="fas fa-search"></i>
      </a>
      <a href="{{ route('chat') }}" class="{{ Request::is('chat') ? 'active' : '' }}">
        <i class="fas fa-comments"></i>
      </a>
      <div class="dropdown">
        <a
          href="#"
          class="dropdown-toggle {{ Request::is('user/*') ? 'active' : '' }}"
          id="profileDropdownButton"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false">
          <i class="fas fa-user-circle"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdownButton">
          <a
            class="dropdown-item"
            href="{{ route('profile', ['username' => Auth::user()->username]) }}">
            <i class="fas fa-user icon"></i>My Profile
          </a>
          <a
            class="dropdown-item"
            href="{{ route('account.edit') }}">
            <i class="fas fa-cog icon"></i>Settings
          </a>
          <a
            class="dropdown-item"
            href="{{ route('logout') }}"
            onclick="event.preventDefault(); loader.fire(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt icon"></i>Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
  @endguest

</nav>
