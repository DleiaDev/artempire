<template>
  <div id="upload">

    <div class="card">

      <nav>
        <div class="step">
          <i class="fas fa-image icon"></i>
          <div class="text">
            <h3><span>Step</span> 1</h3>
            <p>Choose an image</p>
          </div>
        </div>
        <div class="step inactive">
          <i class="fas fa-question-circle icon"></i>
          <div class="text">
            <h3><span>Step</span> 2</h3>
            <p>Title, description and tags</p>
          </div>
        </div>
        <div class="step inactive">
          <i class="fas fa-arrow-circle-up icon"></i>
          <div class="text">
            <h3><span>Step</span> 3</h3>
            <p>Review and upload</p>
          </div>
        </div>
      </nav>

      <transition name="fade" mode="out-in">
        <component
          :is="component"
          :image="image"
          :info="info"
          :direction="direction"
          @imageSelected="goToStep2"
          @infoEntered="goToStep3"
          @upload="upload">
        </component>
      </transition>

    </div>

  </div>
</template>

<script>
import Step1 from './upload/Step1.vue'
import Step2 from './upload/Step2.vue'
import Step3 from './upload/Step3.vue'

export default {
  components: {Step1, Step2, Step3},
  data: () => {
    return {
      image: null,
      info: null,
      direction: null,
      component: 'Step1'
    }
  },
  methods: {
    goToStep2(image, direction) {
      this.image = image
      this.direction = direction
      $('#upload .step:nth-child(1)').addClass('inactive')
      $('#upload .step:nth-child(1) .icon').attr('class', 'fas fa-check icon check')
      $('#upload .step:nth-child(2)').removeClass('inactive')
      this.component = 'Step2'
    },
    goToStep3(info) {
      this.info = info
      $('#upload .step:nth-child(2)').addClass('inactive')
      $('#upload .step:nth-child(2) .icon').attr('class', 'fas fa-check icon check')
      $('#upload .step:nth-child(3)').removeClass('inactive')
      this.component = 'Step3'
    },
    upload() {
      window.loader.fire()
      var formData = new FormData()
      formData.append('image', this.image)
      formData.append('title', this.info.title)
      formData.append('description', this.info.description)
      formData.append('tags', this.info.tags)
      axios.post('/api/artwork', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then(response => {
        toast.fire({title: 'Your artwork has been posted.', icon: 'success'})
        this.goToStep1()
      })
      .catch(error => {
        toast.fire({title: 'An error occurred.', icon: 'error'})
        this.goToStep1()
      })
    },
    goToStep1() {
      this.image = null
      this.direction = null
      this.info = null
      $('#upload .step:nth-child(1)').removeClass('inactive')
      $('#upload .step:nth-child(3)').addClass('inactive')
      $('#upload .step:nth-child(1) .icon.check').attr('class', 'fas fa-image icon')
      $('#upload .step:nth-child(2) .icon.check').attr('class', 'fas fa-question-circle icon')
      this.component = 'Step1'
    }
  }
}
</script>
