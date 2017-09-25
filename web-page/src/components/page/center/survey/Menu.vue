<template>
  <div>
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>{{ currentTitle }}</Breadcrumb-item>
    </Breadcrumb>
    <div class="blank20"></div>
    <div class="menu">
        <ul>
          <li><router-link :to="{name: 'centerSurveyHome'}" :class="{active: currentName === 'home' ? true : false}">销售额</router-link></li>
          <li><router-link :to="{name: 'centerSurveySource'}" :class="{active: currentName === 'source' ? true : false}">销售渠道</router-link></li>
          <li><router-link :to="{name: 'centerSurveyCustomer'}" :class="{active: currentName === 'customer' ? true : false}">销售客单价</router-link></li>
          <li><router-link :to="{name: 'centerSurveyArea'}" :class="{active: currentName === 'area' ? true : false}">地域分布</router-link></li>
          <li><router-link :to="{name: 'centerSurveyTag'}" :class="{active: currentName === 'tag' ? true : false}">Top20标签</router-link></li>
        </ul>
        
    </div>
  </div>
    
</template>

<script>
export default {
  name: 'center_survey_menu',
  props: {
    currentName: {
      default: ''
    },
    currentTitle: {
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

  .menu {
    height: 50px;
    background-color: #DCDCDC;
    
  }
  .menu ul {
  
  }
  .menu ul li {
    float: left;
    margin: 0 15px;
    line-height: 50px;
  }
  .menu ul li a {
    font-size: 1.5rem;
    display: block;
    color: #666;
  }
  .menu ul li a:hover, .menu ul li a.active {
    color: #000;
  }


</style>
