<template>
  <div id="app">
    <v-header></v-header>
    <router-view></router-view>
    <v-footer></v-footer>
  </div>
</template>

<script>

  import vHeader from '@/components/block/Header'
  import vFooter from '@/components/block/Footer'

  export default {
    name: 'app',
    components: {
      vHeader,
      vFooter
    },
    data () {
      return {}
    }
  }

</script>

<style>

</style>
