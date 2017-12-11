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
          if (res.data.meta.status_code === 200) {
            let config = JSON.parse(res.data.data.jsApiParameters)
            console.log(config)
            console.log(config.appId)
            wx.chooseWXPay({
              timeStamp: config.timeStamp,
              nonceStr: config.nonceStr,
              package: config.package,
              signType: config.signType,
              paySign: config.paySign,
              appId: config.appId,
              success (r) {
                console.log(r)
                console.log(config.appId)
                console.log(config.timeStamp)
                console.log(config.nonceStr)
                console.log(config.package)
                console.log(config.signType)
                console.log(config.paySign)
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
          } else {
            this.$message.error(res.data.meta.message)
          }
        }).catch((err) => {
          console.error(err)
        })
      }
    },
    created () {
      let wx = require('weixin-js-sdk')
      console.log(wx)
      this.code = this.$route.query.code
      this.order_id = this.$route.query.order_id
      this.token = this.$route.query.token
      this.choosewxPay()
    }
  }
</script>
<style scoped>

</style>
