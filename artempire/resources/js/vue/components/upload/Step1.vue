<template>
  <div id="step1">

    <!-- Dropzone -->
    <vue-dropzone
      id="dropzone"
      :options="dropOptions"
      @vdropzone-file-added="fileAdded">
    </vue-dropzone>

  </div>
</template>

<script>
import VueDropzone from 'vue2-dropzone'

export default {
  components: {VueDropzone},
  data: () => {
    return {
      artwork: null,
      dropOptions: {
        url: 'https://httpbin.org/post',
        autoQueue: false,
        init: function() {
          $('#dropzone').html(`
            <div class="dz-icon"><i class="fas fa-arrow-down icon"></i></div>
            <div class="dz-message">Drop your image here</div>
          `);
        }
      }
    }
  },
  mounted() {
    if (screen.width <= 576)
      $('.dz-message').html('Click to choose your image.')
  },
  methods: {
    fileAdded(file) {
      if (!(/\.(png|jpeg|jpg|svg)$/i).test(file.name))
        return toast.fire({title: 'Invalid image extension.', icon: 'error'})
      if (Math.round(file.size / (1024*1024)) > 2)
        return toast.fire({title: 'Image has to be less the 2MB', icon: 'error'})
      var fileReader = new FileReader()
      fileReader.onload = () => {
        var image = new Image()
        image.onload = () => {
          if ((image.width * image.height) >= 500000) {
            var direction = image.width > image.height ? 'column' : 'row'
            this.$emit('imageSelected', file, direction)
          } else {
            toast.fire({title: 'Image has to be atleast 1000x500', icon: 'error'})
          }
        }
        image.src = fileReader.result
      }
      fileReader.readAsDataURL(file)
    },
  }
}
</script>
