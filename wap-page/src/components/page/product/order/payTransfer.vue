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
        console.log(res)
        if (res.data.meta.status_code === 200) {
          console.log('success')
        } else {
          console.log(this.order_id)
          console.log(this.code)
          console.log(this.token)
          console.log(res.data.meta.message)
        }
      }).catch((err) => {
        console.error(err)
      })
    }
  }
</script>
<style scoped>

</style>
