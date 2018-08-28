<template>
  <div>
    <div class="banner">
      <Carousel autoplay v-model="slider.index" height="auto">
        <Carousel-item v-for="(d, index) in slider.data" :key="index">
          <div class="slide">
            <img class="wid_100" :src="d.image" alt="">
          </div>
        </Carousel-item>
      </Carousel>
    </div>
    <div class="container item">
      <h3>新零售行业解决方案</h3>
      <p class="item-desc"></p>
      <div class="item-light">
        <div class="item_list">
          <Row :gutter="24">
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/icons/icons1.png" />
                <p class="item_title font-16">对接供应链资源,线上线下流量交互,共享库存。</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/icons/icons2.png" />
                <p class="item_title font-16">提供从选址/装修/备货/开店/运营的一站式规范化标准辅导和统一培训,提供更多业态经营方式,为门店落地保驾护航。</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/icons/icons3.png" />
                <p class="item_title font-16">通过线上线下的联动,
                  收集精准数据,指导运
                  营,利用互联网新零售
                  行业解决方案快速积
                  累会员,实现粉丝裂变
                  销售。</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    </div>
    <div class="About">
      <img class="wid_100" src="../../../assets/images/home/banner/banner02.png" alt="">
    </div>
    <div class="item">
      <h3>媒体报道</h3>
      <div class="padd-233">
        <Row :gutter="100">
          <Col :span="12">
            <div class="">
              <img class="wid_100 margin-b-30" src="../../../assets/images/home/banner/banner03.jpg" alt="">
              <p class="side_left_title text-left slid_left_p_title color_495_1 margin-b-20 font-20 lin-clamp-2">D3IN铟立方未来商店这家开在世界级硅谷的神奇店铺终于来啦!</p>
              <p class="side_left_desc text-left font-14 color_495_08 lin-clamp-3">2017年3月4日，太火鸟产品创新及智能分发平台旗下“D3IN 铟立方未来商
                店”正式开业，太火鸟创始人雷海波、太火鸟联合创始人田孝义、太火鸟联合
                创始人朱红、太火鸟联合创始人崔波、太火鸟联合创始人范亚斌、太火鸟联合创始人舒戈出席开幕启动仪式。</p>
            </div>
          </Col>
          <Col :span="12">
            <div class="text-left">
              <ul>
                <li>
                  <p class="font-20 color_495_1 margin-b-30 lin-clamp-2">京城五美空降铟立方未来商店，引爆科技男摄影热情爆科技男摄影热情爆科技男摄影热情爆科技男摄影热情。</p>
                  <p class="font-14 color_495_08 margin-b-40 lin-clamp-3">如果你是一个摄影爱好者，对于约拍这个词语应该不会陌生。想
                    当年，多少身为摄影小白的男生突然迷起了昂贵的摄影器材，喜
                    欢拍照最初可不是因为爱好，而是因为有了相机可以和漂亮姑娘
                    有更多的接触机会。</p>
                </li><li>
                  <p class="font-20 color_495_1 margin-b-30 lin-clamp-2">京城五美空降铟立方未来商店，引爆科技男摄影热情。</p>
                  <p class="font-14-22 color_495_08 margin-b-40 lin-clamp-3">如果你是一个摄影爱好者，对于约拍这个词语应该不会陌生。想
                    当年，多少身为摄影小白的男生突然迷起了昂贵的摄影器材，喜
                    欢拍照最初可不是因为爱好，而是因为有了相机可以和漂亮姑娘
                    有更多的接触机会。</p>
                </li><li>
                  <p class="font-20 color_495_1 margin-b-30 lin-clamp-2">京城五美空降铟立方未来商店，引爆科技男摄影热情。</p>
                  <p class="font-14 color_495_08 lin-clamp-3">如果你是一个摄影爱好者，对于约拍这个词语应该不会陌生。想
                    当年，多少身为摄影小白的男生突然迷起了昂贵的摄影器材，喜
                    欢拍照最初可不是因为爱好，而是因为有了相机可以和漂亮姑娘
                    有更多的接触机会。</p>
                </li>
              </ul>
            </div>
          </Col>
        </Row>
      </div>
    </div>

    <div class="container item">
      <h3>合作伙伴</h3>
      <div class="logo_list_new"></div>
    </div>

    <div class="item">
      <div class="intention">
        <Row :gutter="75">
          <Col :span="8">
            <div class="tel">
              <div class="fl">
                <img src="../../../assets/images/home/icons/icons-tel.png" class="wid-26">
              </div>
              <div class="fl margin-l-20 text-left">
                <p class="font-16 color_fff">免费服务热线</p>
                <p class="font-16 color_fff">400-757-8666</p>
              </div>
              <!--<div class="clear"></div>-->
            </div>
          </Col>
          <Col :span="8">
            <div class="tel">
              <div class="fl">
                <img src="../../../assets/images/home/icons/icons-shop.png" class="wid-26">
              </div>
              <div class="fl margin-l-20 text-left">
                <p class="font-16 color_fff">SUPPLIER APPLICATION</p>
                <p class="font-16 color_fff">商场入驻申请</p>
              </div>
              <!--<div class="clear"></div>-->
            </div>
          </Col>
          <Col :span="8">
            <div class="tel">
              <div class="fl">
                <img src="../../../assets/images/home/icons/icons-store.png" class="wid-26">
              </div>
              <div class="fl margin-l-20 text-left">
                <p class="font-16 color_fff">STORE APPLICATION</p>
                <p class="font-16 color_fff">门店申请加盟</p>
              </div>
              <!--<div class="clear"></div>-->
            </div>
          </Col>
        </Row>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'hello',
  data () {
    return {
      slider: {
        index: 0,
        data: [
          {
            'clickUrl': '#',
            'image': require('@/assets/images/home/banner/banner01.png')
          }
        ]
      },
      msg: 'Welcome to Saas'
    }
  },
  methods: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .banner {
    width: 100%;
    margin: 0 0 40px 0;
  }

  .slide {
    font-size: 18px;
    height: 650px;
    background-size: cover;
    background-repeat: no-repeat;
    text-align: center;
  }

  .slide h3 {
    font-size: 3.6rem;
    color: #E3CE9B;
    line-height: 1.5;
    font-weight: 300;
    padding: 80px 0 15px 0;
  }
  .slide p {
    font-size: 2.4rem;
    color: #D8D8D8;
    font-weight: 300;
    padding: 0 380px;
  }


  .item {
    text-align: center;
    margin: 94px auto 0 auto;
  }

  .item h3 {
    padding-bottom: 10px;
    font-size: 2.4rem;
    line-height: 2;
  }

  .padd-233 {
    padding: 45px 12% 0 12%;
  }

  .item .item-desc {
    font-size: 2rem;
    line-height: 1.5;
    font-weight: 400;
    padding: 20px 280px 60px 280px;
  }

  .item_list {
    margin: 0 1%;
  }
  .item_list div {
  }
  .item_list img {
    width: 13%;
  }
  .item_list p {
  }

  .item_title {
    color: #49505F;
    margin-top: 50px;
    margin-bottom: 10px;
    padding: 0 50px;
    text-align: left;
  }

  .card_list .image-box img {
    width: 100%;
  }

  .card_list .content h3 {
    color: #222;
    font-size: 1.8rem;
    padding: 0;
  }


  .card_list .des p {
    color: #666;
    font-size: 1.4rem;
    line-height: 1.5;
    margin: 5px 0;
    text-overflow: ellipsis;
  }
  .card_list .des p span {
    color: #BE8914;
    font-size: 2rem;
  }

  .eg-item-list .e-item img {
    width: 30%;
  }
  .e-item .item_title {
    color: #E6CF9B;
    font-size: 1.8rem;
    margin-top: 10px;
    margin-bottom: 10px;
    line-height: 2;
  }
  .logo_list_new {
    height: 320px;
    margin-top: 20px;
    background-image: url(../../../assets/images/home/logo_list1.png);
    background-repeat: no-repeat;
    background-size: cover;
  }

  .item-bg-black .l-item img {
    width: 15%;
    padding-bottom: 30px;
  }

  .logo_server img {
    margin: 10px 65px;
    width: 10%;
  }

  .logo_quant img {
    margin: 10px 25px;
    width: 10%;
  }

  /*//////*/
  .intention {
    background: #ED3A4A;
    padding: 38px 15%;
  }

  .tel {
    overflow: hidden;
    border-radius: 6px;
    padding: 9px 0 13px 14px;
    border: 1px solid #ffffff;
    display: flex;
    align-items: center;
  }

  .item-light {
    padding: 0 120px 90px 120px;
  }

  .lin-clamp-2 {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
  }

  .lin-clamp-3 {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
  }

  .wid-26 {
    width: 26px;
  }

</style>
