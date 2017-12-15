<template>
  <div class="orderMenu">
    <span @click="getOrder()" :class="['all', {'checked':eid ===0}]">全部</span>
    <span @click="getOrder(1)" :class="['waitPay', {'checked':eid ===1}]">待付款</span>
    <span @click="getOrder(5)" :class="['waitRate', {'checked':eid ===5}]">待审核</span>
    <span @click="getOrder(8)" :class="['waitSend', {'checked':eid ===8}]">待发货</span>
    <span @click="getOrder(10)" :class="['waitConfirm', {'checked':eid ===10}]">待收货</span>
    <span @click="getOrder(20)" :class="['waitConfirm', {'checked':eid ===20}]">完成</span>
  </div>
</template>
<script>
  export default {
    name: 'orderMenu',
    data () {
      return {
        eid: 0
      }
    },
    methods: {
      getOrder (i = 0) {
        if (i) {
          this.eid = i
          this.$emit('spanClick', i)
        } else {
          this.eid = 0
          this.$emit('spanClick')
        }
      }
    }
  }
</script>
<style scoped>
  .orderMenu {
    background: #fff;
    display: flex;
    justify-content: space-between;
    height: 45px;
    padding: 0 11px;
    border-top: 0.5px solid #cccccc7d;
    border-bottom: 0.5px solid #cccccc7d;
    color: #666;
  }

  .orderMenu span {
    font-size: 14px;
    line-height: 45px;
    padding: 0 4px;
  }

  .orderMenu span.checked {
    color: #BE8914;
    border-bottom: 2px solid #BE8914;
  }

  .order-del {
    border: 0 solid #BE8914;
    border-radius: 2px;
  }
</style>
