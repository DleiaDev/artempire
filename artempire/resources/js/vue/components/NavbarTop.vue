<template>
  <nav id="navbar-top">

    <div class="dropdown mobile">
      <!-- Mobile menu icon -->
      <div id="menu-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bars icon"></i>
      </div>

      <div class="dropdown-menu" aria-labelledby="menu-icon">
        <router-link to="/account" class="dropdown-item">
          <i class="fas fa-cog icon"></i>Settings
        </router-link>
        <a
        class="dropdown-item"
        href="#"
        onclick="event.preventDefault(); loader.fire(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt icon"></i>Logout
        </a>
      </div>

    </div>

    <!-- Logo -->
    <router-link to="/home" class="logo">
      Art<span class="empire">Empire</span>
    </router-link>

    <!-- Main links -->
    <div class="links icons">
      <router-link to="/home">
        <i class="fas fa-home"></i>
      </router-link>
      <router-link to="/upload">
        <i class="fas fa-plus-square"></i>
      </router-link>
      <router-link to="/search">
        <i class="fas fa-search"></i>
      </router-link>
      <router-link to="/chat">
        <i class="fas fa-comments"></i>
      </router-link>
      <div class="dropdown">
        <a
        href="#"
        class="dropdown-toggle"
        id="profileDropdownButton"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
          <i class="fas fa-user-circle"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdownButton">
          <a
          class="dropdown-item"
          :href="`/user/${$user.username}`">
            <i class="fas fa-user icon"></i>My Profile
          </a>
          <router-link
          class="dropdown-item"
          to="/account">
            <i class="fas fa-cog icon"></i>Settings
          </router-link>
          <a
          class="dropdown-item"
          href="#"
          onclick="event.preventDefault(); loader.fire(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt icon"></i>Logout
          </a>
        </div>
      </div>

    </div>

    <form id="logout-form" action="/logout" method="POST" style="display: none;">
      <input type="hidden" name="_token" :value="csrf">
    </form>

  </nav>
</template>

<script>
export default {
  data() {
    return {
      csrf: $('meta[name="csrf-token"]').attr('content')
    }
  }
}
</script>
