<template>
  <div id="profile">

    <!-- Profile background -->
    <div class="top background" :style="`background-image: url(${background})`">
        <div class="filter">
          <!-- Background upload button -->
          <form class="btn btn-primary">
            Change Background
            <input @change="validateImage($event)" type="file">
          </form>
          <!-- Profile info -->
          <div class="info">
            <div class="image background" :style="`background-image: url(${$user.profile})`"></div>
            <h3 class="username">
              {{ $user.username }}
              <i class="fas fa-check-circle" v-if="$user.verified"></i>
            </h3>
            <div class="fullname">
              {{ $user.fullName }}
            </div>
            <div class="description">
              {{ $user.description }}
            </div>
            <div class="location" v-if="$user.city && $user.country">
              <i class="fas fa-map-marker-alt icon"></i>
              {{ $user.city }}, {{ $user.country }}
            </div>
            <div class="website">
              <a :href="`https://${$user.website}`" target="_blank">{{ $user.website }}</a>
            </div>
            <div class="social">
              <a v-if="$user.social.facebook" :href="$user.social.facebook" target="_blank">
                <i class="fab fa-facebook"></i>
              </a>
              <a v-if="$user.social.instagram" :href="$user.social.instagram" target="_blank">
                <i class="fab fa-instagram"></i>
              </a>
              <a v-if="$user.social.twitter" :href="$user.social.twitter" target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
              <a v-if="$user.social.tumblr" :href="$user.social.tumblr" target="_blank">
                <i class="fab fa-tumblr"></i>
              </a>
            </div>
            <div class="buttons">
              <a href="/account" class="btn btn-primary" id="edit-button">
                Edit Profile <i id="edit-icon" class="fas fa-pen icon"></i>
              </a>
            </div>
          </div>
        </div>
    </div>

    <!-- Tab navigation -->
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <div class="nav-item active" id="nav-artworks-tab" data-toggle="tab"
      href="#nav-artworks" role="tab" aria-controls="nav-artworks" aria-selected="true">
         Artworks <strong class="count">{{ $user.artworks_count }}</strong>
      </div>
      <div class="nav-item" id="nav-followers-tab" data-toggle="tab"
      href="#nav-followers" role="tab" aria-controls="nav-followers" aria-selected="false"
      @click="getFollowers">
        Followers <strong class="count">{{ $user.followers_count }}</strong>
      </div>
      <div class="nav-item" id="nav-followings-tab" data-toggle="tab"
      href="#nav-followings" role="tab" aria-controls="nav-followings" aria-selected="false"
      @click="getFollowings">
        Following <strong class="count">{{ $user.followings_count }}</strong>
      </div>
      <div class="nav-item" id="nav-likes-tab" data-toggle="tab"
      href="#nav-likes" role="tab" aria-controls="nav-likes" aria-selected="false"
      @click="getLikes">
        Likes <strong class="count">{{ $user.likes_count }}</strong>
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
        <div class="users" v-if="$user.followers_count">
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
        <div class="users" v-if="$user.followings_count">
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
        <div class="artworks" v-if="$user.likes_count">
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
    this.artworks = this.$toCloudinary(this.$user.artworks)
  },
  data() {
    return {
      artworks: [],
      followers: [],
      followings: [],
      likes: [],
      background: this.$user.background
    }
  },
  methods: {
    getFollowers() {
      if (!this.$user.followers_count) return
      if (this.followers.length) return
      loader.fire()
      axios.get(`/api/followers/${this.$user.id}`)
        .then(response => {
          loader.close()
          this.followers = response.data;
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        });
    },
    getFollowings() {
      if (!this.$user.followings_count) return
      if (this.followings.length) return
      loader.fire()
      axios.get(`/api/followings/${this.$user.id}`)
        .then(response => {
          loader.close()
          this.followings = response.data;
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        });
    },
    getLikes() {
      if (!this.$user.likes_count) return
      if (this.likes.length) return
      loader.fire()
      axios.get(`/api/user/${this.$user.id}/likes`)
        .then(response => {
          loader.close()
          this.likes = this.$toCloudinary(response.data)
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        })
    },
    uploadImage(image) {
      loader.fire()
      var formData = new FormData()
      formData.append('background', image)
      axios.post('/account/background', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        toast.fire({title: 'Background image updated.', icon: 'success'})
        this.background = response.data.background
        this.$user.background = response.data.background
      })
      .catch(error => {
        toast.fire({title: 'An error occurred.', icon: 'error'})
      })
    },
    validateImage(e) {
      var file = e.target.files[0]
      if (!(/\.(png|jpeg|jpg|svg)$/i).test(file.name))
        return toast.fire({title: 'Invalid image extension.', icon: 'error'})
      if (Math.round(file.size / (1024*1024)) > 2)
        return toast.fire({title: 'Image has to be less the 2MB', icon: 'error'})
      var fileReader = new FileReader()
      fileReader.onload = () => {
        var image = new Image()
        image.onload = () => {
          if (image.width >= 1000 && image.height >= 500) {
            this.uploadImage(file)
          } else {
            toast.fire({title: 'Image has to be atleast 1000x500', icon: 'error'})
          }
        }
        image.src = fileReader.result
      }
      fileReader.readAsDataURL(file)
      $('#file').val('')
    }
  }
}
</script>
