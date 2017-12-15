<template>
  <div class="goods" ref="goods">
    <div class="goodHeader" v-if="!scrollTop">
      <router-link :to="{name:'home', params: {current_page: Cpage}}" class="backIcon">
      </router-link>
      <router-link :to="{name:'cart'}" class="cartIcon">
      </router-link>
    </div>
    <div class="goodHeader goodHeader2" v-if="scrollTop">
      <router-link :to="{name:'home', params: {current_page: Cpage}}" class="backIcon">
      </router-link>
      <ul class="header-tabs clearfix">
        <li><p :class="[{active: li_active === 'goods' }]">商品</p></li>
      </ul>
      <router-link :to="{name:'cart'}" class="cartIcon">
      </router-link>
    </div>
    <div class="good-cover">
      <div class="goods-content clearfix" ref="goodsContent">
        <div class="banner">
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
          <div class="sku-group" @click="hideAddrCover">
            <span class="fl">送至:</span>{{addrchoose}}<i class="fa fa-angle-right" aria-hidden="true"></i>
            <p v-if="addrEmpty">请添加收货地址</p>
            <p class="fl addr">
              {{defaultaddr.province}}
              {{defaultaddr.city}}
              {{defaultaddr.county}}
              {{defaultaddr.town}}
              {{defaultaddr.address}}
            </p>
          </div>
          <div class="addr-cover" ref="addrCover" @click="hideAddrCover"></div>
          <div class="addr-content" ref="addrContent">
            <RadioGroup class="info2 clearfix" v-model="checkAddr">
              <Radio v-for="(ele, index) in addrList" :key="ele.id" :label="ele.id" class="addr-item">
                <p class="clearfix">
                  <span class="name fl">{{ele.name}}</span>
                  <span class="mob fr">{{ele.phone}}</span>
                </p>
                <p class="addr2">
                  <span v-if="ele.province">{{ele.province}}</span>
                  <span v-if="ele.city">{{ele.city}}</span><br/>
                  <span v-if="ele.county">{{ele.county}}</span>
                  <span v-if="ele.town">{{ele.town}}</span>
                  <span v-if="ele.address">{{ele.address}}</span>
                </p>
              </Radio>
            </RadioGroup>
            <router-link :to="{name:'addAddr'}" class="addBtn">添加地址</router-link>
          </div>
        </div>

        <div class="evaluate">
          <p class="evaluate-title">商品评价</p>
        </div>
        <div class="details">
          <p class="details-title">详情</p>
        </div>
      </div>
    </div>

    <footer class="clearfix">
      <p v-if="!goods.inventory" class="noSale">此商品暂时无货，看看其他商品吧</p>
      <a class="collect" v-if="goods.inventory"><i></i><span>收藏</span></a>
      <a class="service" v-if="goods.inventory" @click="serviceClick"><i></i><span>客服</span></a>
      <a class="cart" v-if="goods.inventory" @click="coverHide('cart')">添加购物车</a>
      <a class="buy" v-if="goods.inventory" @click="coverHide('buy')">立即购买</a>
      <a class="other" v-if="!goods.inventory" disabled>查看店铺其他商品</a>
    </footer>
    <div class="cover-bg cover-bg2" v-if="serviceCoverShow" @click="serviceHide"></div>
    <div class="hide-service" v-if="serviceCoverShow">
      <i class="sku-close" @click="serviceHide">x</i>
      <i class="service-logo"></i>
      <h2>客服电话</h2>
      <a class="tel" href="tel:4008-798-751">4008-798-751</a>
    </div>
    <div class="cover-bg" v-if="!hide" @click="coverHide"></div>
    <transition name="fade">
      <div class="cover-content clearfix" v-if="!hide">
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
        <div class="sku-list clearfix">
          <p class="sku-title fl">
            数量
          </p>
          <p class="sku-num fr">
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
        goodsWidth: 0,
        hide: true,
        skuchoose: '选择：规格',
        addrchoose: '',
        skuInfo: '',
        dot: -1,
        choose: {},
        value: 0,
        disable: true,
        cart: '确定',
        buy: '确定',
        normal: '', // 直接点击 or 点击购物车/立即购买
        typeNum: {},
        disable2: false,
        Cpage: 0, // 返回列表页码
        li_active: 'goods', // 默认显示商品
        addrList: [],
        defaultaddr: {},
        checkAddr: '',
        addrCoverShow: true,
        serviceCoverShow: false,
        addrEmpty: false, // 地址为空时
        scrollTop: 0
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
      },
      checkAddr () {
        this.hideAddrCover()
        this.$http.post(api.default_address, {id: this.checkAddr, token: this.isLogin}).then((res) => {
          this.getAllAddr()
        }).catch((err) => {
          console.log(err)
        })
      }
    },
    created () {
      this.$Spin.show()
      this.id = this.$route.params.id
      this.Cpage = this.$route.params.current_page
      this.getGoods()
      this.getDefaultAddr()
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    mounted () {
      window.addEventListener('scroll', () => {
        this.scrollTop = document.documentElement.scrollTop
      }, false)
      window.addEventListener('touchmove', () => {
        this.scrollTop = document.documentElement.scrollTop
      }, false)
    },
    methods: {
      getGoods () {
        let that = this
        that.$http.get(api.productShow, {params: {product_id: this.id, token: this.isLogin}}).then((res) => {
          this.$Spin.hide()
          that.goods = res.data.data
        }).catch((err) => {
          this.$Spin.hide()
          console.log(err)
        })
      },
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
          this.cart = '加入购物车'
        } else if (param === 'buy') {
          this.normal = 'buy'
          this.buy = '直接购买'
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
        that.$http.post(api.cartadd, {sku_id: that.typeNum.type, n: that.typeNum.amount, token: that.isLogin}).then((res) => {
          if (res.data.meta.status_code === 200) {
            that.coverHide()
            that.$Message.success('已成功添加购物车')
            that.cart = '添加购物车'
            that.disable2 = false
          } else {
            this.$Message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
          that.$Message.error('添加失败')
          that.cart = '添加购物车'
          that.disable2 = false
        })
      },
      buyNow () {
        this.$router.push({name: 'order', params: {typeNum: this.typeNum}})
      },
      cartConfirm () {
        if (this.confirmType()) {
          this.disable2 = true
          this.cart = '正在添加购物车'
          this.addCart()
        }
      },
      buyConfirm () {
        if (this.confirmType()) {
          this.buy = '正在生成订单'
          this.typeNum.short_title = this.goods.name
          this.typeNum.n = this.typeNum.amount
          for (let i of this.goods.skus) {
            if (i.sku_id === this.typeNum.type) {
              this.typeNum.sku_name = i.mode
              this.typeNum.cover_url = i.image
              this.typeNum.price = i.market_price
            }
          }
          this.typeNum.total = this.typeNum.price * this.typeNum.n
          alert('正在生成订单')
          this.buyNow()
        }
      },
      activeClick (e) {
        this.li_active = e
        switch (e) {
          case 'goods':
            this.$refs.goodsContent.style.transform = 'translateX(0)'
            break
          case 'details':
            this.$refs.goodsContent.style.transform = 'translateX(' + -this.goodsWidth + 'px)'
            break
          case 'evaluate':
            this.$refs.goodsContent.style.transform = 'translateX(' + -this.goodsWidth * 2 + 'px)'
            break
          default :
            console.error('err')
        }
      },
      getDefaultAddr () {
        this.$http.get(api.delivery_address, {params: {token: this.isLogin}}).then((res) => {
          if (res.data.meta.status_code === 200) {
            if (res.data.data.length) {
              this.addrList = res.data.data
              for (let i of res.data.data) {
                if (i.is_default === '1') {
                  this.defaultaddr = i
                  this.checkAddr = i.id
                }
              }
            } else {
              this.addrEmpty = true
              this.addrCoverShow = false
            }
          } else {
            this.$Message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
        })
      },
      getAllAddr () {
        this.$http.get(api.delivery_address, {params: {token: this.isLogin}}).then((res) => {
          if (res.data.meta.status_code === 200) {
            this.addrList = res.data.data
            for (let i of this.addrList) {
              if (i.is_default === '1') {
                this.defaultaddr = i
              }
            }
          } else {
            this.$Message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
        })
      },
      hideAddrCover () {
        this.addrCoverShow = !this.addrCoverShow
        if (this.addrCoverShow) {
          this.$refs.addrCover.style.transform = 'translateY(0)'
          this.$refs.addrContent.style.transform = 'translateY(0)'
        } else {
          this.$refs.addrCover.style.transform = 'translateY(100%)'
          this.$refs.addrContent.style.transform = 'translateY(100%)'
        }
      },
      serviceClick () {
        this.serviceCoverShow = !this.serviceCoverShow
      },
      serviceHide () {
        this.serviceCoverShow = false
      }
    }
  }
</script>
<style scoped>
  .addr-item {
    width: 100%;
    padding-left: 36px;
    border-bottom: 0.5px solid #cccccce6;
    padding-top: 10px;
  }

  .info2 {
    border-top: 0.5px solid #cccccce6;
    font-size: 15px;
    color: #222222;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    background: #fff;
    overflow-y: scroll;
  }

  .info2 .addr-item:last-child {
    border-bottom: none;
  }

  .info2 p {
    padding-bottom: 6px;
  }

  span.name, span.mob {
    color: #222;
    font-size: 15px;
  }

  p.addr2 {
    width: 100%;
    font-size: 15px;
    color: #666;
    line-height: 1.2;
  }

  p.addr span {
    font-size: 12px;
    margin-right: 6px;
  }

  .addr-cover {
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 99;
    width: 100%;
    height: 100vh;
    background: #00000080;
    transition: 0.5s all ease;
    transform: translateY(100%);
  }

  .addr-content {
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 100;
    width: 100%;
    height: 50%;
    background: #fff;
    padding-bottom: 50px;
    transition: 0.5s all ease;
    transform: translateY(100%);
  }

  .addBtn {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 44px;
    line-height: 44px;
    background: #BE8914;
    color: #fff;
    font-size: 14px;
    text-align: center;
  }

  p.addr {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #666;
    width: 80%;
  }

  .goods {
    /*padding-top: 44px;*/
    min-height: calc(100vh - 75px);
    background: #fafafa;
    position: relative;
  }

  .goodHeader {
    position: fixed;
    z-index: 99;
    width: 100%;
    top: 0;
    left: 0;
    height: 44px;
    line-height: 44px;
  }

  .goodHeader2 {
    background: #fffc;
  }

  .goodHeader2 .backIcon {
    top: 6px;
    box-shadow: none;
    background: none;
  }

  .goodHeader2 .backIcon::after {
    border-left: 2px solid #666;
    border-top: 2px solid #666;
  }

  .backIcon {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 30px;
    height: 30px;
    background: #0006;
    border-radius: 50%;
    box-shadow: 0 0 2px 1px #fff9;
  }

  .backIcon::after {
    content: "";
    display: block;
    position: absolute;
    top: 8px;
    left: 10px;
    width: 14px;
    height: 14px;
    border-left: 2px solid #fff;
    border-top: 2px solid #fff;
    transform: rotate(-45deg);
  }

  .goodHeader2 .cartIcon {
    width: 20px;
    height: 20px;
    background: url("../../../../assets/images/icon/Cart@2x.png") no-repeat;
    -webkit-background-size: contain;
    background-size: contain;
  }

  .goodHeader2 .cartIcon:hover, .goodHeader2 .cartIcon:active, .goodHeader2 .cartIcon:visited {
    background: url("../../../../assets/images/icon/CartClick@2x.png") no-repeat;
    -webkit-background-size: contain;
    background-size: contain;
  }

  .cartIcon {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    background: url("../../../../assets/images/icon/carticon.png") no-repeat;
    /*Cart@2x.png*/
    -webkit-background-size: contain;
    background-size: contain;
  }

  .cartIcon:active, .cartIcon:visited {
    background: url("../../../../assets/images/icon/carticon.png") no-repeat;
    -webkit-background-size: contain;
    background-size: contain;
  }

  .header-tabs {
    margin: 0 80px;
    display: flex;
  }

  .header-tabs li {
    flex: 1;
    text-align: center;
  }

  .header-tabs li p.active {
    /*border-bottom: 2px solid #BE8914;*/
    /*font-weight: 600;*/
  }

  .header-tabs li p {
    font-size: 16px;
    color: #666;
    width: 32px;
    height: 44px;
    margin: 0 auto;
  }

  .goods-header {
    background: #fff;
    padding: 0 10px;
    font-size: 16px;
    margin-bottom: 10px;
  }

  .good-cover {
    width: 100%;
    overflow: hidden;
  }

  .goods-content {
    transition: 0.3s all ease;
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .banner, .details, .evaluate {
    min-height: 100%;
    overflow: hidden;
  }

  .evaluate {
    /*height: 1000vh;*/
  }

  .evaluate .evaluate-title, .details .details-title {
    font-size: 15px;
    letter-spacing: 2px;
    text-align: center;
    line-height: 46px;
    height: 46px;
    color: #999;
    position: relative;
  }

  .evaluate .evaluate-title::before, .details .details-title::before {
    content: "";
    position: absolute;
    left: 15px;
    top: 22.5px;
    width: 34%;
    height: 1px;
    background: #9994;
  }

  .evaluate .evaluate-title::after, .details .details-title::after {
    content: "";
    position: absolute;
    right: 15px;
    top: 22.5px;
    width: 34%;
    height: 1px;
    background: #9994;
  }

  .details {
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
    color: #BE8914
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
    position: relative;
    background: #fff;
    /*margin-bottom: 10px;*/
    padding: 0 10px;
    border-bottom: 0.5px solid #cccccc7d;
    height: 40px;
    line-height: 40px;
    font-size: 14px;
  }

  .sku-group i {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 20px;
  }

  .sku-group span {
    margin-right: 8px;
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
    border-right: 0.5px solid #fafafa;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  footer .noSale {
    position: relative;
    z-index: 9999;
    height: 35px;
    width: 100%;
    font-size: 12px;
    line-height: 35px;
    text-align: center;
    background: #FFF7CC;
    color: #f60;
  }

  footer a i {
    width: 20px;
    height: 20px;
    margin-right: 4px;
  }

  footer a.collect:hover, footer a.service:hover {
    color: #BE8914;
  }

  footer a.service i {
    background: url('../../../../assets/images/icon/Telephone@2x.png');
    background-size: contain;
  }

  footer a.service:hover i {
    background: url('../../../../assets/images/icon/TelephoneClick@2x.png');
    background-size: contain;
  }

  footer a.collect:hover i {
    background: url('../../../../assets/images/icon/CollectionClick@2x.png');
    background-size: contain;
  }

  footer a.collect i {
    background: url('../../../../assets/images/icon/Collection@2x.png');
    background-size: contain;
  }

  footer a.buy {
    border-right: none;
    width: 30%;
    font-size: 14px;
    background: #BE8914;
    color: #fff
  }

  footer a.cart {
    border-right: none;
    width: 30%;
    font-size: 14px;
    background: #222;
    color: #fff
  }

  footer a.other {
    border-right: none;
    width: 100%;
    font-size: 14px;
    background: #F3EEE1;
    color: #BE8914;
  }

  .cover-bg {
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 100vh;
    background: #00000080;
  }

  .cover-bg2 {
    z-index: 100;
  }

  .hide-service {
    width: 252px;
    height: 222px;
    background: #ffffff;
    position: fixed;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 100;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: auto;
    font-size: 17px;
    border-radius: 6px;
  }

  .hide-service h2 {
    font-weight: 600;
    color: #222;
    margin: 18px 0 12px;
  }

  .hide-service .tel {
    color: #BE8914;
  }

  i.service-logo {
    width: 90px;
    height: 90px;
    background: url("../../../../assets/images/icon/service@2x.png") no-repeat center;
    background-size: contain;
  }

  .cover-content {
    z-index: 2;
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 50%;
    padding-bottom: 50px;
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
    /*border-top: 1px solid #0000001a;*/
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
    font-size: 12px;
    float: left;
    border: 1px solid #f5f5f5;
    background-color: #f5f5f5;
    padding: 6px 12px;
    /*border-radius: 8px;*/
    margin: 0 8px 8px 0;
    color: #555;
  }

  .sku-color span.active {
    border-color: #BE8914;
    color: #BE8914;
  }

  .sku-num {
    padding-top: 7px;
    line-height: 20px;
    text-align: center;
    font-size: 16px;
    color: #666666;
  }

  .sku-num button {
    color: #666666;
    font-size: 15px;
    line-height: 1;
    background: #fff;
    float: left;
    width: 20px;
    height: 20px;
    border: 0.5px solid #c8c8c8;
  }

  .sku-num input {
    font-size: 14px;
    width: 45px;
    height: 20px;
    background: none;
    border: 0.5px solid #c8c8c8;
    border-right: none;
    border-left: none;
    text-align: center;
  }

  .submit, .chooseSubmit {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    font-size: 14px;
  }

  .submit .confirm {
    background-color: #BE8914;
    border: 1px solid #BE8914;
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
    background-color: #BE8914;
    border: 1px solid #BE8914;
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
