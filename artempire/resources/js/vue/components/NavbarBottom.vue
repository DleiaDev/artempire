<template>
  <nav id="navbar-bottom">
    <div class="links">

      <router-link to="/home">
        <i class="fas fa-home icon"></i>
      </router-link>

      <router-link to="/upload">
        <i class="far fa-plus-square icon"></i>
      </router-link>

      <router-link to="/search">
        <i class="fas fa-search icon"></i>
      </router-link>

      <router-link to="/chat">
        <i class="fas fa-comments icon"></i>
      </router-link>

      <a :href="`/user/${$user.username}`" :class="isProfile ? 'router-link-active' : ''">
        <i class="fas fa-user-circle icon"></i>
      </a>

    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      isProfile: location.href.includes('/user/')
    }
  }
}
</script>
