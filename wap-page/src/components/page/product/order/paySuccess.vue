<template>
  <div class="paySuccess">
    <h2>订单支付成功</h2>
    <p class="success">
      <i></i>
      <span>订单支付成功!</span>
    </p>
    <div class="info">
      <b>支付信息</b>
      <p class="clearfix"><span class="fl">订单编号</span><i class="fr">{{uid}}</i></p>
      <p class="clearfix"><span class="fl">下单时间</span><i class="fr">{{date}}</i></p>
      <p class="clearfix"><span class="fl">支付方式</span><i class="fr">{{payType}}</i></p>
      <p class="clearfix"><span class="fl">订单金额</span><i class="fr">{{total}}</i></p>
    </div>
    <div class="recipients">
      <b>收件人</b>
      <div>
        <p>
          <span class="name">{{addrList.name}}</span>
          <span class="mob">{{addrList.phone}}</span>
        </p>
        <p class="addr">
          <span v-if="addrList.province">{{addrList.province}}</span>
          <span v-if="addrList.city">{{addrList.city}}</span>
          <span v-if="addrList.county">{{addrList.county}}</span>
          <span v-if="addrList.town">{{addrList.town}}</span>
          <span v-if="addrList.address">{{addrList.address}}</span>
        </p>
      </div>
    </div>
    <p class="buttons">
      <router-link :to="{name:'home'}">返回首页</router-link>
      <router-link :to="{name: 'orderControl'}">订单列表</router-link>
    </p>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'paySuccess',
    data () {
      return {
        addrList: {},
        uid: '',
        date: '',
        payType: '',
        total: ''
      }
    },
    created () {
      this.$Spin.show()
      this.getDefaultAddr()
      if (!this.$route.params) {
        this.uid = this.$route.params.uid
        this.date = this.$route.params.date
        this.payType = this.$route.params.payType
        this.total = this.$route.params.total
      } else {
        this.$Message.error('没有订单信息')
        this.$router.push({name: 'home'})
      }
    },
    methods: {
      getDefaultAddr () {
        const that = this
        that.$http.get(api.delivery_address, {params: {token: that.isLogin}}).then((res) => {
          this.$Spin.hide()
          if (res.data.meta.status_code === 200) {
            if (res.data.data) {
              for (let i of res.data.data) {
                if (i.is_default === '1') {
                  that.addrList = i
                }
              }
            }
          } else {
            that.$Message.error(res.data.meta.status_code + res.data.meta.message)
          }
        }).catch((err) => {
          this.$Spin.hide()
          console.error(err)
        })
      }
    }
  }
</script>
<style scoped>
  .paySuccess {
    min-height: 100vh;
    background: #fafafa;
    margin-bottom: -50px;
    overflow: hidden;
  }

  .paySuccess h2 {
    text-align: center;
    line-height: 44px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
    border-bottom: 1px solid #e6e6e6;
  }

  .success {
    height: 158px;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .success i {
    position: absolute;
    width: 40px;
    height: 40px;
    top: 30px;
    left: 0;
    right: 0;
    margin: auto;
    background: #5ECC37;
    border-radius: 50%;
  }

  .success i::before {
    content: "";
    position: absolute;
    left: 11px;
    top: 11px;
    width: 20px;
    height: 12px;
    border-bottom: 4px solid #ffffff;
    border-left: 4px solid #ffffff;
    transform: rotate(-45deg);
  }

  .success span {
    line-height: 200px;
  }

  .info {
    font-size: 15px;
    color: #222;
  }

  .info b {
    color: #666;
    margin-top: -26px;
    line-height: 26px;
    padding-left: 15px;
    font-size: 14px;
  }

  .info p {
    padding: 0 15px;
    height: 44px;
    line-height: 44px;
    background: #ffffff;
    border-top: 0.5px solid #cccccce6;
  }

  .info p:last-child {
    border-bottom: 0.5px solid #cccccce6;
  }

  .recipients div {
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
    margin-bottom: 16px;
    background: #fff;
  }

  .recipients b {
    padding-left: 15px;
    padding-top: 10px;
    line-height: 26px;
    display: block;
    color: #666;
  }

  .recipients p {
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
    padding-bottom: 0;
  }

  p.addr span {
    font-size: 12px;
    margin-right: 6px;
  }

  .buttons {
    display: flex;
    padding: 0 30px;
    justify-content: center;
    align-items: center;
  }

  .buttons a {
    width: 128px;
    height: 30px;
    background: #BE8914;
    color: #fff;
    border-radius: 4px;
    text-align: center;
    font-size: 12px;
    line-height: 30px;
    margin: 0 5%;
  }
</style>
