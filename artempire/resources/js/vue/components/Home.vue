<template>
  <div id="home">

    <!-- Tabs -->
    <nav v-if="$user">
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-item active"
          id="nav-latest-tab"
          data-toggle="tab"
          href="#nav-latest"
          role="tab"
          aria-controls="nav-latest"
          aria-selected="true">
            Latest
        </a>
        <a
          @click="getArtworks('following')"
          class="nav-item"
          id="nav-following-tab"
          data-toggle="tab"
          href="#nav-following"
          role="tab"
          aria-controls="nav-following"
          aria-selected="false">
            Following
        </a>
      </div>
    </nav>

    <!-- Tab content -->
    <div class="tab-content" id="nav-tabContent">

      <!-- Latest tab content -->
      <div class="tab-pane fade show active" id="nav-latest" role="tabpanel" aria-labelledby="nav-latest-tab">
        <div class="artworks">
          <router-link
            v-for="(artwork, key) in latest"
            class="artwork"
            :to="`/artworks/${artwork.id}`"
            :key="key">
              <div class="image background" :style="`background-image: url(${artwork.image})`"></div>
          </router-link>
        </div>
      </div>

      <!-- Following tab content -->
      <div class="tab-pane fade" id="nav-following" role="tabpanel" aria-labelledby="nav-following-tab">
        <div class="artworks">
          <router-link
            v-for="(artwork, key) in following"
            class="artwork"
            :to="`/artworks/${artwork.id}`"
            :key="key">
              <div class="image background" :style="`background-image: url(${artwork.image})`"></div>
          </router-link>
        </div>
      </div>

    </div>

    <!-- <transition name="fade" mode="out-in">
      <keep-alive>
        <router-view :key="$route.fullPath"></router-view>
      </keep-alive>
    </transition> -->

  </div>
</template>

<script>
import Artwork from './Artwork.vue';
export default {
  components: {Artwork},
  created() { this.getArtworks('latest') },
  data() {
    return {
      latest: [],
      following: []
    }
  },
  methods: {
    getArtworks(tab) {
      if (this[tab].length) return
      loader.fire()
      axios.get(`/api/home/${tab}`)
        .then(response => {
          loader.close()
          if (response.data.length)
            this[tab] = this.$toCloudinary(response.data)
          else
            toast.fire({title: 'You aren\'t following anyone yet.', icon: 'error'})
        })
    }
  }
}
</script>
