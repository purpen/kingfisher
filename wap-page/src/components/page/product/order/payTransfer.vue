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
          wx.chooseWXPay({
            appId: res.data.data.appId,
            noceStr: res.data.data.noceStr,
            package: res.data.data.package,
            signType: res.data.data.signType,
            paySign: res.data.data.paySign,
            timestamp: res.data.data.timestamp,
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
