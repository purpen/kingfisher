<template>
  <div id="header-layout" v-if="!hideHeader">
    <h1>{{msg}}</h1>
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
      }
    },
    created () {
      this.msg = this.$route.meta.title
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  #header-layout {
    height: 50px;
    background: #000;
    /*border-bottom: 1px solid #333;*/
    color: #fff;
    font-size: 17px;
  }

  #header-layout h1 {
    text-align: center;
    line-height: 50px;
  }
</style>

