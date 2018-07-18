<template>
  <div v-if="!hideHeader">
    <div class="footer clear min-height350">

    </div>

  </div>
</template>

<script>
export default {
  name: 'Fiufooter',
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
    // 平台来源
    platform () {
      var n = this.$store.state.event.platform
      return n
    },
    // 是否隐藏头部
    hideHeader () {
      return this.$store.state.event.indexConf.hideHeader
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
