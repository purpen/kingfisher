<template>
  <div id="header-layout" v-if="isHeader">
    <h1>这是头部</h1>
  </div>
</template>

<script>

export default {
  name: 'header',
  data () {
    return {
      msg: ''
    }
  },
  props: {
  },
  watch: {
    '$route' (to, from) {
    }
  },
  methods: {
  },
  computed: {
    isLogin () {
      return this.$store.state.event.token
    },
    eventUser () {
      var user = this.$store.state.event.user
      return user
    },
    // 是否显示头部
    isHeader () {
      var n = this.$store.state.event.indexConf.isHeader
      return n
    }
  },
  created: function () {
  },
  destroyed () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>

