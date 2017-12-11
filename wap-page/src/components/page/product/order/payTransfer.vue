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
    methods: {},
    created () {
      let wx = require('weixin-js-sdk')
      this.code = this.$route.query.code
      this.order_id = this.$route.query.order_id
      this.token = this.$route.query.token
      this.$http.get(api.wxPay, {
        params: {
          order_id: this.order_id,
          code: this.code,
          token: this.token
        }
      }).then((res) => {
        if (res.data.meta.status_code === 200) {
          console.log(res)
          console.log(res.data.data.jsApiParameters instanceof Object, 'object')
          console.log(res.data.data.jsApiParameters instanceof String, 'string')
          let config = JSON.parse(res.data.data.jsApiParameters)
          console.log(config instanceof String, 'config')
          wx.chooseWXPay({
            appId: config.appId,
            noceStr: config.noceStr,
            package: config.package,
            signType: config.signType,
            paySign: config.paySign,
            timestamp: config.timestamp,
            success (r) {
              console.log(r)
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
  }
</script>
<style scoped>

</style>
