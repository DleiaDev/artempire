<template>
  <div id="search">

    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a
          class="nav-item active"
          id="nav-artists-tab"
          data-toggle="tab"
          href="#nav-artists"
          role="tab"
          aria-controls="nav-artists"
          aria-selected="true">
            Artists
        </a>
        <a
          class="nav-item"
          id="nav-artworks-tab"
          data-toggle="tab"
          href="#nav-artworks"
          role="tab"
          aria-controls="nav-artworks"
          aria-selected="false">
            Artworks
        </a>
      </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">

      <!-- Artists -->
      <div class="tab-pane fade show active" id="nav-artists" role="tabpanel" aria-labelledby="nav-artists-tab">
        <ais-instant-search :search-client="searchClient" index-name="users">
          <ais-autocomplete>
            <div class="search-container" slot-scope="{ currentRefinement, indices, refine }">
              <input
              id="query"
              class="form-control"
              type="search"
              :value="currentRefinement"
              placeholder="Search for artists"
              autocomplete="off"
              spellcheck="false"
              @input="refine($event.currentTarget.value)"
              >
              <div class="list-container">
                <div class="users" v-if="currentRefinement" v-for="index in indices" :key="index.label" :id="index.label">
                  <a
                    class="user"
                    v-for="user in index.hits" :key="user.objectID"
                    :href="`/user/${user.username}`">
                    <div class="image background" :style="`background-image: url(${user.profile})`">
                      <div class="username" :href="`/user/${user.username}`">
                        {{ user.username }}
                        <i class="fas fa-check-circle icon" v-if="user.verified"></i>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </ais-autocomplete>
        </ais-instant-search>
      </div>

      <!-- Artworks -->
      <div class="tab-pane fade show" id="nav-artworks" role="tabpanel" aria-labelledby="nav-artworks-tab">
        <ais-instant-search :search-client="searchClient" index-name="artworks">
          <ais-autocomplete>
            <div class="search-container" slot-scope="{ currentRefinement, indices, refine }">
              <input
              id="query"
              class="form-control"
              type="search"
              :value="currentRefinement"
              placeholder="Search for artworks"
              autocomplete="off"
              spellcheck="false"
              @input="refine($event.currentTarget.value)"
              >
              <div class="list-container">
                <div class="artworks" v-if="currentRefinement" v-for="index in indices" :key="index.label">
                  <router-link
                    class="artwork"
                    v-for="(artwork, key) in index.hits"
                    :to="`/artworks/${artwork.id}`"
                    :key="key">
                      <div class="image background" :style="`background-image: url(${artwork.image})`"></div>
                  </router-link>
                </div>
              </div>
            </div>
          </ais-autocomplete>
        </ais-instant-search>
      </div>

      <!-- Artwork -->
      <transition name="fade" mode="out-in">
        <keep-alive>
          <router-view :key="$route.fullPath"></router-view>
        </keep-alive>
      </transition>

    </div>

  </div>
</template>

<script>
import Artwork from './Artwork.vue';
import algoliasearch from 'algoliasearch/lite';
import 'instantsearch.css/themes/algolia-min.css';

export default {
  components: {Artwork},
  data() {
    return {
      artwork: {},
      liked: false,
      comments: [],
      scrollPosition: 0,
      searchClient: algoliasearch(
        'GH1KU9XOZC',
        'd2bd2a657292acc58bcef70097760e2f'
      ),
    };
  }
};
</script>

<style lang="css">
</style>
