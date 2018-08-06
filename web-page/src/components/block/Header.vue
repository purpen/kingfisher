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
            <Menu-item name="supplier">
                品牌
            </Menu-item>
            <Menu-item name="trader">
                渠道
            </Menu-item>
            <Menu-item name="product">
                产品库
            </Menu-item>

          </div>
          <div class="layout-vcenter layout-nav" v-if="isLogin">
            <Submenu name="">
                <template slot="title">
                    {{ eventUser.phone }}
                </template>
                    <Menu-item name="my">个人中心</Menu-item>
                    <Menu-item name="myProduct">我的产品</Menu-item>
                    <Menu-item name="myOrder">我的订单</Menu-item>
                    <!--<Menu-item name="centerSurvey">销售与趋势</Menu-item>-->
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

    <Alert type="warning" show-icon v-if="alertStat.verifyStatusApplyShow">您还没有申请实名认证 <router-link :to="{name: 'centerIdentifySubmit'}">马上申请</router-link></Alert>
    <Alert type="warning" show-icon v-if="alertStat.verifyStatusRejectShow">您申请的实名认证未通过,请重新申请 <router-link :to="{name: 'centerIdentifySubmit'}">重新提交</router-link></Alert>
    <Alert type="warning" show-icon v-if="alertStat.verifyStatusAudit">您申请的实名认证正在审核中,请耐心等待</Alert>
    <div class="clear"></div>
  </div>
</template>

<script>
import auth from '@/helper/auth'
import api from '@/api/api'
export default {
  name: 'Fiuheader',
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
      self.$http.post(api.logout, {})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          auth.logout()
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
        case 'myOrder':
          this.$router.push({name: 'centerOrder'})
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
    },
    // 提配状态判断
    alertStat () {
      let user = this.$store.state.event.user
      console.log(user)
      let alertStat = {
        verifyStatusApplyShow: false,
        verifyStatusRejectShow: false
      }
      if (user) {
        if (parseInt(user.status) === 0) {
          alertStat.verifyStatusApplyShow = true
        }
        if (parseInt(user.status) === 3) {
          alertStat.verifyStatusRejectShow = true
        }
        if (parseInt(user.status) === 1) {
          alertStat.verifyStatusAudit = true
        }
      }
      return alertStat
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

  .ivu-alert {
    margin: 0;
  }
  .ivu-alert a {
    color: #FF9E00;
  }

</style>

