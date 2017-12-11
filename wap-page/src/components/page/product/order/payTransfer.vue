<template>

</template>
<script>
  import api from '@/api/api'
  //  import onBridgeReady from 'static/js/wxPay'
  import wx from 'static/js/jweixin-1.2.0'
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
