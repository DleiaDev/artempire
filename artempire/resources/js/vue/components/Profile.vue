<template>
  <div id="profile">

    <!-- Profile background -->
    <div class="top background" :style="`background-image: url(${$profile.background})`">
        <div class="filter">
          <!-- Profile info -->
          <div class="info">
            <div class="image background" :style="`background-image: url(${$profile.profile})`"></div>
            <h3 class="username">
              {{ $profile.username }}
              <i class="fas fa-check-circle" v-if="$profile.verified"></i>
            </h3>
            <div class="fullname">
              {{ $profile.fullName }}
            </div>
            <div class="description">
              {{ $profile.description }}
            </div>
            <div class="location" v-if="$profile.city && $profile.country">
              <i class="fas fa-map-marker-alt icon"></i>
              {{ $profile.city }}, {{ $profile.country }}
            </div>
            <div class="website">
              <a :href="`https://${$profile.website}`" target="_blank">{{ $profile.website }}</a>
            </div>
            <div class="social">
              <a v-if="$profile.social.facebook" :href="$profile.social.facebook" target="_blank">
                <i class="fab fa-facebook"></i>
              </a>
              <a v-if="$profile.social.instagram" :href="$profile.social.instagram" target="_blank">
                <i class="fab fa-instagram"></i>
              </a>
              <a v-if="$profile.social.twitter" :href="$profile.social.twitter" target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
              <a v-if="$profile.social.tumblr" :href="$profile.social.tumblr" target="_blank">
                <i class="fab fa-tumblr"></i>
              </a>
            </div>
            <div class="buttons">
              <button @click="follow" class="btn btn-primary clicked" id="follow-button" v-if="isFollowing">
                Following <i class="fas fa-check icon"></i>
              </button>
              <button @click="follow" class="btn btn-primary" id="follow-button" v-else>
                Follow <i class="fas fa-plus icon"></i>
              </button>
              <button @click="sendMessage" class="btn btn-secondary">
                Message <i class="fas fa-envelope icon"></i>
              </button>
            </div>
          </div>
        </div>
    </div>

    <!-- Profile action -->
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <div class="nav-item active" id="nav-artworks-tab" data-toggle="tab"
      href="#nav-artworks" role="tab" aria-controls="nav-artworks" aria-selected="true">
         Artworks <strong class="count">{{ $profile.artworks_count }}</strong>
      </div>
      <div class="nav-item" id="nav-followers-tab" data-toggle="tab"
      href="#nav-followers" role="tab" aria-controls="nav-followers" aria-selected="false"
      @click="getFollowers">
        Followers <strong class="count">{{ $profile.followers_count }}</strong>
      </div>
      <div class="nav-item" id="nav-followings-tab" data-toggle="tab"
      href="#nav-followings" role="tab" aria-controls="nav-followings" aria-selected="false"
      @click="getFollowings">
        Following <strong class="count">{{ $profile.followings_count }}</strong>
      </div>
      <div class="nav-item" id="nav-likes-tab" data-toggle="tab"
      href="#nav-likes" role="tab" aria-controls="nav-likes" aria-selected="false"
      @click="getLikes">
        Likes <strong class="count">{{ $profile.likes_count }}</strong>
      </div>
    </div>

    <!-- Tab content -->
    <div class="tab-content profile-tabContent" id="nav-tabContent">

      <!-- Artworks tab -->
      <div class="tab-pane fade show active" id="nav-artworks" role="tabpanel" aria-labelledby="nav-artworks-tab">
        <div class="artworks" v-if="artworks.length">
          <router-link
            v-for="(artwork, key) in artworks"
            class="artwork"
            :to="`/artworks/${artwork.id}`"
            :key="key">
              <div class="image background" :style="`background-image: url(${artwork.image})`"></div>
          </router-link>
        </div>
        <div class="hint" v-else>
          <p>No uploaded artworks yet.</p>
        </div>
      </div>

      <!-- Followers tab -->
      <div class="tab-pane fade show" id="nav-followers" role="tabpanel" aria-labelledby="nav-followers-tab">
        <div class="users" v-if="$profile.followers_count">
          <a
            class="user"
            v-for="(followerRow, key) in followers" :key="key"
            :href="`/user/${followerRow.follower.username}`">
              <div class="image background" :style="`background-image: url(${followerRow.follower.profile})`">
                <div class="username" :href="`/user/${followerRow.follower.username}`">
                  {{ followerRow.follower.username }}
                  <i class="fas fa-check-circle icon" v-if="followerRow.follower.verified"></i>
                </div>
              </div>
          </a>
        </div>
        <div class="hint" v-else>
          <p>No followers currently.</p>
        </div>
      </div>

      <!-- Followings tab -->
      <div class="tab-pane fade show" id="nav-followings" role="tabpanel" aria-labelledby="nav-followings-tab">
        <div class="users" v-if="$profile.followings_count">
          <a
            class="user"
            v-for="(followingsRow, key) in followings" :key="key"
            :href="`/user/${followingsRow.user.username}`">
              <div class="image background" :style="`background-image: url(${followingsRow.user.profile})`">
                <div class="username" :href="`/user/${followingsRow.user.username}`">
                  {{ followingsRow.user.username }}
                  <i class="fas fa-check-circle icon" v-if="followingsRow.user.verified"></i>
                </div>
              </div>
          </a>
        </div>
        <div class="hint" v-else>
          <p>You aren't following anyone yet.</p>
        </div>
      </div>

      <!-- Likes tab -->
      <div class="tab-pane fade show" id="nav-likes" role="tabpanel" aria-labelledby="nav-likes-tab">
        <div class="artworks" v-if="$profile.likes_count">
          <router-link
            v-for="(artwork, key) in likes"
            class="artwork"
            :to="`/artworks/${artwork.id}`"
            :key="key">
              <div class="image background" :style="`background-image: url(${artwork.image})`"></div>
          </router-link>
        </div>
        <div class="hint" v-else>
          <p>You haven't liked any artworks yet.</p>
        </div>
      </div>

    </div>

  </div>
</template>

<script>
import Artwork from './Artwork.vue';
export default {
  components: {Artwork},
  created() {
    this.artworks = this.$toCloudinary(this.$profile.artworks)
  },
  data() {
    return {
      artworks: [],
      followers: [],
      followings: [],
      likes: [],
      isFollowing: this.$user.is_following
    }
  },
  methods: {
    getFollowers() {
      if (!this.$profile.followers_count) return
      if (this.followers.length) return
      loader.fire()
      axios.get(`/api/followers/${this.$profile.id}`)
        .then(response => {
          loader.close()
          this.followers = response.data;
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        });
    },
    getFollowings() {
      if (!this.$profile.followings_count) return
      if (this.followings.length) return
      loader.fire()
      axios.get(`/api/followings/${this.$profile.id}`)
        .then(response => {
          loader.close()
          this.followings = response.data;
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        });
    },
    getLikes() {
      if (!this.$profile.likes_count) return
      if (this.likes.length) return
      loader.fire()
      axios.get(`/api/user/${this.$profile.id}/likes`)
        .then(response => {
          loader.close()
          this.likes = this.$toCloudinary(response.data)
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        })
    },
    follow() {
      $('#follow-button').blur()
      this.isFollowing = this.isFollowing ? false : true
      axios.post(`/api/follow/${this.$profile.id}`);
    },
    sendMessage() {
      Swal.fire({
        input: 'textarea',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Send',
        inputPlaceholder: 'Type your message here...',
        inputValidator: value => {
          if (!value) return 'You need to write something!'
        },
        showCancelButton: true
      }).then(result => {
        if (!result.value) return
        axios.post('/api/chat/send', {contact_id: this.$profile.id , message: result.value})
          .then(response => {
            toast.fire({title: 'Message has been sent.', icon: 'success'})
          })
          .catch(error => {
            toast.fire({title: 'An error occurred.', icon: 'error'})
          })
      })
    },
  }
}
</script>
