<template>
  <div class="order fullscreen">
    <h2>
      <i class="backIcon" onclick="window.history.go(-1)">
      </i>
      {{title}}
    </h2>
    <div class="info">
      <span style="padding-top: 6px; color: #999;font-size: 12px;" v-html="addrMessage"></span>
      <p>
        <span class="name">{{defaultaddr.name}}</span>
        <span class="mob">{{defaultaddr.phone}}</span>
      </p>
      <p class="addr">
        <span v-if="defaultaddr.province">{{defaultaddr.province}}</span>
        <span v-if="defaultaddr.city">{{defaultaddr.city}}</span>
        <span v-if="defaultaddr.county">{{defaultaddr.county}}</span>
        <span v-if="defaultaddr.town">{{defaultaddr.town}}</span>
        <span v-if="defaultaddr.address">{{defaultaddr.address}}</span>
      </p>
      <button class="addrBtn" @click="hideAddrCover">{{changeAddr}}</button>
    </div>

    <!--收货地址列表-->
    <div class="addr-cover" ref="addrCover" @click="hideAddrCover"></div>
    <div class="addr-content" ref="addrContent">
      <RadioGroup class="info2 clearfix" v-model="checkAddr">
        <Radio v-for="(ele, index) in AlladdrList" :key="ele.id" :label="ele.id" class="addr-item">
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
      <router-link v-if="isCart" :to="{name:'addAddr', params:{cartid:cartid}}" class="addBtn">添加地址</router-link>
      <router-link v-else :to="{name:'addAddr', params:{typeNum:typeNum}}" class="addBtn">添加地址</router-link>
    </div>

    <div v-for="(ele, index) in goodList" :key="index" class="item-detail item clearfix">
      <div class="itemleft fl">
        <img v-if="ele.cover_url" :src="ele.cover_url" :alt="ele.short_title">
        <img v-else :src="require('@/assets/images/default_thn.png')" alt="">
      </div>
      <div class="itemright fl">
        <p class="itemtitle">{{ele.short_title}}</p>
        <p class="sku">
          <span>型号:{{ele.sku_name}}</span>
          <span class="amount">数量:{{ele.n}}个</span>
        </p>
        <p class="iteminfo clearfix">
          <span class="price fl">￥{{ele.price}}</span>
        </p>
      </div>
    </div>
    <div class="item-ticket">
      <p class="invoice clearfix"><span class="fl">发票</span><i class="fr">不开发票</i></p>
      <p class="coupon clearfix"><span class="fl">优惠券</span><i class="fr">无</i></p>
    </div>
    <div class="item-receive">
      <p>收货时间</p>
      <RadioGroup v-model="receiveTime" class="receive-p">
        <Radio label="任意时间"></Radio>
        <Radio label="周一至周五"></Radio>
        <Radio label="周六-周日"></Radio>
      </RadioGroup>
    </div>
    <div class="item-fare">
      <p class="clearfix"><span class="fl">商品金额</span><i class="fare fr">¥{{total}}</i></p>
      <!--<p class="clearfix"><span class="fl">运费</span><i class="fare fr">¥{{fare}}</i></p>-->
    </div>
    <div class="item-order clearfix">
      <button class="btn-order fr" @click="submitOrder(isCart)">提交订单</button>
      <p>合计：¥{{addfare}}</p>
    </div>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'order',
    data () {
      return {
        title: '',
        receiveTime: '任意时间',
        cartid: [],
        goodList: [],
        typeNum: {},
        total: 0,
        fare: 0,
        defaultaddr: [],
        AlladdrList: [], // 全部地址
        isCart: true,
        checkAddr: '',
        addrCoverShow: true,
        addrEmpty: false, // 地址为空时
        changeAddr: '更换地址',
        addrMessage: ''
      }
    },
    created () {
      this.title = this.$route.meta.title
      this.getAllAddr()
      if (this.isEmpty(this.$route.params)) {
        if (this.$route.params.cartid) { // 购物车下单
          this.getDefaultAddr()
          this.isCart = true
          this.cartid = this.$route.params.cartid || []
          this.getCartOrder()
          return
        } else if (this.$route.params.typeNum) { // 直接下单
          this.getDefaultAddr()
          this.isCart = false
          this.typeNum = this.$route.params.typeNum
          this.goodList.push(this.$route.params.typeNum)
          this.total = this.$route.params.typeNum.total
          return
        } else {
          this.$Message.error('No valid information')
          this.$router.push({name: 'home'})
        }
      } else {
        this.$Message.error('没有订单')
        this.$router.push({name: 'home'})
      }
    },
    methods: {
      isEmpty (obj) {
        if (JSON.stringify(obj) === '{}') {
          return false
        }
        return true
      },
      getCartOrder () {
        this.$Spin.show()
        const that = this
        this.$http.get(api.cart, {params: {token: that.isLogin}}).then((res) => {
          that.$Spin.hide()
          if (res.data.meta.status_code === 200) {
            for (let i of res.data.data) {
              i.total = i.n * i.price
              for (let j of that.cartid) {
                if (i.id === j) {
                  that.total = this.total + i.total
                  that.goodList.push(i)
                }
              }
            }
          } else {
            that.$Message.error(res.data.meta.status_code + res.data.meta.message)
          }
        }).catch((err) => {
          that.$Spin.hide()
          console.error(err)
        })
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
                  this.changeAddr = '更换地址'
                }
              }
              if (!this.checkAddr) {
                this.changeAddr = '没有默认地址'
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
      submitOrder (isCart) {
        this.$Spin.show()
        const that = this
        if (isCart) { // 购物车下单
          let id = this.cartid.join(',')
          this.$http.post(api.microStore, {cart_id: id, token: this.isLogin}).then((res) => {
            that.$Spin.hide()
            if (res.data.meta.status_code === 200) {
              let orderid = res.data.data.order_id
              that.$router.push({name: 'payment', params: {orderid: orderid, total: that.addfare}})
            } else {
              that.$Message.error(res.data.meta.status_code + res.data.meta.message)
            }
          }).catch((err) => {
            that.$Spin.hide()
            console.error(err)
          })
        } else { // 直接下单
          that.$http.post(api.orderStore, {
            sku_id: that.typeNum.type,
            n: that.typeNum.amount,
            token: that.isLogin
          }).then((res) => {
            that.$Spin.hide()
            if (res.data.meta.status_code === 200) {
              let orderid = res.data.data.order_id
              that.$router.push({name: 'payment', params: {orderid: orderid, total: that.addfare}})
            } else {
              that.$Message.error(res.data.meta.status_code + res.data.meta.message)
            }
          }).catch((err) => {
            that.$Spin.hide()
            console.error(err)
          })
        }
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
      getAllAddr () {
        this.$http.get(api.delivery_address, {params: {token: this.isLogin}}).then((res) => {
          if (res.data.meta.status_code === 200) {
            if (res.data.data.length) {
              this.AlladdrList = res.data.data
              for (let i of this.AlladdrList) {
                if (i.is_default === '1') {
                  this.defaultaddr = i
                }
              }
            } else {
              this.changeAddr = '没有地址'
            }
          } else {
            this.$Message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
        })
      }
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      },
      addfare () {
        return this.total + this.fare
      }
    },
    watch: {
      total () {
        if (this.goodList.length) {
          this.fare = 0
        } else {
          this.fare = 0
        }
      },
      checkAddr () {
        this.hideAddrCover()
        this.$http.post(api.default_address, {id: this.checkAddr, token: this.isLogin}).then((res) => {
          this.getAllAddr()
        }).catch((err) => {
          console.log(err)
        })
      },
      changeAddr () {
        switch (this.changeAddr) {
          case '更换地址':
            this.addrMessage = ''
            break
          case '没有地址':
            this.addrMessage = '请点击按钮添加地址'
            break
          case '没有默认地址':
            this.addrMessage = '请点击按钮设置默认地址'
            break
        }
      }
    }
  }
</script>
<style scoped>
  .order {
    font-family: "PingFangSC-Light", sans-serif !important;
    min-height: 100vh;
    margin-bottom: -50px;
  }

  .order h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
  }

  .info {
    border-top: 0.5px solid #cccccce6;
    border-bottom: 0.5px solid #cccccce6;
    font-size: 15px;
    color: #222222;
    /*letter-spacing: -0.23px;*/
    padding: 10px 15px;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 10px;
    background: #fff;
  }

  .info p {
    padding-bottom: 6px;
  }

  span.name {
    padding-right: 10px;
  }

  p.addr {
    width: 100%;
    font-size: 0;
    color: #666;
    padding-right: 80px;
    line-height: 1.2;
  }

  p.addr span {
    font-size: 12px;
    margin-right: 6px;
  }

  button.addrBtn {
    position: absolute;
    border: 0.5px solid #BE8914;
    color: #BE8914;
    background: #FFF;
    font-size: 12px;
    text-align: center;
    width: 80px;
    right: 10px;
    top: 50%;
    transform: translateY(-12.5px);
    padding: 6px 0;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
  }

  .item {
    width: 100%;
    background: #fff;
    position: relative
  }

  .item-detail {
    padding: 10px 15px;
    margin-bottom: 10px;
    background: #fff;
    border-top: 0.5px solid #cccccce6;
    border-bottom: 0.5px solid #cccccce6;
  }

  .itemleft img {
    width: 100px;
    height: 90px;
    vertical-align: top;
  }

  .itemright {
    position: relative;
    width: calc(100% - 100px);
    padding-left: 10px;
  }

  .itemright p {
    padding: 5px 0;
  }

  .itemright .itemtitle {
    color: #222222;
    font-size: 15px;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    word-break: break-all;
    font-weight: 600;
  }

  .itemright .sku {
    font-size: 12px;
    color: #666;
  }

  .itemright .sku span {
    margin-right: 8px;
  }

  .itemright .price {
    color: #BE8914;
    font-size: 15px;
  }

  .item-ticket {
    margin-bottom: 10px;
    background: #fff;
  }

  .item-ticket p {
    padding: 0 25px 0 15px;
    line-height: 44px;
    font-size: 15px;
    color: #222;
    border-top: 0.5px solid #cccccce6;
    border-bottom: 0.5px solid #cccccce6;
    position: relative;
  }

  .item-ticket p:first-child {
    border-bottom: none;
  }

  .item-ticket p i::after {
    display: block;
    position: absolute;
    content: "";
    width: 10px;
    height: 10px;
    border: 0.5px solid #cccccce6;
    border-bottom: none;
    border-left: none;
    transform: rotate(45deg);
    right: 10px;
    top: 18px;
  }

  .item-receive {
    margin-bottom: 10px;
    padding: 0 15px;
    border-top: 0.5px solid #cccccce6;
    border-bottom: 0.5px solid #cccccce6;
    background: #fff;
  }

  .item-receive p, .item-receive .receive-p {
    line-height: 40px;
    font-size: 15px;
    color: #222;
    position: relative;
  }

  .item-receive .receive-p {
    width: 100%;
    border-top: 0.5px solid #cccccce6;
  }

  .item-fare p {
    background: #ffffff;
    line-height: 40px;
    font-size: 15px;
    color: #222;
    position: relative;
    border-bottom: 0.5px solid #cccccce6;
    padding: 0 15px;
  }

  .item-fare p:first-child {
    border-top: 0.5px solid #cccccce6;
  }

  .item-fare .fare {
    color: #BE8914;
  }

  .item-order {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    border-top: 0.5px solid #cccccce6;
  }

  .item-order {
    background: #ffffff;
    color: #BE8914;
    line-height: 44px;
  }

  .item-order p {
    padding-right: 130px;
    text-align: right;
  }

  .item-order button {
    width: 120px;
    height: 44px;
    background: #BE8914;
    border: none;
    color: #fff;
    font-size: 15px;
  }

  .iteminfo {
    margin-top: 6px;
  }

  /*更换收货地址*/

  .addr-cover {
    position: fixed;
    bottom: 0;
    left: 0;
    z-index: 99;
    width: 100%;
    height: 100vh;
    background: #00000080;
    transition: 0.2s all ease;
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
    transition: 0.2s all ease;
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

  .info2 {
    border-top: 0.5px solid #cccccce6;
    font-size: 15px;
    color: #222222;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    background: #fff;
    overflow-y: scroll;
  }

  .addr-item {
    width: 100%;
    padding-left: 36px;
    border-bottom: 0.5px solid #cccccce6;
    padding-top: 10px;
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
</style>
