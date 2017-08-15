<template>
  <div v-if="!hideHeader">
    <div class="footer clear min-height350">

    </div>
  </div>
</template>

<script>
export default {
  name: 'footer',
  props: {
    currentName: {
      default: ''
    }
  },
  data () {
    return {
      msg: ''
    }
  },
  computed: {
    // 是否显示头部
    hideHeader () {
      return this.$store.state.event.indexConf.hideHeader
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
