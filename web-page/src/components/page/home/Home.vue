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
      <h3>智能分发系统的三驾马车</h3>
      <p class="item-desc"></p> 
      <div class="item-light">
        <div class="item_list">
          <Row :gutter="24">
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_01.png" />
                <p class="item_title">选品加速器</p>
                <p class="item_desc">催化潜在爆品诞生</p>
                <p class="item_desc">助力已有科技美学品牌风靡市场</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_02.png" />
                <p class="item_title">自营销引擎</p>
                <p class="item_desc">智能匹配图文素材</p>
                <p class="item_desc">打造现象级互动传播</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_03.png" />
                <p class="item_title">精确渠道分发</p>
                <p class="item_desc">校准目标用户画像</p>
                <p class="item_desc">实时监测品牌分发覆盖层级</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    </div>

    <div class="container item">
      <h3>为您提供模块式电商服务</h3>
      <img src="../../../assets/images/home/item_10.jpg" class="img1" />
    </div>

    <div class="item black" style="padding-bottom: 520px;">
      <h3>Fiu·品牌细分需求定制System</h3>
      <p class="item-desc">依托大数据分析决策，围绕“消费场景”以“设计+技术＋商业“三轮驱动，发掘有“创新价值”又不失“感性设计”满足或者引领消费者需求的创新产品和品牌。</p> 

      <div class="item-bg-black">
        <div class="item_list">
          <Row :gutter="24">
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_20.png" />
                <p class="item_title white">产品二次定义</p>
                <p class="item_desc white">专业严谨的产品团队</p>
                <p class="item_desc white">洞察目标用户需求</p>
                <p class="item_desc white">深度切入产品重塑过程</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_21.png" />
                <p class="item_title white">设计元素焕新</p>
                <p class="item_desc white">优化工业设计、包装结构、平面</p>
                <p class="item_desc white">传播语言，让好物真正焕然重生</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_22.png" />
                <p class="item_title white">品牌营销包装</p>
                <p class="item_desc white">一个故事，一张图片，一段文</p>
                <p class="item_desc white">字，有节有度让产品血肉丰满</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    </div>

    <div class="eg">
      <p class="trg">这不是口号，我们已经做了</p>
      <div class="eg-item-list">
        <Row :gutter="0">
          <Col :span="6">
            <div class="e-item e1">
              <img src="../../../assets/images/home/item_30.png" />
              <p class="item_title">孵化项目</p>
              <p class="item_desc">20+</p>
            </div>
          </Col>
          <Col :span="6">
            <div class="e-item e2">
              <img src="../../../assets/images/home/item_31.png" />
              <p class="item_title">总估值</p>
              <p class="item_desc">1500,000,000+</p>
            </div>
          </Col>
          <Col :span="6">
            <div class="e-item e3">
              <img src="../../../assets/images/home/item_32.png" />
              <p class="item_title">签约创新品牌</p>
              <p class="item_desc">200+</p>
            </div>
          </Col>
          <Col :span="6">
            <div class="e-item e4">
              <img src="../../../assets/images/home/item_33.png" />
              <p class="item_title">整合创新SKU</p>
              <p class="item_desc">2000+</p>
            </div>
          </Col>
        </Row>
        <div class="logo_list"></div>
      </div>

    </div>

    <div class="container item">
      <h3>Fiu·原创内容制造Made</h3>
      <p class="item-desc"></p> 
      <div class="item-light">
        <div class="item_list">
          <Row :gutter="24">
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_01.png" />
                <p class="item_title">推广内容</p>
                <p class="item_desc">研究消费者使用场景，</p>
                <p class="item_desc">深入评测使用产品，</p>
                <p class="item_desc">输出图文原创内容以供品牌推广</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_02.png" />
                <p class="item_title">营销升级</p>
                <p class="item_desc">重新设计产品视觉素材，</p>
                <p class="item_desc">高颜值和高性价比吸引消费者</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="">
                <img src="../../../assets/images/home/item_03.png" />
                <p class="item_title">制图APP</p>
                <p class="item_desc">简便的批量制图工具、在优质</p>
                <p class="item_desc">模型上简化同规律分发操作创</p>
                <p class="item_desc">建丰富的底图素材库，</p>
                <p class="item_desc">一键完成内容传播制作</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    </div>

    <div class="item black gc" style="padding-bottom: 60px;">
      <h3>Fiu·渠道分发中控 Controller </h3>
      <p class="item-desc">随着零售渠道日趋分化，以新渠道智能分发为基础、消费升级产品和优质内容为核心,助力智能硬件与创新产品市场变现。</p> 

      <div class="item-bg-black">
        <div class="item_list">
          <Row :gutter="24">
            <Col :span="12">
              <div class="l-item" style="margin-right: -100px;">
                <img src="../../../assets/images/home/item_60.png" />
                <p class="item_desc white">高品质的科技美学创新产品集群</p>
                <p class="item_desc white">正比例提升分发效率与品质</p>
              </div>
            </Col>
            <Col :span="12">
              <div class="l-item" style="margin-left: -100px;">
                <img src="../../../assets/images/home/item_61.png" />
                <p class="item_desc white">原创图文素材库，高效广告制作</p>
                <p class="item_desc white">模具汇总高品质图文素材，传播</p>
                <p class="item_desc white">者可自由下载或使用移动端海报</p>
                <p class="item_desc white">生成器升级传播效应</p>
              </div>
            </Col>
          </Row>
          <div class="blank40"></div>
          <Row :gutter="24">
            <Col :span="12">
              <div class="l-item" style="margin-right: -100px;">
                <img src="../../../assets/images/home/item_62.png" />
                <p class="item_desc white">实时监测用户画像及品牌覆盖度</p>
                <p class="item_desc white">依据SaaS平台大数据动态，为</p>
                <p class="item_desc white">渠道提供精准产品和内容服务</p>
              </div>
            </Col>
            <Col :span="12">
              <div class="l-item" style="margin-left: -100px;">
                <img src="../../../assets/images/home/item_63.png" />
                <p class="item_desc white">新渠道合作500+，已覆盖头部</p>
                <p class="item_desc white">品质电商及自媒体，已实现全渠</p>
                <p class="item_desc white">道智能分发3亿销售</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>
    </div>

    <div class="container item">
      <h3>新媒体</h3>
      <div class="logo_list_new"></div>
    </div>

    <div class="container item">
      <h3>服务平台</h3>
      <div class="logo_server">
        <img src="../../../assets/images/logo/no.png" />
        <img src="../../../assets/images/logo/xinbang.png" />
        <img src="../../../assets/images/logo/youzan.png" />
      </div>
    </div>

    <div class="container item">
      <h3>品质电商</h3>
      <div class="logo_quant">
        <img src="../../../assets/images/logo/mijia.png" />
        <img src="../../../assets/images/logo/mjyp.png" />
        <img src="../../../assets/images/logo/jdjr.png" />  
        <img src="../../../assets/images/logo/wyyx.png" />
        <img src="../../../assets/images/logo/wyzz.png" />
        <img src="../../../assets/images/logo/meitu.png" /> 
      </div>
    </div>

    <div class="item black ac" style="padding-bottom: 60px;">
      <h3>爆款运营案例 </h3>
      <p class="item-desc">运营服务精细化与智能化，渠道分发与内容产出同步操作。依据产品定位智能分发至各级自媒体及平台主流大号提升曝光率，小众垂直账号跟进转化因“品”制宜，创造视频、图片、文案等传播素材优化配给京东众筹、米家有品、一条、小红书等电商平台资源无上限降低运营成本和内容生产成本实现收益转化与产品口碑指数级增长</p> 

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

    <div class="container item">
      <h3>合作资源方</h3>
      <div class="logo_list_zy"></div>
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
            'title': '太火鸟 科技美学创新产品智能分发平台',
            'desc': '科技与生活创新品牌发源地,  自媒体和精品电商选品基站渠道分发精准配比内容输出,  你在发现，谁在惊呼？！',
            'image': require('@/assets/images/home/banner.jpg')
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
    margin: 80px auto 60px auto;
  }

  .item h3 {
    padding-bottom: 10px;
    font-size: 4.2rem;
    line-height: 2;
  }
  .item.black {
    background-image: url(../../../assets/images/home/bg_black.jpg);
    background-size: cover;
    padding: 60px 0 0 0;
    color: #fff;
  }
  .item.black.gc {
    background-image: url(../../../assets/images/home/bg_gc.jpg);
  }
  .item.black.ac {
    background-image: url(../../../assets/images/home/bg_ac.jpg);
  }

  .item .item-desc {
    font-size: 2rem;
    line-height: 1.5;
    font-weight: 400;
    padding: 20px 280px 60px 280px;
  }

  .img1 {
    margin-top: 100px;
    width: 90%;
  }

  .item_list {
    margin: 0 1%;
  }
  .item_list div {
  }
  .item_list img {
    width: 30%;
  }
  .item_list p {
  }

  .item_title {
    color: #222;
    font-size: 3rem;
    margin-top: 10px;
    margin-bottom: 10px;
    line-height: 2;
  }
  .item_desc {
    color: #666;
    font-size: 2rem;
    margin-top: 10px;
    margin-bottom: 10px;
    line-height: 1.1;
  }

  .white {
    color: #fff;
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

  .eg {
    margin: -460px auto 40px auto;
  }
  .eg .trg {
    font-size: 3rem;
    color: #E6CF9B;
    text-align: center;
  }

  .eg-item-list {
    text-align: center;
    margin: 40px auto 0 auto;
    width: 85%;
  }
  .eg-item-list .e-item {
    padding: 80px 0;
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
  .e-item .item_desc {
    color: #E6CF9B;
    font-size: 4rem;
    margin-top: 10px;
    margin-bottom: 10px;
    line-height: 1.5;
  }
  .logo_list {
    height: 200px;
    margin-top: 30px;
    background-image: url(../../../assets/images/home/item_40.png);
    background-repeat: no-repeat;
    background-size: contain; 
  }
  .logo_list_new {
    height: 320px;
    margin-top: 20px;
    background-image: url(../../../assets/images/home/logo_list1.png);
    background-repeat: no-repeat;
    background-size: contain; 
  }
  .logo_list_zy {
    height: 210px;
    margin-top: 10px;
    background-image: url(../../../assets/images/home/logo_zy.png);
    background-repeat: no-repeat;
    background-size: contain; 
  }
  .e-item.e1 {
    background-image: url(../../../assets/images/home/bg_1.jpg);
    background-size: cover;
  }
  .e-item.e2 {
    background-image: url(../../../assets/images/home/bg_2.jpg);
    background-size: cover;
  }
  .e-item.e3 {
    background-image: url(../../../assets/images/home/bg_3.jpg);
    background-size: cover;
  }
  .e-item.e4 {
    background-image: url(../../../assets/images/home/bg_4.jpg);
    background-size: cover;
  }

  .item-bg-black .l-item {
  }
  .item-bg-black .l-item img {
    width: 15%;
    padding-bottom: 30px;
  }

  .logo_server {
  
  }
  .logo_server img {
    margin: 10px 65px;
    width: 10%;
  }

  .logo_quant {
  
  }
  .logo_quant img {
    margin: 10px 25px;
    width: 10%;
  }

</style>
