<template>
  <div class="order-detail">
    <h2 class="header-h2">
      <router-link :to="{name:'orderControl'}" class="backIcon">
      </router-link>
      查看订单详情
    </h2>
    <div class="status">
      <p class="wait-pay">等待付款</p>
    </div>
    <ul class="good-list tbBoder">
      <li v-for="(ele, index) in goodList" :key="index" class="item-detail item clearfix">
        <div class="itemleft fl">
          <img v-if="ele.image" :src="ele.image" :alt="ele.product_title">
          <img v-else :src="require('@/assets/images/default_thn.png')" alt="">
        </div>
        <div class="itemright fl">
          <p class="itemtitle">{{ele.product_title}}</p>
          <p class="sku">
            <span>型号:{{ele.sku_mode}}</span>
            <span class="amount">数量:{{ele.quantity}}个</span>
          </p>
          <p class="iteminfo clearfix">
            <span class="price fl">￥{{ele.price}}</span>
          </p>
        </div>
      </li>
    </ul>
    <!--<div class="express-info tbBoder">-->
    <!--<p class="cur-location">快件已到达【北京昌平公司】</p>-->
    <!--<p class="courier">派件人员:<span>郭晓</span></p>-->
    <!--<p class="express-date">2017.09.07  14:00:09</p>-->
    <!--<span class="express-detail">查看物流详情</span>-->
    <!--</div>-->
    <div class="addrs tbBoder">
      <p class="clearfix">
        <span class="name">{{data.buyer_name}}</span>
        <span class="mob fr">{{data.buyer_phone}}</span>
      </p>
      <p class="addr">
        <span v-if="data.buyer_province">{{data.buyer_province}}</span>
        <span v-if="data.buyer_city">{{data.buyer_city}}</span><br>
        <span v-if="data.buyer_county">{{data.buyer_county}}</span>
        <span v-if="data.buyer_township">{{data.buyer_township}}</span>
        <span v-if="data.buyer_address">{{data.buyer_address}}</span>
      </p>
    </div>
    <div class="order-info tbBoder">
      <p>订单编号: <span>{{data.id}}</span></p>
      <p>下单时间: <span>{{data.order_start_time}}</span></p>
      <p>支付方式: <span>{{data.payment_type}}</span></p>
      <!--<p>快递公司: <span>{{''}}</span></p>-->
      <!--<p>发票类型: <span>不开发票{{''}}</span></p>-->
    </div>
    <div class="price-info tbBoder">
      <!--<p class="freight clearfix">运费 <span class="fr"><i>￥</i>{{0}}</span></p>-->
      <p class="total clearfix">订单总价 <span class="fr"><i>￥</i>{{data.total_money}}</span></p>
    </div>
    <div class="buttons">
      <router-link to="" @click.native="del(data.id)">{{button1}}</router-link>
      <router-link :to="{name: 'payment',params:{orderid: data.id, total: data.total_money}}">{{button2}}</router-link>
    </div>
    <Modal
      v-model="modal"
      width="90%"
      :styles="{top: '30%'}"
      @on-ok="delorder">
      确认取消订单？
    </Modal>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'orderDetail',
    data () {
      return {
        order_id: '',
        goodList: [],
        data: {},
        modal: false,
        delid: 0,
        button1: '取消订单',
        button2: '继续付款'
      }
    },
    created () {
      if (this.$route.params.id) {
        this.order_id = this.$route.params.id
        this.getOrder()
        return
      } else {
        this.$Message.error('没有此订单')
        this.$router.push({name: 'orderControl'})
      }
    },
    methods: {
      getOrder () {
        this.$Spin.show()
        this.$http.get(api.order, {params: {order_id: this.order_id, token: this.isLogin}}).then((res) => {
          if (res.data.meta.status_code === 200) {
            this.$Spin.hide()
            this.data = res.data.data
            this.goodList = this.data.orderSkus
          } else {
            this.$Message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
          this.$Spin.hide()
        })
      },
      del (id) {
        this.delid = id
        this.modal = true
      },
      delorder () {
        this.$http.get(api.delorder, {params: {order_id: this.delid, token: this.isLogin}}).then((res) => {
          if (res.data.meta.status_code === 200) {
            this.$router.push({name: 'orderControl'})
          }
        }).catch((err) => {
          console.log(err)
        })
      }
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    }
  }
</script>
<style scoped>
  .order-detail {
    background: #fafafa;
    min-height: 100vh;
    margin-bottom: -50px;
    overflow: hidden;
  }

  .status {
    padding-bottom: 10px;
  }

  .status p {
    height: 40px;
    background: #CCA776;
    text-align: center;
    line-height: 40px;
    color: #ffffff;
  }

  .status p.complete {
    background: #25AE5F;
  }

  .status p.wait-pay {
    background: #CCA776;
  }

  /*商品列表*/

  .good-list {
    background: #fff;
    padding: 10px 15px;
    margin-bottom: 10px;
  }

  .item-detail {
    padding: 10px 0;
    border-bottom: 0.5px solid #cccccce6;
  }

  .good-list .item-detail:last-child {
    padding-bottom: 0;
    border-bottom: none;
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

  /*物流信息*/
  .express-info {
    margin-bottom: 10px;
    padding: 10px 15px;
    background: #ffffff;
    color: #666;
    line-height: 20px;
    position: relative;
  }

  .express-date {
    font-size: 12px;
  }

  .express-detail {
    position: absolute;
    right: 25px;
    top: 30px;
  }

  .express-detail::after {
    display: block;
    position: absolute;
    content: "";
    width: 10px;
    height: 10px;
    border: 0.5px solid #ccc;
    border-bottom: none;
    border-left: none;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    right: -14px;
    top: 5px;
  }

  /*地址信息*/
  .addrs {
    font-size: 15px;
    color: #222222;
    padding: 10px 15px;
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 10px;
    background: #fff;
  }

  .addrs p {
    width: 100%;
    padding-bottom: 6px;
  }

  span.name, span.mob {
    font-weight: 600;
  }

  p.addr {
    width: 100%;
    font-size: 0;
    color: #666;
    padding-right: 80px;
    line-height: 1.2;
  }

  p.addr span {
    font-size: 15px;
    margin-right: 6px;
  }

  /*订单信息*/
  .order-info, .price-info {
    margin-bottom: 10px;
    background: #ffffff;
    color: #222;
  }

  .order-info p, .price-info p {
    padding: 0 15px;
    line-height: 44px;
    height: 44px;
    border-bottom: 0.5px solid #cccccce6;
  }

  .order-info p:last-child, .price-info p:last-child {
    border-bottom: none;
  }

  .order-info span {
    padding-left: 8px;
  }

  .price-info p span {
    color: #BE8914;
  }

  .buttons {
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    height: 40px;
    border-top: 0.5px solid #cccccce6;
  }

  .buttons a {
    font-size: 12px;
    border: 0.5px solid #BE8914;
    border-radius: 2px;
    color: #BE8914;
    padding: 4px 8px;
    margin-right: 10px;
  }
</style>
