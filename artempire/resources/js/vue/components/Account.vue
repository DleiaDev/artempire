<template>
  <div id="account">

    <div class="card">
      <nav>
        <a id="General-link" class="active" @click="changeComponent('General')">
          <i class="fas fa-user icon"></i>General
        </a>
        <a id="Password-link" @click="changeComponent('Password')">
          <i class="fas fa-unlock-alt icon"></i>Security
        </a>
        <a id="Social-link" @click="changeComponent('Social')">
          <i class="fab fa-twitter icon"></i>Social Media
        </a>
      </nav>

      <transition name="fade" mode="out-in">
        <component :is="component"></component>
      </transition>

    </div>

  </div>
</template>

<script>
import General from './account/General.vue';
import Password from './account/Password.vue';
import Social from './account/Social.vue';

export default {
  components: {General, Password, Social},
  data() {
    return {
      component: 'General'
    }
  },
  methods: {
    changeComponent(componentName) {
      this.component = componentName;
      $('#account nav a').removeClass('active');
      $(`#${componentName}-link`).addClass('active');
    }
  }

}
</script>

<style lang="css">
</style>
