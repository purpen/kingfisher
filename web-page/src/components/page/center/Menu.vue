<template>

  <div class="menu-list">
    <router-link :to="{name: 'centerBasic'}" :class="{'item': true, 'is-active': currentName === 'base' ? true : false}">
      账户概况
    </router-link>
    <router-link :to="{name: 'centerProduct'}" :class="{'item': true, 'is-active': currentName === 'product' ? true : false}">
      我的产品
    </router-link>
    <router-link :to="{name: 'centerOrder'}" :class="{'item': true, 'is-active': currentName === 'order' ? true : false}">
      我的订单
    </router-link>
    <router-link :to="{name: 'centerSurveyHome'}" :class="{'item': true, 'is-active': currentName === 'survey' ? true : false}">
      销售趋势
    </router-link>
    <router-link :to="{name: 'centerIdentifyShow'}" :class="{'item': true, 'is-active': currentName === 'identify_show' ? true : false}">
      企业信息
    </router-link>
  </div>

</template>

<script>
export default {
  name: 'center_menu',
  props: {
    currentName: {
      default: ''
    }
  },
  data () {
    return {
      msg: 'This is menu'
    }
  },
  methods: {
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .rz-box {
    margin-top: 50px;
  }
  .rz-title {
    float: left;
  }
  .rz-title p{
    font-size: 1.8rem;
  }
  .success p {
    color: #008000;
  }
  .wait p {
    color: #FF4500;
  }
  .rejust p {
    color: #FF4500;
  }
  .rz-stat {
    float: right;
  }

  .company-show {
  
  }

  .company-show .item {
    clear: both;
    height: 40px;
    border-bottom: 1px solid #ccc;
  }

  .item p {
    line-height: 3;
  }

  .item p.p-key {
    float: left;
    width: 150px;
    color: #666;
  }

  .item p.p-val {
    width: 300px;
    float: left;
    font-size: 1.5rem;
  }


</style>

