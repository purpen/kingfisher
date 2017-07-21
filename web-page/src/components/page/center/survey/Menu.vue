<template>
  <div>
      <Menu mode="horizontal" theme="dark" :active-name="currentName" @on-select="goRedirect">
          <Menu-item name="home">
              销售额
          </Menu-item>
          <Menu-item name="source">
              销售渠道
          </Menu-item>
          <Menu-item name="4">
              销售客单价
          </Menu-item>
          <Menu-item name="2">
              地域分布
          </Menu-item>
          <Menu-item name="4">
              Top20标签
          </Menu-item>
      </Menu>
  </div>
    
</template>

<script>
export default {
  name: 'center_survey_menu',
  props: {
    currentName: {
      default: ''
    }
  },
  data () {
    return {
      msg: '统计Menu'
    }
  },
  methods: {
    goRedirect (name) {
      switch (name) {
        case 'home':
          this.$router.push({name: 'centerSurveyHome'})
          break
        case 'source':
          this.$router.push({name: 'centerSurveySource'})
          break
        case 'trader':
          this.$router.push({name: 'trader'})
          break
        case 'product':
          this.$router.push({name: 'product'})
          break
        case 'login':
          this.$router.push({name: 'login'})
          break
        case 'register':
          this.$router.push({name: 'register'})
          break
        default:
          this.$router.push({name: 'centerSurveyHome'})
      }
    }
  },
  created: function () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
