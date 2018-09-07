<template>
    <div class="container">
        <div class="sweep">
          <div class="display-flex-algin margin-b-40">
            <span class="font-20 color_333">支付宝支付</span>
            <span class="margin-l-35 font-14 color_666">距离二维码过期还剩 <i class="color_ed3a">100</i><i class="color_ed3a">秒</i> ，过期后请刷新页面重新获取二维码。</span>
          </div>
          <div class="wid-300">
            <div class="text-center">
              <img class="sweep_img" src="../../../../assets/images/home/banner.jpg" alt="">
            </div>
            <div class="display-flex-algin padding-l-25 border-200 margin-t-15 prompt_sweep">
              <img src="../../../../assets/images/icon/icon50.png" alt="">
              <div class="margin-l-25">
                <p>请使用支付宝扫一扫</p>
                <p>扫码二维码支付</p>
              </div>
            </div>
          </div>
          <div class="pay_success">
            <div class="text-center wid-70">
              <img src="../../../../assets/images/icon/icon46.png" style="width: 70px" alt="">
            </div>
            <div class="text-center">
              <p class="font-20 color_666 margin-b-35 margin-t-25">恭喜您已支付成功!</p>
              <p class="font-14 color_666">5s后系统将自动跳转，如未跳转请点击! <router-link to="name" class="color_ed3a">立即进入</router-link> </p>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
  export default {
    data () {
      return {}
    },
    methods: {},
    created () {

    },
    components: {}
  }
</script>

<style scoped>
  .sweep {
    padding: 30px 50px;
  }

  .wid-300 {
    width: 300px;
    margin: 0 auto;
  }

  .border-200 {
    border: 1px solid rgba(200,200,200,1);
  }
  .padding-l-25 {
    padding-left: 25px;
  }

  .prompt_sweep {
    padding: 20px 0 25px 25px;
  }

  .sweep_img {
    width: 100%;
    height: 300px;
  }

  .wid-70 {
    padding-top: 155px;
    margin: 0 auto;
    width: 70px;
  }
</style>
