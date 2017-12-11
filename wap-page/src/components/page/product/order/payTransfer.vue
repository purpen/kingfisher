<template>

</template>
<script>
  import api from '@/api/api'
  import onBridgeReady from 'static/js/wxPay'
  export default {
    name: '',
    data () {
      return {
        order_id: 0,
        code: '',
        token: '',
        wxConfig: {}
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
          this.wxConfig = res.data.data
          onBridgeReady(res.data.data)
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
