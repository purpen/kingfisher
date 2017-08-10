<template>
  <div v-if="isHeader">
    <div class="footer clear min-height350" v-if="platform === 1">

    </div>
    <div v-else>
    
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
    // 平台来源
    platform () {
      var n = this.$store.state.event.platform
      return n
    },
    // 是否显示头部
    isHeader () {
      var n = this.$store.state.event.indexConf.isHeader
      return n
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
