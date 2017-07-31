<template>
  <div>
    <div class="banner">
      <Carousel autoplay v-model="slider.index" height="auto">
          <Carousel-item v-for="(d, index) in slider.data" :key="index">
              <div class="slide" :style="{ 'background-image': 'url(' + d.image + ')'}">
                <h3>{{ d.title }}</h3>
                <p>{{ d.desc }}</p>
              </div>
          </Carousel-item>
      </Carousel>
    </div>

    <div class="container item">
      <h3>太火鸟+智能分发</h3>
      <p class="item-desc">提供一流的产品技术，数据分析，传播策略，电商运营和品牌供应链服务，帮助自媒体实现高效的商业闭环。</p> 
      <div class="item-light">
        <div class="item_list">
          <Row :gutter="24">
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/server_10.png" />
                <p class="item_title">专业的内容电商服务</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/server_11.png" />
                <p class="item_title">先进的数据技术系统</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/index_05.png" />
                <p class="item_title">高效便利的创作平台</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    </div>

    <div class="container item">
      <h3>合作案例</h3>
      <p class="item-desc">运营精细化与智能化，内容产出成本极大降低，收益与口碑呈指数级增长</p> 
      <div class="card_list">
        <Row :gutter="24">
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <a href="#">
                  <img src="http://oni525j96.bkt.clouddn.com/saas/20170626/5950d8725b005-p450x255" />
                </a>
              </div>
              <div class="content">
                <a href="#">一套基于 Vue.js 的高质量UI组件库</a>
                <div class="des">
                  <p>根据“一条”公众号自身的定位，为其专门匹配了国外小众商品，帮助提高整体转化率，同时也提升了整体品牌调性。</p>
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <a href="#">
                  <img src="http://oni525j96.bkt.clouddn.com/saas/20170710/596328558eb77-p450x255" />
                </a>
              </div>
              <div class="content">
                <a href="#">一套基于 Vue.js 的高质量UI组件库</a>
                <div class="des">
                  <p>根据“一条”公众号自身的定位，为其专门匹配了国外小众商品，帮助提高整体转化率，同时也提升了整体品牌调性。</p>
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <a href="#">
                  <img src="http://oni525j96.bkt.clouddn.com/saas/20170424/58fd6cd5728d9-p450x255" />
                </a>
              </div>
              <div class="content">
                <a href="#">这是新的内容</a>
                <div class="des">
                  <p>刚才已经试验了以下，先build项目，npm run build，然后把dist目录发布到nginx目录下就刚才已经试验了以下，先build项目，npm run </p>
                </div>
              </div>
            </Card>
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
            'title': '太火鸟SaaS智能分发平台',
            'desc': '用设计重塑品质生活',
            'image': require('@/assets/images/home/banner1.jpg')
          },
          {
            'clickUrl': '#',
            'title': '太火鸟SaaS智能分发平台',
            'desc': '汇聚100+国内专业设计服务商，满足你的创意需求',
            'image': require('@/assets/images/home/banner2.jpg')
          }
        ]
      },
      msg: 'Welcome to Saas'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .banner {
    margin: 0 0 40px 0;
  }

  .slide {
    font-size: 18px;
    line-height: 60px;
    height: 450px;
    background-size: cover;
    background-repeat: no-repeat;
    text-align: center;
  }

  .slide h3 {
    font-size: 5rem;
    color: #fff;
    line-height: 1.5;
    font-weight: 300;
    padding: 150px 0 0 0;
  }
  .slide p {
    font-size: 4rem;
    color: #fff;
    font-weight: 300;
    padding: 0;
  }


  .item {
    text-align: center;
    margin: 0 auto 80px auto;
  }

  .item h3 {
    padding-bottom: 10px;
    font-size: 4rem;
    line-height: 2;
    font-weight: 300;
  }
  .item .item-desc {
    font-size: 2rem;
    line-height: 1.5;
    font-weight: 400;
    padding: 0 200px 60px 200px;
  }

  .item_list {
    margin: 0 1%;
  }
  .item_list div {
  }
  .item_list img {
    width: 40%;
  }
  .item_list p {
  }

  .item_title {
    color: #222;
    font-size: 2rem;
    margin-top: 10px;
    margin-bottom: 10px;
    line-height: 2;
  }

  .card_list {
    text-align: left;
  }

  .card_list .image-box {
    height: 220px;
    overflow: hidden;
  }

  .card_list .content {
    padding: 10px;
  }
  .card_list .content a {
    font-size: 1.5rem;
  }

  .card_list .des {
    height: 30px;
    margin: 10px 0;
    overflow: hidden;
  }

  .card_list .des p {
    color: #666;
    font-size: 1.2rem;
    line-height: 1.3;
    text-overflow: ellipsis;
  }

</style>
