<template>
  <div class="retrievePassword">
    <logo></logo>
  </div>
</template>
<script>
import logo from '@/components/page/auth/logo'
export default {
  name: 'retrievePassword',
  data() {
    return {
    }
  },
  components: {
    logo
  },
  computed: {
    isLogin: {
      get () {
        return this.$store.state.event.token
      },
      set () {}
    }
  }
}
</script>
<<style scoped>

</style>
