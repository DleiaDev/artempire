<template>
  <div id="step3">

    <div class="flex flex-row" v-if="direction === 'row'">
      <div class="left">
        <img id="preview">
      </div>
      <div class="right">
        <div class="top">
          <h3 class="title">{{ info.title }}</h3>
          <p class="description">{{ info.description }}</p>
          <div class="tags">
            <span v-for="(tag, index) in info.tags" :key="index">
              #{{ tag }}
            </span>
          </div>
        </div>
        <div class="bottom">
          <button type="button" class="btn btn-primary" @click="$emit('upload')">Finish</button>
        </div>
      </div>
    </div>

    <div class="flex flex-column" v-else>
      <div class="top">
        <img id="preview">
      </div>
      <div class="middle">
        <h3 class="title">{{ info.title }}</h3>
        <p class="description">{{ info.description }}</p>
        <div class="tags">
          <span v-for="(tag, index) in info.tags" :key="index">
            #{{ tag }}
          </span>
        </div>
      </div>
      <div class="bottom">
        <button type="button" class="btn btn-primary" @click="$emit('upload')">Finish</button>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: {
    direction: String,
    image: File,
    info: Object
  },
  mounted() {
    var fileReader = new FileReader()
    fileReader.onload = () => {
      $('#preview').attr('src', fileReader.result)
    }
    fileReader.readAsDataURL(this.image)
  }
}
</script>
