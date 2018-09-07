<template>
    <div class="container min-height350">
      <div class="orderdetails margin-t-50">
        <div class="orderStatus border">
          <div class="orderStatus_left">
            <p class="font-12 color_666">订单号 <span>9989768778</span> </p>
            <p class="font-16 color_ed3a margin-t-10 margin-b-10">等待付款</p>
            <span class="font-14 line-hei-1 color_ed3a display-flex-ju-center margin-b-8"><Icon type="ios-time-outline" />23:59:59</span>
            <div class="margin-b-15">
              <Button class="button-style display-flex-ju-center">付款</Button>
            </div>
            <Button class="back_c8 button-style display-flex-ju-center">立即付款</Button>
          </div>
          <div class="orderStatus_step">
            <p class="color_666 font-12 text-center margin-b-40">该订单会为您保留24小时（从下单时间算起），24小时之后如果还未付款，系统将自动取消该订单。</p>
            <div class="padd-l-100">
              <Steps :current="1">
                <Step title="提交订单"></Step>
                <Step title="付款成功"></Step>
                <Step title="待收货"></Step>
                <Step title="已完成"></Step>
              </Steps>
            </div>
          </div>
        </div>
        <div class="userOrderInfo border">
          <table class="wid_100 text-left">
            <tr class="userOrderInfo_tr">
              <th style="width: 360px">收货人信息</th>
              <th>配送信息</th>
              <th>付款信息</th>
              <th>发票信息</th>
            </tr>
            <tr class="userOrderInfo_tr">
              <td>
                <div class="padd-b-15">
                  <div class="display-flex-algin padd-r-40">
                    <p class="wid-90">收货人：</p>
                    <span>张三</span>
                  </div>
                  <div class="display-flex-algin padd-r-40">
                    <p class="wid-90">收货地区：</p>
                    <span>北京市朝阳区</span>
                  </div>
                  <div class="display-flex-algin padd-r-40" style="align-items: baseline">
                    <p class="wid-90">地址：</p>
                    <span class="wid-200 lin-clamp-3">酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥酒仙桥</span>
                  </div>
                  <div class="display-flex-algin padd-r-40">
                    <p class="wid-90">手机：</p>
                    <span>13020663711</span>
                  </div>
                </div>
              </td>
              <td>
                <div class="display-flex-algin">
                  <p class="wid-90">配送方式：</p>
                  <p>普通快递</p>
                </div>
              </td>
              <td>
                <div class="display-flex-algin">
                  <p class="wid-90">付款方式：</p>
                  <p>在线支付</p>
                </div>
                <div class="display-flex-algin">
                  <p class="wid-90">商品总额：</p>
                  <p>￥699.00</p>
                </div>
                <div class="display-flex-algin">
                  <p class="wid-90">应付总额：</p>
                  <p>￥699.00</p>
                </div>
              </td>
              <td>
                <div class="display-flex-algin">
                  <p class="wid-90">发票类型：</p>
                  <p>不开发票</p>
                </div>
              </td>
            </tr>
          </table>
        </div>
        <div class="orderInfo">
          <Table border :columns="tableTitle" :data="data1"></Table>
          <div class="money">
            <div class="display-flex-ju-end" style="margin-bottom: 5px">
              <p class="font-12 color_666">商品总额:</p>
              <span class="color_666">￥899.00</span>
            </div>
            <div class="display-flex-ju-end">
              <p class="font-12 color_666">应付总额:</p>
              <span class="font-16 color_ed3a">￥899.00</span>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
  export default {
    name: 'orderDetails',
    data () {
      return {
        tableTitle: [
          {
            title: '商品',
            key: 'name',
            width: 360,
            render: (h, params) => {
              return h('img', {
                style: {
                  width: '100px',
                  padding: '10px'
                },
                attrs: {
                  src: require('@/assets/images/home/banner/banner01.png')
                }
              })
            }
          },
          {
            title: '商品编号',
            key: 'age'
          },
          {
            title: '价格',
            key: 'price'
          },
          {
            title: '数量',
            key: 'number'
          }
        ],
        data1: [
          {
            name: 'John Brown',
            age: 18,
            price: '￥699.00',
            number: 'x' + 1
          },
          {
            name: 'Jim Green',
            age: 24,
            price: '￥1699.00',
            number: 'x' + 1
          },
          {
            name: 'Joe Black',
            age: 30,
            price: '￥799.00',
            number: 'x' + 1
          },
          {
            name: 'Jon Snow',
            age: 26,
            price: '￥3699.00',
            number: 'x' + 1
          }
        ]
      }
    },
    methods: {},
    created () {

    },
    components: {}
  }
</script>

<style scoped>
  .orderdetails {
    padding: 0 75px;
  }

  .orderStatus {
    padding: 25px 0;
    display: flex;
    margin-bottom: 25px;
  }
  .border {
    border: 1px solid #e8eaec;
  }
  .orderStatus_left {
    text-align: center;
    width: 230px;
    border-right: 1px solid rgba(240,240,240,1);
  }
  .orderStatus_step {
    flex: 1;
    /*text-align: center;*/
  }

  .line-hei-1 {
    line-height: 1;
  }

  .button-style {
    width: 90px;
    height: 30px;
    margin: 0 auto;
    border-radius: 0;
    font-size: 12px;
  }

  .back_c8 {
    background:rgba(240,240,240,1);
    border-color: rgba(200,200,200,1);
    color:rgba(102,102,102,1);
  }

  .padd-l-100 {
    padding-left: 100px;
  }

  .step-ul li {
    float: left;
    width: 25%;
    text-align: center;
  }

  .userOrderInfo {
    margin-bottom: 45px;
  }

  .orderInfo {
    margin-bottom: 45px;
  }

  .userOrderInfo_tr th {
    height: 40px;
    padding-left: 18px;
    background:rgba(240,240,240,1);
    font-size: 14px;
    color: #333333;
    border: none;
  }
  .userOrderInfo_tr td {
    padding-left: 18px;
    font-size: 12px;
    font-weight:400;
    color:rgba(102,102,102,1);
    border-right: 1px solid #e8eaec;
  }

  .padd-t-19 {
    padding-top: 19px;
    margin-bottom: 23px;
  }

  .wid-90 {
    width: 90px;
  }

  .display-flex-algin p {
    color: #666666;
    font-size: 12px;
    line-height: 3;
  }

  .padd-r-40 {
    padding-right: 40px;
  }

  .wid-200 {
    width: 200px;
  }

  .money {
    width: 100%;
    height: 70px;
    border: 1px solid #dcdee2;
    border-top: none;
    text-align: right;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-right: 20px;
  }

  .display-flex-ju-end {
    display: flex;
    align-items: center;
    justify-content: flex-end;
  }

  .display-flex-ju-end p {
    width: 60px;
    text-align: left;
  }

  .display-flex-ju-end span {
    width: 80px;
    text-align: right;
  }
</style>
