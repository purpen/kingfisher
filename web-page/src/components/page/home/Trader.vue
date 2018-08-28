<template>
  <div class="hello">
    <div class="banner">
      <h3>Fiu·渠道</h3>
      <p>在零售渠道日趋分化的大趋势下, 以新型渠道智能分发为基础、以消费升级科技创新产品和创造优质内容为核心, 极大助力智能硬件和创新产品推向市场进行变现。 </p>
      <Button type="ghost" class="is-custom" v-if="!isLogin" @click="loginBtn">立即注册</Button>
    </div>

    <div class="container item">
      <div class="item_list">
        <Row :gutter="24">
          <Col :span="12">
            <div class="">
              <img src="../../../assets/images/home/item_70.png" />
              <p class="item_title">新渠道合作</p>
              <p class="item_desc">500+</p>
            </div>
          </Col>
          <Col :span="12">
            <div class="">
              <img src="../../../assets/images/home/item_71.png" />
              <p class="item_title">已覆盖头部品质电商及自媒体，全渠道智能分发销售</p>
              <p class="item_desc">300,000,000</p>
            </div>
          </Col>
        </Row>
      </div>

    </div>

    <div class="item gray">
      <div class="container">
        <h3> More Information</h3>
        <div class="logo_list_new"></div>
        <p>合作通道 邮箱：products@taihuoniao.com</p>
      </div>
    </div>

    <div class="container item">
      <Row :gutter="24">
        <Col :span="12">
          <div class="item-img t-l">
            <img src="../../../assets/images/home/item_80.png" />
          </div>
        </Col>
        <Col :span="12">
          <div class="item-content" style="margin-left: 15%;margin-top: 10%;">
            <h3>高品质的科技美学</h3>
            <div class="blank10"></div>
            <p>创新产品集群</p>
            <p>正比例提升分发效率与品质</p>
          </div>
        </Col>
      </Row>
    </div>

    <div class="item gray">
      <div class="container">
        <Row :gutter="24">
          <Col :span="12">
            <div class="item-content">
              <h3>原创图文素材库</h3>
              <h3>高效广告制作模具</h3>
              <div class="blank10"></div>
              <p>汇总高品质图文素材，传播者可自由下载或使</p>
              <p>用移动端海报生成器升级传播效应</p>
            </div>
          </Col>
          <Col :span="12">
            <div class="item-img">
              <img src="../../../assets/images/home/item_82.png" />
            </div>
          </Col>
        </Row>
      </div>
    </div>

    <div class="container item">
      <Row :gutter="24">
        <Col :span="12">
          <div class="item-img t-l">
            <img src="../../../assets/images/home/item_81.png" />
          </div>
        </Col>
        <Col :span="12">
          <div class="item-content" style="margin-left: 20%">
            <h3>实时监测用户画像</h3>
            <h3>及品牌覆盖度</h3>
            <div class="blank10"></div>
            <p>依据SaaS平台大数据动态</p>
            <p>为渠道提供精准产品和内容服务</p>
          </div>
        </Col>
      </Row>
    </div>

    <div class="item black">
      <h3>渠道案例</h3>
      <p>运营精细化与智能化，内容产出成本极大降低，收益与口碑成指数级增长</p>
      <div class="container card_list">
        <Row :gutter="10">
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/sushi.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">素士声波电动牙刷</h3>
                <div class="des">
                  <p>自媒体销售额<span>1200万</span></p>
                  <p>种子期投资孵化项目，资本助力创业团队搭建和产品开发升级头部大号攻城掠地、中腰和底部社群全网覆盖战略，已有100＋合作自媒体，助力全渠道分发</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/mjyp.png" />
                  <img src="../../../assets/images/logo/small/yitiao.png" />
                  <img src="../../../assets/images/logo/small/sjds.png" />
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/swdk.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">洒哇地咔智能拖地机器人</h3>
                <div class="des">
                  <p>单周销量<span>1500台</span></p>
                  <p>重新设计产品图片、输出原创内容，提升品牌格调和销售转化新品开发，重新设计产品外观和功能体验</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/yitiao.png" />
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/hzj.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">AMIRO LUX明肌高清化妆镜</h3>
                <div class="des">
                  <p>限量600套，众筹<span>售罄</span></p>
                  <p>种子期孵化项目，资本助力团队搭建和产品开发做“美”的生意，100w＋营销曝光</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/yitiao.png" />
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/zrzw.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">自然造物端午龙粽</h3>
                <div class="des">
                  <p>重新定义端午粽，传承中国文化节，限量10000个粽子一周<span>售罄</span></p>
                  <p>头部大号和精准自媒体攻城战略，极大推动销售变现原创内容多样化传播，特征化、个性化凸显，引爆连锁传播效应</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/wxb.png" />
                </div>
              </div>
            </Card>
          </Col>
        </Row>
        <div class="blank10"></div>
        <Row :gutter="10">
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/lsd.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">wowstick电动螺丝刀</h3>
                <div class="des">
                  <p>众筹限量<span>10000台</span>，24小时售罄众筹结束后，5个月销售额约<span>800万</span></p>
                  <p>线上总代理品牌，联合定义产品开发打造成家庭工具创新品类领先品牌，连续4代产品众筹火爆推出</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/mjyp.png" />
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/wwy.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">吻吻鱼cc杯</h3>
                <div class="des">
                  <p>众筹筹款<span>2173060元</span> 12140人支持</p>
                  <p>种子期孵化项目，资本助力团队搭建和产品开发从产品众筹到销售通路开拓，高效助力品牌发展高效输出产品图片...</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/mjyp.png" />
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/yunma.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">云马mini智能折叠电单车</h3>
                <div class="des">
                  <p>众筹筹款<span>5764268元</span></p>
                  <p>种子期孵化项目，资本助力团队搭建和产品开发。众筹营销全案，站内、站外推广策略。大咖代言，精细化运营，渠道开拓</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/jdjr.png" style="width: 90px;" />
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="6">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/kjzw.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">看见造物</h3>
                <div class="des">
                  <p>在京东众筹发起“民艺复兴, 看见初心”行动, 联合189位名人、明星为手艺人代颜</p>
                  <p>众筹营销全案，站内、站外精准推广策略。营销素材设计和原创内容输出</p>
                </div>
                <div class="card-logo">
                  <img src="../../../assets/images/logo/small/jdjr.png" style="width: 90px;" />
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
  name: 'supplier',
  data () {
    return {
      msg: '品牌'
    }
  },
  computed: {
    isLogin () {
      return this.$store.state.event.token
    }
  },
  methods: {
    // 登录注册
    loginBtn () {
      this.$router.push({name: 'register'})
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .banner {
    height: 650px;
    background: url('../../../assets/images/home/banner20.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    text-align: center;
  }

  .banner h3 {
    font-size: 3.6rem;
    color: #E3CE9B;
    line-height: 1.5;
    font-weight: 300;
    padding: 80px 0 15px 0;
  }
  .banner p {
    font-size: 2.4rem;
    color: #D8D8D8;
    font-weight: 300;
    padding: 0 19%;
  }

  .banner .ivu-btn {
    padding: 5px 50px;
    margin: 20px;
    font-size: 2rem;
  }

  .item {
    text-align: center;
    margin: 50px auto 20px auto;
    padding: 40px 0;
  }
  .item h3 {
    color: #222;
    font-size: 3rem;
  }

  .item_list {
    margin: 20px 0 0 0;
  }
  .item .item_title {
    font-size: 1.8rem;
  }
  .item .item_desc {
    font-size: 4rem;
  }

  .item .item_list p {
    color: #222;
    line-height: 2;
  }

  .item_list img {
    width: 25%;
    margin-bottom: 20px;
  }

  .item.gray {
    background: #FAFAFA;
    padding: 60px 0;
  }
  .item.gray h3 {
    color: #666;
  }
  .item.gray p {
    color: #666;
    font-size: 1.8rem;
  }

  .item.black {
    background: #303137;
    padding: 60px 0;
  }
  .item.black h3 {
    color: #fff;
  }
  .item.black p {
    color: #fff;
    font-size: 2rem;
    margin: 40px 0;
  }

  .logo_list_new {
    height: 320px;
    margin-top: 20px;
    background-image: url(../../../assets/images/home/logo_list1.png);
    background-repeat: no-repeat;
    background-size: contain;
  }

  .item .item-img img {
    width: 70%;
  }
  .item .item-content {
    text-align: left;
  }
  .item .item-content h3 {
    font-size: 4.2rem;
    color: #222;
  }
  .item .item-content p {
    font-size: 2rem;
    color: #666;
  }

  .tag-list {
    margin: 20px 0;
  }
  .tag-list p span {
    float: left;
    display: block;
    color: #BE8914;
    width: 110px;
    text-align: center;
    border: 1px solid #BE8914;
    border-radius: 6px;
    font-size: 1.6rem;
    padding: 5px 0;
    margin: 5px 5px;
  }

  .t-l {
    text-align: left;
  }
  .t-r {
    text-align: right;
  }

  .card_list {
    text-align: left;
  }

  .card_list .image-box {
    height: 250px;
    overflow: hidden;
  }
  .card_list .image-box img {
    width: 100%;
  }

  .card_list .content {
    padding: 5px 10px;
  }
  .card_list .content h3 {
    color: #222;
    font-size: 1.8rem;
    padding: 0;
  }

  .card_list .des {
    height: 130px;
    margin: 5px 0;
    overflow: hidden;
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

  .card-logo {
    height: 45px;
  }
  .card-logo img {
    width: 45px;
  }
</style>
