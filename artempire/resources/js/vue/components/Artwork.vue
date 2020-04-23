<template>
  <div id="artwork">

    <!-- Left -->
    <div class="left" :style="`background-color: ${artwork ? 'black' : 'none'}`">
      <img class="image" v-if="artwork" :src="artwork.image">
    </div>

    <!-- Right -->
    <div class="right" v-if="artwork">

      <!-- Top buttons -->
      <div class="top buttons" v-if="artwork.user_id === $user.id">
        <button class="btn btn-primary" @click="editArtwork">
          Edit <i class="fas fa-pen icon"></i>
        </button>
        <button class="btn btn-primary" @click="deleteArtwork">
          Delete <i class="fas fa-trash-alt icon"></i>
        </button>
      </div>

      <!-- Artist -->
      <div class="artist" v-if="artwork.id">
        <a
          :href="`/user/${artwork.user.username}`"
          class="image background"
          :style="`background-image: url(${artwork.user.profile})`">
        </a>
        <div>
          <div class="username">
            <a :href="`/user/${artwork.user.username}`">{{ artwork.user.username }}</a>
            <i class="fas fa-check-circle ml-2" id="verified" v-if="artwork.user.verified"></i>
          </div>
          <div class="description">
            {{ artwork.user.description }}
          </div>
        </div>
      </div>

      <!-- Artwork info -->
      <div class="artwork-info">
        <h4 class="title">{{ artwork.title }}</h4>
        <div class="description">{{ artwork.description }}</div>
        <div class="date">{{ artwork.created_at | relative }}</div>
      </div>

      <!-- Tags -->
      <ul v-if="artwork.tags.length" class="tags">
        <li v-for="(tag, key) in artwork.tags" :key="key">
          #{{ tag }}
        </li>
      </ul>

      <!-- Like and comment buttons -->
      <div class="count">
        <div>{{ artwork.likes_count }} Likes</div>
        <div>{{ artwork.comments_count }} Comments</div>
      </div>

      <div class="buttons">
        <button :class="[liked ? 'clicked' : '', 'btn btn-primary', 'like-button']" @click="like">
          {{ liked ? 'Liked' : 'Like' }}
          <i class="fas fa-heart icon" v-if="liked"></i>
          <i class="far fa-heart icon" v-else></i>
        </button>
        <button class="btn btn-secondary" @click="displayCommentInput">
          Comment <i class="far fa-comment icon"></i>
        </button>
      </div>

      <input
        class="form-control comment-input"
        spellcheck="false"
        autocomplete="off"
        placeholder="Write a comment..."
        v-model="comment"
        @keyup.enter="postComment"
      >

      <!-- Comments -->
      <ul class="comments">
        <li class="comment" v-for="(comment,index) in comments" :key="comment.id" :id="`comment-${index}`" :data-id="comment.id">
          <a :href="`/user/${comment.user.username}`" class="left background" :style="`background-image: url(${comment.user.profile})`"></a>
          <div class="right">
            <div class="username" :class="[comment.user.id === artwork.user.id ? 'owner' : '']">
              <div>
                <a :href="`/user/${comment.user.username}`">{{ comment.user.username }}</a>
                <i class="fas fa-check-circle icon" v-if="comment.user.verified"></i>
              </div>
              <i class="fas fa-times icon" v-if="comment.user.id === $user.id" @click="deleteComment(index)"></i>
            </div>
            <div class="text">{{ comment.comment }}</div>
            <div class="read-more" v-if="comment.comment.length > 100" @click="readMore(index)">
              Read more
            </div>
            <div class="date">{{ comment.created_at | relative }}</div>
          </div>
        </li>
      </ul>

    </div>

  </div>
</template>

<script>
export default {
  created() {
    var artworkID = location.pathname.split('/').pop()
    loader.fire()
    axios.get(`/api/artworks/${artworkID}`)
      .then(response => {
        loader.close()
        this.artwork = response.data.artwork
        this.liked = response.data.liked
        this.comments = response.data.comments
      })
  },
  mounted() {
    if (screen.width > 1024)
      $('body').css('overflow', 'hidden')
  },
  data() {
    return {
      artwork: null,
      liked: null,
      comments: [],
      comment: ''
    }
  },
  methods: {
    like() {
      var likeButton = $('.like-button')
      if (likeButton.attr('class').includes('clicked')) {
        this.artwork.likes_count--
        likeButton.removeClass('clicked').html('Like <i class="far fa-heart icon"></i>')
      } else {
        this.artwork.likes_count++
        likeButton.addClass('clicked').html('Liked <i class="fas fa-heart icon"></i>')
      }
      likeButton.blur()
      axios.post(`/api/artworks/${this.artwork.id}/like`)
    },
    deleteArtwork() {
      Swal.fire({
        title: 'Delete this artwork?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (!result.value) return
        loader.fire()
        axios.delete(`/api/artworks/${this.artwork.id}`)
          .then(response => {
            location.href = `/user/${this.$user.username}`
          })
          .catch(error => {
            toast.fire({title: 'An error occurred.', icon: 'error'})
          });
      })
    },
    editArtwork() {
      Swal.fire({
        html: `
          <input value="${this.artwork.title}" id="artwork-title-input" class="swal2-input">
          <textarea id="artwork-desc-input" class="swal2-textarea" placeholder="Type your message here...">${this.artwork.description}</textarea>
          <input value="${this.artwork.tags}" id="artwork-title-tags" class="swal2-input">
        `,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Save',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        preConfirm: () => {
          var title = $('#artwork-title-input').val()
          var desc = $('#artwork-desc-input').val()
          var tags = $('#artwork-title-tags').val()
          if (!title || !desc || !tags)
            Swal.showValidationMessage('All fields are required')
          if (tags.includes(' '))
            Swal.showValidationMessage('Tags must not contain whitespace.')
          return {
            title: title,
            description: desc,
            tags: tags
          }
        }
      }).then(result => {
        if (!result.value) return
        loader.fire()
        axios.post(`/artworks/${this.artwork.id}/edit`, {
          title: result.value.title,
          description: result.value.description,
          tags: result.value.tags
        })
        .then(response => {
          loader.close()
          this.artwork.title = response.data.title
          this.artwork.description = response.data.description
          this.artwork.tags = response.data.tags
          toast.fire({title: 'Changes have been saved.', icon: 'success'})
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        })
      })
    },
    displayCommentInput() {
      $('.comment-input').toggleClass('displayed').focus()
    },
    postComment() {
      if (!this.comment) return
      this.artwork.comments_count++
      var text = this.comment
      var comment = {
        user: this.$user,
        comment: text,
        created_at: new Date()
      }
      this.comments.unshift(comment)
      this.comment = ''
      axios.post(`/api/artworks/${this.artwork.id}/comment`, {comment: text})
        .then(response => {
          this.comments.shift()
          this.comments.unshift(response.data)
          toast.fire({title: 'Comment has been posted', icon: 'success'})
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
          this.comments.shift()
          this.artwork.comments_count--
        });
    },
    readMore(index) {
      if ($(`#comment-${index} .text`).css('overflow') === 'visible') {
        $(`#comment-${index} .text`).css({'overflow': 'hidden', 'max-height': '70px'});
        $(`#comment-${index} .read-more`).html('Read more');
      } else {
        $(`#comment-${index} .text`).css({'overflow': 'visible', 'max-height': 'inherit'});
        $(`#comment-${index} .read-more`).html('Read less');
      }
    },
    deleteComment(index) {
      var id = this.comments[index].id
      Swal.fire({
        title: 'Delete this comment?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then(result => {
        if (!result.value) return
        loader.fire()
        axios.delete(`/api/artworks/${id}/comment`)
          .then(response => {
            this.comments.splice(index, 1)
            toast.fire({title: 'Comment has been deleted.', icon: 'success'})
            this.artwork.comments_count--
          })
          .catch(error => {
            toast.fire({title: 'An error occurred.', icon: 'error'})
          });
      })
    }
  },

  watch: {
    $route (to, from) {
      if (!to.path.includes('/artworks'))
        $('body').css('overflow', 'inherit')
    }
  }

}
</script>

<style lang="css">
</style>
