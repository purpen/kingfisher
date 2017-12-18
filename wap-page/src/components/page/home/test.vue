<template>
  <div class="test" ref="test">
    <p>001</p>
    <p>002</p>
    <p>003</p>
    <p>004</p>
    <p>005</p>
    <p>006</p>
    <p>007</p>
    <p>008</p>
    <p>009</p>
    <p>010</p>
  </div>
</template>
<script>
  export default {
    name: 'test',
    data () {
      return {
        scrollTop: 0
      }
    },
    mounted () {
    }
  }
</script>
<style scoped>
  .test p {
    height: 100px;
    line-height: 100px;
    text-align: center;
  }

  .test p:nth-child(2n) {
    background: #fafafa;
  }
</style>
