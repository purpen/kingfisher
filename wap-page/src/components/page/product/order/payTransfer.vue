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
        // let wx = require('weixin-js-sdk')
        this.$http.get(api.wxPay, {
          params: {
            order_id: this.order_id,
            code: this.code,
            token: this.token
          }
        }).then((res) => {
          console.log(res)
        }).catch((err) => {
          console.error(err)
        })
      }
    },
    created () {
      console.log(this)
      console.log(this.$route)
      this.code = this.$route.query.code
      this.order_id = this.$route.query.order_id
      this.token = this.$route.query.token
      this.choosewxPay()
    }
  }
</script>
<style scoped>

</style>
