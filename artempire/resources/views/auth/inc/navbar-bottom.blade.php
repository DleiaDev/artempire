@guest
@else
  <nav id="navbar-bottom">
    <div class="links">
      <a href="{{ route('home') }}" class="{{ Request::is('home') ? 'active' : '' }}">
        <i class="fas fa-home icon"></i>
      </a>
      <a href="{{ route('upload') }}" class="{{ Request::is('upload') ? 'active' : '' }}">
        <i class="far fa-plus-square icon"></i>
      </a>
      <a href="{{ route('search') }}" class="{{ Request::is('search') ? 'active' : '' }}">
        <i class="fas fa-search icon"></i>
      </a>
      <a href="/chat" class="{{ Request::is('chat') ? 'active' : '' }}">
        <i class="fas fa-comments icon"></i>
      </a>
      <a
        href="{{ route('profile', ['username' => Auth::user()->username]) }}"
        class="{{ Request::is('user/*') ? 'active' : '' }}">
        <i class="fas fa-user-circle icon"></i>
      </a>
    </div>
  </nav>
@endguest
