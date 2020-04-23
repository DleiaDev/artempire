<template>
  <div id="app">

    <navbar-top></navbar-top>

    <transition name="fade" mode="out-in">
      <keep-alive>
        <router-view :key="$route.fullPath"></router-view>
      </keep-alive>
    </transition>

    <navbar-bottom></navbar-bottom>

  </div>
</template>

<script>
import NavbarTop from './components/NavbarTop.vue'
import NavbarBottom from './components/NavbarBottom.vue'

export default {
  components: {NavbarTop, NavbarBottom}
}
</script>
