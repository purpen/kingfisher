<template>
  <div id="header-layout" v-if="!hideHeader">
    <h1>{{title}}</h1>
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
    props: {},
    watch: {
      '$route' (to, from) {
      }
    },
    methods: {},
    computed: {
      isLogin () {
        return this.$store.state.event.token
      },
      eventUser () {
        let user = this.$store.state.event.user
        return user
      },
      // 是否显示头部
      hideHeader () {
        return this.$store.state.event.indexConf.hideHeader
      },
      title () {
        return this.$route.meta.title
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  #header-layout {
    height: 50px;
    background: #fff;
    border-bottom: 1px solid #E6E6E6;
    color: #030303;
    font-size: 17px;
    font-weight: 600;
  }

  #header-layout h1 {
    text-align: center;
    line-height: 50px;
  }
</style>

