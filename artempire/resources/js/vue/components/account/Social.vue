<template>
  <div class="right" id="social">

    <p>
      Copy and paste URL from your profile page from Facebook, Instagram, Twitter or Tumblr
      in the appropirate field and your account will be linked.
    </p>

    <form @submit.prevent="save">

      <!-- Facebook -->
      <div class="form-group">
        <label for="facebook" class="form-label"><i class="fab fa-facebook icon"></i>Facebook</label>
        <input id="facebook" v-model="form.facebook" type="text" class="form-control"
        autocomplete="off" spellcheck="false" placeholder="Facebook" name="facebook"
        :class="{ 'is-invalid' : form.errors.has('facebook') }">
        <has-error :form="form" field="facebook"></has-error>
      </div>

      <!-- Instagram -->
      <div class="form-group">
        <label for="instagram" class="form-label"><i class="fab fa-instagram icon"></i>Instagram</label>
        <input id="instagram" v-model="form.instagram" type="text" class="form-control"
        autocomplete="off" spellcheck="false" placeholder="Instagram" name="instagram"
        :class="{ 'is-invalid' : form.errors.has('instagram') }">
        <has-error :form="form" field="instagram"></has-error>
      </div>

      <!-- Twitter -->
      <div class="form-group">
        <label for="twitter" class="form-label"><i class="fab fa-twitter icon"></i>Twitter</label>
        <input id="twitter" v-model="form.twitter" type="text" class="form-control"
        autocomplete="off" spellcheck="false" placeholder="Twitter" name="twitter"
        :class="{ 'is-invalid' : form.errors.has('twitter') }">
        <has-error :form="form" field="twitter"></has-error>
      </div>

      <!-- Tumblr -->
      <div class="form-group">
        <label for="tumblr" class="form-label"><i class="fab fa-tumblr-square icon"></i>Tumblr</label>
        <input id="tumblr" v-model="form.tumblr" type="text" class="form-control"
        autocomplete="off" spellcheck="false" placeholder="Tumblr" name="tumblr"
        :class="{ 'is-invalid' : form.errors.has('tumblr') }">
        <has-error :form="form" field="tumblr"></has-error>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary">Update</button>

    </form>

  </div>
</template>

<script>
export default {
  data() {
    return {
      form: new Form({
        facebook: this.$user.social.facebook,
        instagram: this.$user.social.instagram,
        twitter: this.$user.social.twitter,
        tumblr: this.$user.social.tumblr
      })
    }
  },

  methods: {
    save() {
      window.loader.fire()
      this.form.put('/account/social')
        .then(response => {
          toast.fire({title: 'Changes have been updated.', icon: 'success'})
        })
        .catch(error => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        });
    },
  }

}
</script>

<style lang="css">
</style>
