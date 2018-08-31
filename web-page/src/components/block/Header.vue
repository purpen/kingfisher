<template>
  <div id="header-layout" v-if="!hideHeader">
    <div class="header">
      <Menu mode="horizontal" :active-name="menuactive" @on-select="goRedirect">
        <div class="container">
          <div class="layout-logo">
            <img src="../../assets/images/libraryOfGoods/logo-hei.png" />
          </div>
          <div class="layout-nav lastChild">
            <Menu-item name="home">
              <!--<a href="">首页</a>-->
              首页
            </Menu-item>
            <Menu-item name="supplier">
              <!--<a href="">品牌</a>-->
              品牌
            </Menu-item>
            <Menu-item name="trader">
              <!--<a href="">渠道</a>-->
              渠道
            </Menu-item>
            <Menu-item name="LibraryOfGoodsIndex">
              <!--<a href="">商品库</a>-->
              商品库
            </Menu-item>
          </div>
          <div class="layout-vcenter layout-nav" v-if="isLogin">
            <Submenu name="" class="submenu_right">
                <template slot="title">
                    {{ eventUser.phone }}
                </template>
                    <Menu-item name="my">个人中心</Menu-item>
                    <Menu-item name="myProduct">我的产品</Menu-item>
                    <Menu-item name="myOrder">我的订单</Menu-item>
                    <!--<Menu-item name="centerSurvey">销售与趋势</Menu-item>-->
                    <Menu-item name="logout">登出</Menu-item>
            </Submenu>
            <div class="receipt">
              <Badge :count="count" overflow-count="99" class-name="demo-badge-alone header_layout_receipt_Spansup"></Badge>
              <img src="../../assets/images/libraryOfGoods/icon-chart.png" alt="">
              <i>我的进货单</i>
            </div>
            <div class="headerReceipt_icon_font_div">
              <img src="../../assets/images/libraryOfGoods/icon-fdj.png" alt="" class="first_img" @click="inquire()">
              <img src="../../assets/images/libraryOfGoods/icon-xix.png" alt="" class="last_img" @click="inform()">
            </div>
            <div class="header_user_avatar">
              <img src="../../assets/images/libraryOfGoods/pic-weixin.png" alt="">
            </div>
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
      <!--<Alert type="warning" show-icon v-if="alertStat.verifyStatusApplyShow">您还没有申请实名认证 <router-link :to="{name: 'centerIdentifySubmit1'}">马上申请</router-link></Alert>-->
      <!--<Alert type="warning" show-icon v-if="alertStat.verifyStatusRejectShow">您申请的实名认证未通过,请重新申请 <router-link :to="{name: 'centerIdentifySubmit1'}">重新提交</router-link></Alert>-->
      <!--<Alert type="warning" show-icon v-if="alertStat.verifyStatusAudit">您申请的实名认证正在审核中,请耐心等待</Alert>-->
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
      msg: '',
      count: 18, // 购物车计数器
      headerUserImg: '' // 用户头像
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
        case 'login':
          this.$router.push({name: 'login'})
          break
        case 'register':
          this.$router.push({name: 'newregister'})
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
        case 'LibraryOfGoodsIndex':
          this.$router.push({name: 'libraryOfGoodsIndex'})
          break
        case 'logout':
          this.logout()
          break
        default:
          this.$router.push({name: 'home'})
      }
    },
    inquire () {
      // 查询
    },
    inform () {
      // 通知提醒
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
      let userStatus = parseInt(this.$store.state.event.user.distributor_status)
      let alertStat = {
        verifyStatusRejectShow: false,
        verifyStatusAudit: false,
        verifyStatusApplyShow: false
      }
      if (userStatus || userStatus === 0) {
        if (userStatus === 1) {
          alertStat.verifyStatusAudit = true       //  审核中
        }
        if (userStatus === 3 || userStatus === 4) {
          alertStat.verifyStatusRejectShow = true  // 未通过
        }
        if (userStatus !== 1 && userStatus !== 2 && userStatus !== 3 && userStatus !== 4) {
          alertStat.verifyStatusApplyShow = true  // 未申请实名认证
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

  .lastChild li:first-child a {
    border-left: 1px solid #C3C3C3;
    padding-left: 44px;
  }

  .lastChild li a{
    border-right: 1px solid #C3C3C3;
    padding-right: 44px;
  }
  .receipt{
    padding: 4px 18px;
    height: 40px;
    border-radius:10px;
    float: left;
    margin: 16px 0;
    line-height: 33px;
  }
  .receipt span{
    font-size: 14px;
    margin: 1px 4px 1px 0;
    display: inline-block;
    float: right;
  }
  .receipt img{
    float: left;
    width: 15px;
    height: 18px;
    margin: 6px 0;
    margin-right: 10px;
  }
  .receipt i{
    font-size: 14px;
    float: left;
    font-weight:400;
    color:rgba(237,58,74,1);
  }
  .submenu_right{
    float: right;
  }
  .headerReceipt_icon_font_div{
    float: left;
    width: 55px;
    height: 20px;
    margin: 25px 0 25px 20px;
    line-height: 20px;
  }
  .headerReceipt_icon_font_div img{
    height: 18px;
    width: 18px;
    margin: 1px;
  }
  .headerReceipt_icon_font_div img.first_img{
    float: left;
  }
  .headerReceipt_icon_font_div img.last_img{
    float: right;
  }
  .header_user_avatar{
    float: left;
    margin: 19px 8px 19px 20px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
  }
  .header_user_avatar img{
    width: 32px;
    height: 32px;
    float: left;
  }
</style>

