<template>
  <div id="header-layout" v-if="!hideHeader">
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
    hideHeader () {
      return this.$store.state.event.indexConf.hideHeader
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

