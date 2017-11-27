<template>
  <div class="goods">
    <div class="banner">
      <router-link class="cartIcon" :to="{name:'cart'}"></router-link>
      <img v-lazy="goods.image" :alt="goods.name" style="width: 100%; vertical-align: top;">
      <div class="goods-header">
        <p class="title">{{goods.name}}</p>
        <p class="price">￥<i>{{goods.price}}</i></p>
        <!--<p class="info clearfix">-->
        <!--<span class="express">运费：免运费</span>-->
        <!--<span class="inventory">库存：{{goods.inventory}}</span>-->
        <!--</p>-->
      </div>
      <div v-if="goods.skus && goods.skus.length" class="sku-group" @click="coverHide">
        {{skuchoose}}<i class="fa fa-angle-right" aria-hidden="true"></i>
      </div>
    </div>

    <footer class="clearfix">
      <p v-if="!goods.inventory" class="noSale">此商品暂时无货，看看其他商品吧</p>
      <!--<a class="service"><i class="fa fa-star-o" aria-hidden="true"></i><span>收藏</span></a>-->
      <!--<a class="share"><i class="fa fa-share-square-o" aria-hidden="true"></i><span>分享</span></a>-->
      <a class="cart" v-if="goods.inventory" @click="coverHide('cart')">添加购物车</a>
      <a class="buy" v-if="goods.inventory" @click="coverHide('buy')">立即购买</a>
      <a class="other" v-if="!goods.inventory" disabled>查看店铺其他商品</a>
    </footer>

    <div class="cover-bg" v-show="!hide" @click="coverHide"></div>
    <transition name="fade">
      <div class="cover-content" v-show="!hide">
        <div class="sku-header">
          <img :src="goods.image" alt="goods.name" class="skuImg" ref="skuImg">
          <p class="price">￥<i>{{goods.price}}</i></p>
          <p class="inventory">库存：{{goods.inventory}}</p>
          <p class="sku-info">{{skuInfo}}</p>
        </div>
        <div class="sku-list">
          <p class="sku-title">
            类型
          </p>
          <p class="sku-color clearfix">
            <span v-for="(e,index) in goods.skus" @click="dotIN(index)"
                  :class="{'active' : dot === index}">{{e.mode}}</span>
          </p>
        </div>
        <div class="sku-list">
          <p class="sku-title">
            数量
          </p>
          <p class="sku-num clearfix">
            <button class="fl" @click="valueMinus" :disabled="disable">-</button>
            <input type="number" v-model="value" class="fl" :disabled="disable"/>
            <button class="fl" @click="valuePlus" :disabled="disable">+</button>
          </p>
        </div>
        <i class="sku-close" @click="coverHide">x</i>
        <div class="submit" v-if="normal">
          <button class="confirm" @click="cartConfirm" v-if="normal === 'cart'" :disabled="disable2">{{cart}}</button>
          <button :to="1" class="confirm" @click="buyConfirm" v-if="normal === 'buy'" :disabled="disable2">{{buy}}
          </button>
        </div>
        <div class="chooseSubmit" v-if="!normal">
          <button class="confirm" @click="cartConfirm" :disabled="disable2">添加购物车</button>
          <button :to="1" class="confirm" @click="buyConfirm" :disabled="disable2">立即购买</button>
        </div>
      </div>
    </transition>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: '',
    data () {
      return {
        id: 0,
        goods: {},
        hide: true,
        skuchoose: '选择：规格',
        skuInfo: '请选择类型',
        dot: -1,
        choose: {},
        value: 0,
        disable: true,
        cart: '确定',
        buy: '确定',
        normal: '', // 直接点击 or 点击购物车/立即购买
        typeNum: {},
        disable2: false
      }
    },
    watch: {
      value () {
        if (this.goods.inventory) {
          if (this.value < 1) {
            this.$Message.error('不能再少了')
            this.value = 1
          } else if (this.value > this.goods.inventory) {
            this.$Message.error('不能超过库存')
            this.value = this.goods.inventory
          }
        } else {
          this.value = 0
        }
      }
    },
    created () {
      this.id = this.$route.params.id
      let that = this
      that.$http.get(api.productShow, {params: {product_id: this.id, token: this.isLogin}})
        .then((res) => {
          that.goods = res.data.data
        })
        .catch((err) => {
          console.log(err)
        })
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    methods: {
      coverHide (param) {
        this.hide = !this.hide
        if (this.hide) {
          document.body.removeAttribute('class', 'disableScroll')
          document.childNodes[1].removeAttribute('class', 'disableScroll')
        } else {
          document.body.setAttribute('class', 'disableScroll')
          document.childNodes[1].setAttribute('class', 'disableScroll')
        }
        this.normal = ''
        if (param === 'cart') {
          this.normal = 'cart'
        } else if (param === 'buy') {
          this.normal = 'buy'
        }
      },
      dotIN (i) {
        this.dot = i
        this.choose = this.goods.skus[i]
        if (this.choose.image) {
          this.$refs.skuImg.src = this.choose.image
        }
        this.goods.price = this.choose.price
        this.goods.inventory = this.choose.inventory
        this.value = 1
        this.skuchoose = '已选：' + '"' + this.choose.mode + '"'
        this.skuInfo = '已选：' + '"' + this.choose.mode + '"'
        if (this.goods.inventory) {
          this.disable = false
        } else {
          this.disable = true
          this.$Message.error('此商品暂时无货')
          this.value = 0
        }
        this.typeNum.type = this.choose.sku_id
      },
      valuePlus () {
        this.value++
      },
      valueMinus () {
        this.value--
      },
      confirmType () {
        if (!this.typeNum.type) {
          this.$Message.error('请选择商品种类！')
          return false
        }
        this.typeNum.amount = this.value
        if (!this.typeNum.amount) {
          this.$Message.error('此商品暂时无货')
          return false
        }
        if (!this.isLogin) {
          this.$Message.error('请先登录')
          this.$router.push({name: 'login'})
          return false
        }
        return true
      },
      addCart () {
        let that = this
        that.$http.post(api.cartadd, {sku_id: that.typeNum.type, n: that.typeNum.amount, token: that.isLogin})
          .then((res) => {
            console.log(res)
            if (res.status === 200) {
              that.coverHide()
              that.$Message.success('已成功添加购物车')
              that.cart = '添加购物车'
              that.disable2 = false
            }
          })
          .catch((err) => {
            console.error(err)
            that.$Message.error('添加失败')
            that.cart = '添加购物车'
            that.disable2 = false
          })
      },
      cartConfirm () {
        if (this.confirmType()) {
          this.disable2 = true
          this.cart = '正在添加购物车'
          this.addCart()
        }
      },
      buyConfirm () {
        this.coverHide()
        this.$Message.success('buy')
        this.buy = '正在生成订单'
      }
    }
  }
</script>
<style scoped>
  .goods {
    min-height: 100vh;
    background: #f2f2f2;
    position: relative;
  }

  .cartIcon {
    position: fixed;
    top: 15px;
    right: 15px;
    width: 24px;
    height: 24px;
    background: url("../../../../assets/images/icon/carticon.png") no-repeat;
    -webkit-background-size: contain;
    background-size: contain;
  }

  .goods-header {
    background: #fff;
    padding: 0 10px;
    font-size: 16px;
    margin-bottom: 10px;
  }

  .banner {
    overflow: hidden;
  }

  .title {
    color: #333;
    line-height: 2;
    text-align: left;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  .price {
    height: 30px;
    line-height: 30px;
    color: #C3A769
  }

  .price i {
    font-size: 18px;
  }

  .info {
    display: flex;
    font-size: 12px;
    line-height: 20px;
    color: #999;
    padding-bottom: 10px;
  }

  .info span {
    flex: 1;
    text-align: center;
  }

  .info span:last-child {
    text-align: right;
  }

  .info span:first-child {
    text-align: left;
  }

  .sku-group {
    background: #fff;
    /*margin: 10px 0;*/
    padding: 0 10px;
    height: 40px;
    line-height: 40px;
    font-size: 14px;
  }

  .sku-group i {
    float: right;
    line-height: 40px;
    font-size: 20px;
  }

  footer {
    background: #fff;
    position: fixed;
    z-index: 2;
    bottom: 0;
    left: 0;
    width: 100%;
  }

  footer a {
    float: left;
    position: relative;
    width: 20%;
    height: 40px;
    font-size: 12px;
    border-right: 0.5px solid #f2f2f2;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
  }

  footer .noSale {
    height: 35px;
    width: 100%;
    font-size: 12px;
    line-height: 35px;
    text-align: center;
    background: #FFF7CC;
    color: #f60;
  }

  footer a i {
    font-size: 20px;
  }

  footer a.service {
    color: #C3A769;
  }

  footer a.buy {
    border-right: none;
    width: 30%;
    width: 50%;
    font-size: 14px;
    background: #FF0036;
    color: #fff
  }

  footer a.cart {
    border-right: none;
    width: 30%;
    width: 50%;
    font-size: 14px;
    background: #FF9500;
    color: #fff
  }

  footer a.other {
    border-right: none;
    width: 100%;
    font-size: 14px;
    background: #F3EEE1;
    color: #C3A769;
  }

  .cover-bg {
    position: absolute;
    z-index: 1;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 100vh;
    background: #00000080;
  }

  .cover-content {
    z-index: 2;
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 50%;
    background: #fff;
  }

  .sku-header {
    padding: 10px 0 10px 126px;
    position: relative;
    border-bottom: 1px solid #0000001a;
  }

  .sku-header p {
    height: 20px;
    font-size: 13px;
    line-height: 20px;
  }

  .sku-header .skuImg {
    width: 100px;
    height: 100px;
    position: absolute;
    top: -28px;
    left: 10px;
    border-radius: 4px;
    overflow: hidden;
    border: 1px solid #0000001a;
    padding: 1px;
    background-color: #fff;
  }

  .sku-close {
    position: absolute;
    top: 10px;
    right: 10px;
    border-radius: 50%;
    border: 0.5px solid #5f646e;
    color: #5f646e;
    font-weight: 100;
    width: 25px;
    height: 25px;
    font-size: 25px;
    line-height: 20px;
    text-align: center;
  }

  .sku-list {
    border-top: 1px solid #0000001a;
    padding: 10px;
    padding-top: 0;
    font-size: 13px;
    margin-top: -1px;
  }

  .sku-title {
    color: #666;
    font-weight: 400;
    padding-bottom: 10px;
    padding-top: 10px;
  }

  .sku-color span {
    float: left;
    border: 1px solid #f5f5f5;
    background-color: #f5f5f5;
    padding: 6px 12px;
    border-radius: 8px;
    margin: 0 8px 8px 0;
    color: #555;
  }

  .sku-color span.active {
    border-color: #FF0036;
    background-color: #FF0036;
    color: #fff;
  }

  .sku-num {
    line-height: 30px;
    text-align: center;
    font-size: 16px;
  }

  .sku-num button {
    border: none;
    background: #f2f2f2;
    float: left;
    width: 30px;
    height: 30px;
    border: 1px solid #ccc;
  }

  .sku-num input {
    width: 90px;
    height: 30px;
    background: none;
    border: 0.5px solid #f2f2f2;
    border-right: none;
    border-left: none;
    text-align: center;
  }

  .submit, .chooseSubmit {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    font-size: 14px;
  }

  .submit .confirm {
    background-color: #FF0036;
    border: 1px solid #FF0036;
    color: #fff;
    width: 100%;
    height: 40px;
  }

  .chooseSubmit {
    display: flex;
  }

  .chooseSubmit .confirm {
    color: #fff;
    flex: 1;
    height: 40px;
  }

  .chooseSubmit .confirm:first-child {
    background-color: #FF9500;
    border: 1px solid #FF9500;
  }

  .chooseSubmit .confirm:last-child {
    background-color: #FF0036;
    border: 1px solid #FF0036;
  }

  /*过渡动画*/
  .fade-enter-active {
    transition: .3s cubic-bezier(0, 0, .25, 1) 80ms
  }

  .fade-leave-active {
    transition: .3s cubic-bezier(0, 0, .25, 1) 80ms
  }

  .fade-enter {
    opacity: 0;
  }

  .fade-enter, .fade-leave-to {
    transform: translateY(50%);
    opacity: 0;
  }

  @media screen and (min-width: 767px) {
    .goods {
      margin-bottom: 0;
      padding-bottom: 40px;
    }
  }
</style>
