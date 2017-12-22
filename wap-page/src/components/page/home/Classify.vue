<template>
  <div class="classify">
    <div class="classify-header clearfix">
      <div class="header-logo fl"></div>
      <div class="mail fr"></div>
      <div class="search">
        <input class="search-title" @focus="Ifocus" v-model="goods" ref="goods">
      </div>
    </div>
    <div class="classify-body">
      <ul class="list clearfix">
        <li>
          <router-link to=""><i class="i01"></i><span>智能家居</span></router-link>
        </li>
        <li>
          <router-link to=""><i class="i02"></i><span>穿戴设备</span></router-link>
        </li>
        <li>
          <router-link to=""><i class="i03"></i><span>户外出行</span></router-link>
        </li>
        <li>
          <router-link to=""><i class="i04"></i><span>生活美学</span></router-link>
        </li>
        <li>
          <router-link to=""><i class="i05"></i><span>消费电子</span></router-link>
        </li>
        <li>
          <router-link to=""><i class="i06"></i><span>母婴用品</span></router-link>
        </li>
        <li>
          <router-link to=""><i class="i07"></i><span>健康周边</span></router-link>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'classify',
    data () {
      return {
        goods: ''
      }
    },
    methods: {
      Ifocus (e) {
        this.goods = ''
        this.$router.push({name: 'searchGoods'})
      }
    },
    created () {
      this.goods = this.language.home.search
    },
    computed: {
      language () {
        return this.$store.state.event.language
      }
    }
  }
</script>
<style scoped>
  .classify {
    min-height: calc(100vh - 100px);
    background: #fafafa;
  }

  .classify-header {
    position: absolute;
    top: 3px;
    left: 0;
    width: 100%;
    height: 44px;
    background: #fff;
    padding-left: 15px;
    overflow: hidden;
  }

  .header-logo {
    width: 54px;
    height: 38px;
    background: url('../../../assets/images/D3IN_logo.png') no-repeat center;
    background-size: contain;
    margin-right: 8px;
  }

  .search {
    position: relative;
    height: 44px;
    display: flex;
    align-items: center;
  }

  .search-title {
    width: 100%;
    line-height: 30px;
    height: 30px;
    border: none;
    background: url("../../../assets/images/icon/search.png") no-repeat left top rgba(230, 230, 230, 0.30);
    background-size: contain;
    border-radius: 15px;
    padding-left: 28px;
    padding-right: 8px;
    transition: .3s all ease;
    color: #666;
    font-size: 12px;
  }

  .mail {
    width: 30px;
    height: 44px;
    margin-right: 8px;
    background: url("../../../assets/images/icon/news.png") no-repeat left;
    background-size: contain;
  }

  .list {
    padding: 20px 0;
    width: 310px;
    margin: 0 auto;
  }

  .list li {
    position: relative;
    background: #ffffff;
    float: left;
    width: 90px;
    height: 100px;
    margin-bottom: 20px;
    margin-right: 20px;
    text-align: center;
    font-size: 15px;
  }

  .list li:nth-child(3n) {
    margin-right: 0;
  }

  .list li a {
    height: 100%;
    color: #666;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }

  .list li:hover a {
    color: #BE8914;
  }

  .list i {
    width: 50px;
    height: 50px;
    margin-top: 20px;
    background: url("../../../assets/images/icon/1.png");
    background-size: contain;
  }

  .list i.i01 {
    background: url("../../../assets/images/icon/1.png");
    background-size: contain;
  }

  .list li:hover i.i01 {
    background: url("../../../assets/images/icon/01.png");
    background-size: contain;
  }

  .list i.i02 {
    background: url("../../../assets/images/icon/2.png");
    background-size: contain;
  }

  .list li:hover i.i02 {
    background: url("../../../assets/images/icon/02.png");
    background-size: contain;
  }

  .list i.i03 {
    background: url("../../../assets/images/icon/3.png");
    background-size: contain;
  }

  .list li:hover i.i03 {
    background: url("../../../assets/images/icon/03.png");
    background-size: contain;
  }

  .list i.i04 {
    background: url("../../../assets/images/icon/4.png");
    background-size: contain;
  }

  .list li:hover i.i04 {
    background: url("../../../assets/images/icon/04.png");
    background-size: contain;
  }

  .list i.i05 {
    background: url("../../../assets/images/icon/5.png");
    background-size: contain;
  }

  .list li:hover i.i05 {
    background: url("../../../assets/images/icon/05.png");
    background-size: contain;
  }

  .list i.i06 {
    background: url("../../../assets/images/icon/6.png");
    background-size: contain;
  }

  .list li:hover i.i06 {
    background: url("../../../assets/images/icon/06.png");
    background-size: contain;
  }

  .list i.i07 {
    background: url("../../../assets/images/icon/7.png");
    background-size: contain;
  }

  .list li:hover i.i07 {
    background: url("../../../assets/images/icon/07.png");
    background-size: contain;
  }

  .list li span {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 10px;
    margin: auto;
  }

  @media screen and (max-width: 349px) {
    .list {
      padding-left: 10px;
    }

    .list li {
      margin-right: 10px;
      margin-bottom: 10px;
    }
  }
</style>
