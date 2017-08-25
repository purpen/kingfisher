<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>创建订单</Breadcrumb-item>
    </Breadcrumb>
    <div class="order-box">
      <h3>创建订单</h3>



    </div>
    
  </div>
</template>

<script>
// import api from '@/api/api'
export default {
  name: 'center_order_submit',
  data () {
    return {
      isLoading: false,
      msg: ''
    }
  },
  methods: {
  },
  created: function () {
  },
  watch: {
    '$route' (to, from) {
      // 对路由变化作出响应...
      this.loadList()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .order-box {
    margin: 20px 0 0 0;
  }

  .order-box h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
    margin-bottom: 15px;
  }


</style>
