<template>
  <div class="right">

    <form @submit.prevent="changePassword" id="password-form">

      <!-- Current Password -->
      <div class="form-group">
        <label for="currentPassword" class="form-label">Current password</label>
        <input id="currentPassword"v-model="form.currentPassword" type="password" class="form-control" required
        name="currentPassword" placeholder="Current password" :class="{ 'is-invalid' : form.errors.has('currentPassword') }">
        <has-error :form="form" field="currentPassword"></has-error>
      </div>

      <!-- New Password -->
      <div class="form-group">
        <label for="newPassword" class="form-label">New password</label>
        <input id="newPassword"v-model="form.newPassword" type="password" class="form-control" required
        name="newPassword" placeholder="New password" :class="{ 'is-invalid' : form.errors.has('newPassword') }">
        <has-error :form="form" field="newPassword"></has-error>
      </div>

      <!-- Repeat New Password -->
      <div class="form-group">
        <label for="newPassword_confirmation" class="form-label">Repeat new password</label>
        <input id="newPassword_confirmation"v-model="form.newPassword_confirmation" type="password" class="form-control" required
        name="newPassword_confirmation" placeholder="Repeat new password" :class="{ 'is-invalid' : form.errors.has('newPassword_confirmation') }">
        <has-error :form="form" field="newPassword_confirmation"></has-error>
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
        currentPassword: '',
        newPassword: '',
        newPassword_confirmation: ''
      })
    }
  },

  methods: {
    changePassword() {
      window.loader.fire()
      this.form.put('/account/password')
        .then(response => {
          toast.fire({title: 'Your password has been changed.', icon: 'success'})
          this.form.reset()
        })
        .catch(() => {
          toast.fire({title: 'An error occurred.', icon: 'error'})
        })
    },
  }
}
</script>

<style lang="css">
</style>
