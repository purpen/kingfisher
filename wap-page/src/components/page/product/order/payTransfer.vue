<template>

</template>
<script>
  import api from '@/api/api'
  export default {
    name: '',
    data () {
      return {
        order_id: 0,
        code: '',
        token: ''
      }
    },
    methods: {
      choosewxPay () {
        let wx = require('weixin-js-sdk')
        this.$http.get(api.wxPay, {
          params: {
            order_id: this.order_id,
            code: this.code,
            token: this.token
          }
        }).then((res) => {
          console.log(res)
          if (res.data.meta.status_code === 200) {
            let config = res.data.data.jsApiParameters
            wx.config({
              debug: true,
              appId: config.appId,
              timestamp: config.timeStamp,
              nonceStr: config.nonceStr,
              signature: config.signature,
              jsApiList: ['chooseWXPay']
            })
            wx.ready(() => {
              wx.chooseWXPay({
                appId: config.appId,
                nonceStr: config.nonceStr,
                package: config.package,
                timeStamp: config.timeStamp,
                signType: config.signType,
                paySign: config.paySign,
                success (r) {
                  console.log(r, 'r')
                  console.log(config.timeStamp)
                  if (r.errMsg === 'chooseWXPay:ok') {
                    window.alert('支付成功')
                    window.location.reload()
                  } else {
                    window.alert(' 支付失败')
                    window.location.reload()
                  }
                },
                cancel () {
                  window.alert('支付取消')
                  window.location.reload()
                },
                error () {
                  window.alert('支付失败')
                  window.location.reload()
                }
              })
            })
          } else {
            this.$message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
        })
      }
    },
    created () {
      this.code = this.$route.query.code
      this.order_id = this.$route.query.order_id
      this.token = this.$route.query.token
      this.choosewxPay()
    }
  }
</script>
<style scoped>

</style>
