<template>
  <div id="step2">

    <form @submit.prevent="validate" id="step2-form">

      <!-- Title -->
      <div class="form-group">
        <label for="title" class="form-label">Title</label>
        <input
          id="title"
          v-model="title"
          name="title"
          type="text"
          class="form-control"
          autocomplete="off"
          spellcheck="false"
          placeholder="Title"
        >
      </div>

      <!-- Description -->
      <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea
          id="description"
          v-model="description"
          name="description"
          class="form-control"
          spellcheck="false"
          placeholder="How would you describe this artwork?">
        </textarea>
      </div>

      <!-- Tags -->
      <div class="form-group">
        <label for="tags" class="form-label">Tags</label>
        <input
          id="tags"
          v-model="tags"
          name="tags"
          type="text"
          class="form-control"
          autocomplete="off"
          spellcheck="false"
          placeholder="Landscape,technology,brush,..."
        >
        <p class="help">Separate tags with comma</p>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary">Save</button>

    </form>

  </div>
</template>

<script>
export default {
  data() {
    return {
      title: '',
      description: '',
      tags: '',
      isValid: true
    }
  },
  methods: {
    validate() {
      var fields = $('#step2-form').serializeArray()

      this.isValid = true
      $('.invalid-feedback').remove()
      for (var i = 0; i < fields.length; i++)
        $(`#${fields[i].name}`).removeClass('is-invalid')

      for (var i = 0; i < fields.length; i++) {
        if (!fields[i].value) {
          this.isValid = false
          $(`#${fields[i].name}`)
            .addClass('is-invalid')
            .after(`
              <div class="help-block invalid-feedback">
                The ${fields[i].name} is required.
              </div>
            `)
        }
      }

      if (!this.isValid) return

      if (this.tags.includes(' ')) {
        $('#tags')
          .addClass('is-invalid')
          .after(`
          <div class="help-block invalid-feedback">
            Tags contain whitespace.
          </div>
        `)
        this.isValid = false
        return
      }

      var info = {}
      info.title = fields[0].value
      info.description = fields[1].value
      info.tags = fields[2].value.split(',')

      this.$emit('infoEntered', info)
    }
  }
}
</script>
