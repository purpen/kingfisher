<template>
  <div v-if="!hideHeader">
    <div class="footer clearfix">

      <router-link :to="{name: 'home'}" class="icon home">首页</router-link>

      <router-link :to="{name: ''}" class="icon list">分类</router-link>

      <router-link :to="{name: 'cart'}" class="icon cart">购物车</router-link>

      <router-link :to="{name: 'i'}" class="icon mine">我的</router-link>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'footer',
    props: {
      currentName: {
        default: ''
      }
    },
    data () {
      return {
        msg: ''
      }
    },
    computed: {
      // 是否显示头部
      hideHeader () {
        return this.$store.state.event.indexConf.hideHeader
      }
    },
    created () {
      this.$store.commit('INIT_PAGE')
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .footer {
    width: 100%;
    position: fixed;
    z-index: 99;
    display: flex;
    bottom: 0;
    left: 0;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
    background: #fff;
  }

  .footer .icon {
    flex: 1;
    display: block;
    height: 50px;
    text-indent: -999rem;
    background: #FF4500;
  }

  .footer .home {
    background: url("../../assets/images/icon/home.png") no-repeat center;
    -webkit-background-size: 64px 50.5px;
    background-size: 64px 50.5px;
  }

  .footer .list {
    background: url("../../assets/images/icon/list.png") no-repeat center;
    -webkit-background-size: 64px 50.5px;
    background-size: 64px 50.5px;
  }

  .footer .cart {
    background: url("../../assets/images/icon/cart.png") no-repeat center;
    -webkit-background-size: 64px 50.5px;
    background-size: 64px 50.5px;
  }

  .footer .mine {
    background: url("../../assets/images/icon/mine.png") no-repeat center;
    -webkit-background-size: 64px 50.5px;
    background-size: 64px 50.5px;
  }
</style>
