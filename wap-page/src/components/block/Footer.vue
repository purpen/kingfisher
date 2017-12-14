<template>
  <footer>
    <div v-if="!hideHeader">
      <div class="footer clearfix">

        <router-link :to="{name: 'home'}" @click.native="rlClick('home')"
                     :class="['icon', 'home', {'active': active === 'home'}]">
          {{language.main.home}}
        </router-link>

        <router-link :to="{name: 'classify'}" @click.native="rlClick('list')"
                     :class="['icon', 'list', {'active': active === 'list'}]">
          {{language.main.classify}}
        </router-link>

        <router-link :to="{name: 'cart'}" @click.native="rlClick('cart')"
                     :class="['icon', 'cart', {'active': active === 'cart'}]">
          {{language.main.cart}}
        </router-link>

        <router-link :to="{name: 'i'}" @click.native="rlClick('mine')"
                     :class="['icon', 'mine', {'active': active === 'mine'}]">
          {{language.main.mine}}
        </router-link>
      </div>
    </div>
  </footer>
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
        msg: '',
        active: '',
        name: ''
      }
    },
    computed: {
      // 是否显示头部
      hideHeader () {
        return this.$store.state.event.indexConf.hideHeader
      },
      language () {
        return this.$store.state.event.language
      }
    },
    created () {
      this.name = this.$route.name
      this.active = localStorage.getItem('active')
      if (this.name !== this.active) {
        this.active = this.name
      }
      this.$store.commit('INIT_PAGE')
    },
    methods: {
      rlClick (e) {
        this.active = e
        localStorage.setItem('active', e)
      }
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
    text-align: center;
    line-height: 80px;
    font-size: 12px;
  }

  .footer a:hover {
    color: #9A7D56
  }

  .footer .icon.active {
    color: #9A7D56
  }

  .footer .icon.active:hover, .footer .icon.active:active {
    color: #9A7D56
  }

  .footer .home {
    background: url("../../assets/images/icon/home@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .home.active {
    background: url("../../assets/images/icon/Artboard@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .list {
    background: url("../../assets/images/icon/Classification@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .list.active {
    background: url("../../assets/images/icon/ClassificationClick@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .cart {
    background: url("../../assets/images/icon/Cart@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .cart {
    background: url("../../assets/images/icon/CartClick@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .mine {
    background: url("../../assets/images/icon/Me@2x.png") no-repeat center 8px;
    background-size: 20px;
  }

  .footer .mine {
    background: url("../../assets/images/icon/MeClick@2x.png") no-repeat center 8px;
    background-size: 20px;
  }
</style>
