<template>
  <div>
      <Menu mode="horizontal" theme="dark" :active-name="currentName" @on-select="goRedirect">
          <Menu-item name="home">
              销售额
          </Menu-item>
          <Menu-item name="source">
              销售渠道
          </Menu-item>
          <Menu-item name="customer">
              销售客单价
          </Menu-item>
          <Menu-item name="area">
              地域分布
          </Menu-item>
          <Menu-item name="tag">
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
        case 'customer':
          this.$router.push({name: 'centerSurveyCustomer'})
          break
        case 'area':
          this.$router.push({name: 'centerSurveyArea'})
          break
        case 'tag':
          this.$router.push({name: 'centerSurveyTag'})
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
