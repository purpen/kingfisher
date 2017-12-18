<template>
  <div class="personal fullscreen">
    <div class="i-header">
      <i class="option"></i>
      <div class="headerBanner clearfix">
        <img :src="require('@/assets/images/default_thn.png')" alt="" class="fl">
        <div class="user fl">
          <p>188****5706</p>
          <span>说说你是什么人，来自哪片山川湖海</span>
        </div>
      </div>
      <div class="my_section">
        <a class="goodsFavItem"><span>60</span><i>收藏</i></a>
        <a class="my_lnks_item"><span>256</span><i>浏览记录</i></a>
      </div>
    </div>
    <div class="ibody">
      <div class="head_order clearfix">
        <span class="fl">我的订单</span>
        <i class="fr">
          <router-link :to="{name:'orderControl'}">查看全部订单</router-link>
        </i>
      </div>
      <div class="list_order">
        <p><i class="item1"></i><span>待付款</span></p>
        <p><i class="item2"></i><span>待发货</span></p>
        <p><i class="item3"></i><span>待收货</span></p>
        <p><i class="item4"></i><span>待评价</span></p>
        <p><i class="item5"></i><span>退款售后</span></p>
      </div>
      <div class="account_manage">
        <router-link to="" class="couponItem clearfix">
          <span class="fl">我的优惠券</span>
          <i class="fr"></i>
        </router-link>
        <router-link to="" class="i-message clearfix">
          <span class="fl">我的消息</span>
          <i class="fr"></i>
        </router-link>
        <router-link :to="'/addrControl'" class="i-address clearfix">
          <span class="fl">地址管理</span>
          <i class="fr"></i>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'personal',
    data () {
      return {}
    }
  }
</script>
<style scoped>
  .personal {
    position: relative;
    top: -50px;
    z-index: 100;
    padding: 0;
    overflow: hidden;
    color: #222;
  }

  .i-header {
    position: relative;
    background: url("../../../assets/images/icon/ibg.png") no-repeat center;
    background-size: cover;
  }

  .option {
    position: absolute;
    right: 15px;
    top: 15px;
    width: 20px;
    height: 20px;
    background: url("../../../assets/images/icon/setting.png") no-repeat center;
    background-size: contain;
  }

  .headerBanner {
    padding: 25px 40px 20px;
    color: #fff;
  }

  .headerBanner img {
    width: 65px;
    height: 65px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border: 4px solid #fff;
    border-radius: 50%;
  }

  .user {
    max-width: calc(100% - 65px);
    padding-left: 15px;
  }

  .user p {
    font-size: 16px;
    line-height: 2
  }

  .user span {
    font-size: 12px;
  }

  .my_section {
    display: flex;
    background: #5353544d;
  }

  .my_section a {
    flex: 1;
    height: 40px;
    padding: 4px 0;
    text-align: center;
    color: #ffffffe6;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    font-size: 14px;
    position: relative;
  }

  .my_section a i {
    font-size: 12px;
  }

  .goodsFavItem::after {
    content: "";
    display: block;
    position: absolute;
    height: 10px;
    border-right: 1px solid #ededede6;
    right: 0;
  }

  .head_order {
    background: #FFFFFF;
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
    line-height: 44px;
    padding: 0 25px 0 15px;
    position: relative;
  }

  .head_order i::after, .account_manage i::after {
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
    right: 10px;
    top: 17px;
  }

  .list_order {
    display: flex;
    justify-content: space-between;
    height: 65px;
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
    background: #ffffff;
    margin-bottom: 10px;
    font-size: 12px;
    padding: 10px 15px;
  }

  .list_order p {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
  }

  .list_order p i {
    display: block;
    width: 30px;
    height: 30px;
  }

  .item1 {
    background: url("../../../assets/images/icon/Unpaid.png") no-repeat center;
    background-size: contain;
  }

  .item2 {
    background: url("../../../assets/images/icon/PendingShipment.png") no-repeat center;
    background-size: contain;
  }

  .item3 {
    background: url("../../../assets/images/icon/GoodsToBeReceived.png") no-repeat center;
    background-size: contain;
  }

  .item4 {
    background: url("../../../assets/images/icon/PendingEvaluation.png") no-repeat center;
    background-size: contain;
  }

  .item5 {
    background: url("../../../assets/images/icon/CustomerService.png") no-repeat center;
    background-size: contain;
  }

  .account_manage {
    background: #ffffff;
    border-top: 0.5px solid rgba(204, 204, 204, 0.49);
  }

  .account_manage a {
    position: relative;
    display: block;
    width: 100%;
    height: 44px;
    line-height: 44px;
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
    padding: 0 25px 0 15px;
  }
</style>
