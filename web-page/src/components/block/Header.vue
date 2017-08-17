<template>
  <div id="header-layout" v-if="!hideHeader">
    <div class="header">
      <Menu mode="horizontal" :active-name="menuactive" @on-select="goRedirect">
        <div class="container">
          <div class="layout-logo">
            <img src="../../assets/images/fiu_logo.png" />
          </div>
          <div class="layout-nav">
            <Menu-item name="home">
                首页
            </Menu-item>
            <!--
            <Menu-item name="supplier">
                供应商
            </Menu-item>
            <Menu-item name="trader">
                分销商
            </Menu-item>
            -->
            <Menu-item name="product">
                产品库
            </Menu-item>
            <!--
            <Submenu name="my">
                <template slot="title">
                    我的产品库
                </template>
                <Menu-item name="">我的产品</Menu-item>
                <Menu-item name="">销售与趋势</Menu-item>
            </Submenu>
            -->
          </div>
          <div class="layout-vcenter" v-if="isLogin">
            <Submenu name="">
                <template slot="title">
                    {{ eventUser.phone }}
                </template>
                    <Menu-item name="myProduct">个人中心</Menu-item>
                    <Menu-item name="my">我的产品</Menu-item>
                    <Menu-item name="centerSurvey">销售与趋势</Menu-item>
                    <Menu-item name="logout">登出</Menu-item>
            </Submenu>
          </div>

          <div class="layout-nav layout-auth" v-else>
            <Menu-item name="login">
                登录
            </Menu-item>
            <Menu-item name="register">
                注册
            </Menu-item>
          </div>
        </div>
      </Menu>
    </div>
    <div class="clear"></div>
  </div>
</template>

<script>
import auth from '@/helper/auth'
import api from '@/api/api'
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
    logout () {
      const self = this
      self.isLoading = true
      self.$http.post(api.logout, {})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          auth.logout()
          self.isLogin = false
          self.$Message.success('登出成功！')
          self.$router.replace('/home')
          return
        } else {
          self.$Message.error(response.data.meta.message)
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
      })
    },
    goRedirect (name) {
      switch (name) {
        case 'home':
          this.$router.push({name: 'home'})
          break
        case 'supplier':
          this.$router.push({name: 'supplier'})
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
        case 'myProduct':
          this.$router.push({name: 'centerProduct'})
          break
        case 'my':
          this.$router.push({name: 'centerBasic'})
          break
        case 'centerSurvey':
          this.$router.push({name: 'centerSurveyHome'})
          break
        case 'logout':
          this.logout()
          break
        default:
          this.$router.push({name: 'home'})
      }
    }
  },
  computed: {
    isLogin () {
      return this.$store.state.event.token
    },
    eventUser () {
      var user = this.$store.state.event.user
      return user
    },
    // 平台来源
    platform () {
      var n = this.$store.state.event.platform
      return n
    },
    // 是否隐藏头部
    hideHeader () {
      return this.$store.state.event.indexConf.hideHeader
    },
    menuactive () {
      let menu = this.$route.path.split('/')[1]
      if (menu === 'center') {
        return 'my'
      }
      return menu
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

  #header-layout, .header {
  }

  .layout-logo{
    width: 130px;
    height: 30px;
    color: #fff;
    float: left;
    position: relative;
  }
  .layout-logo img {
    width: 60px;
    position: absolute;
    top: 15px;
  }

  .layout-nav {
    margin-left: 150px;
  }

  .layout-nav .ivu-menu-item, .layout-nav .ivu-menu-submenu {
    font-size: 1.6rem;
    padding: 0 3px;
    margin: 0 22px;
    height: 60px;
    box-sizing: border-box;
  }

  .layout-nav .ivu-menu-item:hover, .layout-nav .ivu-menu-item.is-active {
  }

  .layout-vcenter {
    float: right;
  }

  .layout-auth {
    float: right;
  }
  .layout-auth .ivu-menu-item, .layout-auth .ivu-menu-submenu, .layout-vcenter .ivu-menu-submenu {
    padding: 0 3px;
    margin: 0 8px;
    height: 60px;
    box-sizing: border-box;
  }

  .layout-vcenter .ivu-menu-item-active {
    color: #495060;
    border-bottom: none;
  }

</style>

