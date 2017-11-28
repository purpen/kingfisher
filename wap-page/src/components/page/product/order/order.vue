<template>
  <div class="order">
    <h2>{{title}}</h2>
    <div class="info">
      <p><span class="name">胡歌</span><span class="mob">12312312312</span></p>
      <p class="addr">北京市海淀区五道口华清商务会馆1234室</p>
      <button class="addrBtn">更换地址</button>
    </div>
    <div class="item-detail item clearfix">
      <div class="itemleft fl">
        <img :src="require('@/assets/images/default_thn.png')" alt="">
      </div>
      <div class="itemright fl">
        <p class="itemtitle">short_title</p>
        <p class="sku">
          <span>型号:sku_name</span>
          <span class="amount">数量:2个</span>
        </p>
        <p class="iteminfo clearfix">
          <span class="price fl">￥69</span>
        </p>
      </div>
    </div>
    <div class="item-ticket">
      <p class="invoice clearfix"><span class="fl">发票</span><i class="fr">不开发票</i></p>
      <p class="coupon clearfix"><span class="fl">优惠券</span><i class="fr">无</i></p>
    </div>
    <div class="item-receive">
      <p>收货时间{{receiveTime}}</p>
      <RadioGroup v-model="receiveTime" class="receive-p">
        <Radio label="任意时间"></Radio>
        <Radio label="周一至周五"></Radio>
        <Radio label="周六-周日"></Radio>
      </RadioGroup>
    </div>
    <div class="item-fare">
      <p class="clearfix"><span class="fl">运费</span><i class="fare fr">$10.00</i></p>
    </div>
    <div class="item-order clearfix">
      <button class="btn-order fr">提交订单</button>
      <p>合计：¥199.00</p>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'order',
    data () {
      return {
        title: '',
        receiveTime: '任意时间'
      }
    },
    created () {
      this.title = this.$route.meta.title
    }
  }
</script>
<style scoped>
  .order {
    font-family: "PingFangSC-Light", sans-serif !important;
    min-height: 100vh;
    margin-bottom: -50px;
    background: #fafafa;
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
    border-top: 0.5px solid #ccc;
    border-bottom: 0.5px solid #ccc;
    font-size: 15px;
    color: #222222;
    letter-spacing: -0.23px;
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
    font-size: 12px;
    color: #666;
    padding-right: 80px;
    line-height: 1.2;
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
    border-top: 0.5px solid #ccc;
    border-bottom: 0.5px solid #ccc;
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
    border-top: 0.5px solid #ccc;
    border-bottom: 0.5px solid #ccc;
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
    border: 0.5px solid #ccc;
    border-bottom: none;
    border-left: none;
    transform: rotate(45deg);
    right: 10px;
    top: 18px;
  }

  .item-receive {
    margin-bottom: 10px;
    padding: 0 15px;
    border-top: 0.5px solid #ccc;
    border-bottom: 0.5px solid #ccc;
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
    border-top: 0.5px solid #ccc;
  }

  .item-fare p {
    background: #ffffff;
    line-height: 40px;
    font-size: 15px;
    color: #222;
    position: relative;
    border-top: 0.5px solid #ccc;
    border-bottom: 0.5px solid #ccc;
    padding: 0 15px;
  }

  .item-fare .fare {
    color: #BE8914;
  }

  .item-order {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    border-top: 0.5px solid #ccc;
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
</style>
