<template>
  <div class="payment fullscreen">
    <h2>{{title}}</h2>
    <div class="paylist">
      <p class="choose-pay clearfix"><span>请选择支付方式</span><i>￥{{total}}</i></p>
      <RadioGroup v-model="pay" class="pay">
        <Radio class="pay-method wepay" label="微信支付"></Radio>
        <Radio class="pay-method alipay" label="支付宝支付"></Radio>
        <Radio class="pay-method upcash" label="银联支付"></Radio>
      </RadioGroup>
    </div>
    <button class="defrayal" @click="submitPay">立即支付</button>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'payment',
    data () {
      return {
        title: '',
        pay: '微信支付',
        total: 0,
        orderid: 0,
        pay_type: 1
      }
    },
    created () {
      this.title = this.$route.meta.title
      if (this.$route.params.total) {
        if (Number.isInteger(this.$route.params.total)) {
          this.total = this.$route.params.total + '.00'
        } else {
          this.total = this.$route.params.total
        }
      }
      this.orderid = this.$route.params.orderid
    },
    watch: {
      pay () {
        if (this.pay === '微信支付') {
          this.pay_type = 1
        } else if (this.pay === '支付宝支付') {
          this.pay_type = 2
        } else if (this.pay === '银联支付') {
          this.pay_type = 3
        }
      }
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
      submitPay () {
        let that = this
        that.$http.get(api.pay_ment, {params: {order_id: that.orderid, pay_type: that.pay_type, token: this.isLogin}}).then((res) => {
          if (res.status === 404) {
            that.$Message.error(res.message)
          } else {
            if (res.data.meta.status_code === 200) {
              window.location = res.data.data.url
            } else {
              that.$Message.error(res.data.meta.message)
            }
          }
        }).catch((err) => {
          console.error(err)
          this.$Message.error(err.status_code + err.message)
        })
      }
    }
  }
</script>
<style scoped>
  .payment {
    min-height: calc(100vh - 50px);
    background: #fafafa;
    padding-bottom: 0;
  }

  h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
  }

  .choose-pay {
    height: 50px;
    background:#ffffff;
    line-height: 50px;
    margin-top: 10px;
    padding: 0 15px;
  }

  .choose-pay i {
    color: #BE8914;
    float: right;
  }
  .pay {
    width: 100%;
    /* border-top: 0.5px solid #ccc; */
    background: #fafafa;
    padding-top: 10px;
  }

  .pay-method {
    display: flex;
    align-items: center;
    width: 100%;
    line-height: 50px;
    padding: 0 15px 0 60px;
    font-size: 14px;
    margin-bottom: 10px;
  }

  .upcash {
    background: url("../../../../assets/images/icon/UPcash.png") no-repeat 15px #ffffff;
    -webkit-background-size: 40px;
    background-size: 40px;
  }

  .alipay {
    background: url("../../../../assets/images/icon/Alipay.png") no-repeat 15px #ffffff;
    -webkit-background-size: 30px;
    background-size: 30px;
  }

  .wepay {
    background: url("../../../../assets/images/icon/WeChat@2x.png") no-repeat 15px #ffffff;
    -webkit-background-size: 30px;
    background-size: 30px;
  }

  .defrayal {
    position: fixed;
    bottom: 0;
    left: 0;
    color: #fff;
    width: 100%;
    height: 50px;
    line-height: 50px;
  }
</style>
