<template>
  <div v-if="!hideHeader">
    <div class="footer clear">
      <Row>
        <ul class="float-ul">
          <Col :xs="24" :sm="12" :md="6" :lg="6">
            <li>
              <p class="font-16 mar-b-26">铟立方</p>
              <div class="child-span">
                <span>关于我们</span>
                <span>联系我们</span>
              </div>
            </li>
          </Col>
          <Col :xs="24" :sm="12" :md="6" :lg="6">
            <li>
              <p class="font-16 mar-b-26">服务</p>
              <div class="child-span">
                <span>申请加入</span>
              </div>
            </li>
          </Col>
          <Col :xs="24" :sm="12" :md="6" :lg="6">
            <li>
              <p class="font-16 mar-b-26">帮助</p>
              <div class="child-span">
                <span>常见问题</span>
                <span>服务条款</span>
              </div>
            </li>
          </Col>
          <Col :xs="24" :sm="12" :md="6" :lg="6">
            <li>
              <p class="font-16 mar-b-26 child-span">关于我们</p>
              <p><img class="wid-35" src="../../assets/images/icon/pic-weixin.png" alt=""></p>
              <div class="display-flex-ju-center">
                <div class="margin-r-10"><img src="../../assets/images/icon/icon-tel.png" alt=""></div>
                <div>
                  <p>客服热线:</p>
                  <p class="font-16">400-757-8666</p>
                </div>
              </div>
            </li>
          </Col>

        </ul>
      </Row>
      <div class="Copyright">
        <p class="font-12">Copyright©️ 2018 www.d3ingo.com 版权所有.All rights reserved.</p>
        <p class="font-12">太火鸟 营业执照［京ICP备14025430号－2］经营许可证：［京ICP证150139号]</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Fiufooter',
  props: {
    currentName: {
      default: ''
    }
  },
  data () {
    return {
      msg: ''
    }
  },
  computed: {
    // 平台来源
    platform () {
      var n = this.$store.state.event.platform
      return n
    },
    // 是否隐藏头部
    hideHeader () {
      return this.$store.state.event.indexConf.hideHeader
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .footer {
    background: rgb(51, 51, 51);
    padding: 0 97px 12px 97px;
    border-top: 1px solid #000;
  }

  .mar-b-26 {
    margin-bottom: 26px;
    color: #DDDDDD;
    margin-top: 20px;
    font-size: 16px;
  }

  .child-span span {
    display: block;
    margin-bottom: 16px;
    font-size: 12px;
    color: rgb(153, 153, 153);
    cursor: pointer;
  }

  .Copyright {
    border-top: 1px solid rgba(51,51,51,1);
  }
  .Copyright p {
    margin: 0;
    color: rgb(153, 153, 153);
  }

  .wid-35 {
    width: 35px;
  }
  .display-flex-ju-center p {
    color: rgb(153, 153, 153);
    margin: 0;
    text-align: left;
  }
</style>
