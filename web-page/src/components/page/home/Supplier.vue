<template>
  <div class="hello">
    <div class="banner">
      <h3>Fiu·品牌</h3>
      <p>依托大数据分析决策，围绕“消费场景”以“设计+技术＋商业“三轮驱动，发掘有“创新价值”又不失“感性设计”满足或者引领消费者需求的创新产品和品牌。 </p>
    </div>

    <div class="container item">
      <h3>这不只是口号，我们已经做了</h3>
      <div class="item_list">
        <Row :gutter="24">
          <Col :span="6">
            <div class="">
              <img src="../../../assets/images/home/item_30_1.png" />
              <p class="item_title">孵化项目</p>
              <p class="item_desc">20+</p>
            </div>
          </Col>
          <Col :span="6">
            <div class="">
              <img src="../../../assets/images/home/item_31_1.png" />
              <p class="item_title">总估值</p>
              <p class="item_desc">1500,000,000+</p>
            </div>
          </Col>
          <Col :span="6">
            <div class="">
              <img src="../../../assets/images/home/item_32_1.png" />
              <p class="item_title">签约创新品牌</p>
              <p class="item_desc">200+</p>
            </div>
          </Col>
          <Col :span="6">
            <div class="">
              <img src="../../../assets/images/home/item_33_1.png" />
              <p class="item_title">整合创新SKU</p>
              <p class="item_desc">2000+</p>
            </div>
          </Col>
        </Row>
      </div>
      
    </div>

    <div class="item gray">
      <div class="container">
        <h3> More Information</h3>
        <div class="logo_list"></div>
        <p>合作通道 发送产品资料至邮箱：products@taihuoniao.com</p>
      </div>
    </div>

    <div class="container item">
      <Row :gutter="24">
        <Col :span="12">
          <div class="item-img t-l">
            <img src="../../../assets/images/home/item_10.png" />
          </div>
        </Col>
        <Col :span="12">
          <div class="item-content" style="margin-left: 15%">
            <h3>产品二次定义</h3>
            <p>专业严谨的产品团队，洞察目标用户需求，</p>
            <p>深度切入产品重塑过程</p>
            <div class="tag-list">
              <p>
                <span>资本助力</span>
                <span>行业数据支持</span>
                <span>消费人群定位</span>
                <span>市场分析</span>
              </p>
              <p>
                <span>品类研究</span>
                <span>工业设计</span>
                <span>价格测算</span>
                <span>渠道定位</span>
              </p>
            </div>
          </div>
        </Col>
      </Row>
    </div>

    <div class="item gray">
      <div class="container">
        <Row :gutter="24">
          <Col :span="12">
            <div class="item-content">
              <h3>设计元素焕新</h3>
              <p>优化工业设计、包装结构、平面传播语言，</p>
              <p>让好物真正焕然重生</p>
              <div class="tag-list">
                <p>
                  <span>消费人群定位</span>
                  <span>使用需求确立</span>
                  <span>包装结构研究</span>
                </p>
                <p>
                  <span>外观视觉设计</span>
                  <span>产品内容输出</span>
                </p>

              </div>
            </div>
          </Col>
          <Col :span="12">
            <div class="item-img">
              <img src="../../../assets/images/home/item_11.png" />
            </div>
          </Col>
        </Row>
      </div>
    </div>

    <div class="container item">
      <Row :gutter="24">
        <Col :span="12">
          <div class="item-img t-l">
            <img src="../../../assets/images/home/item_10.png" />
          </div>
        </Col>
        <Col :span="12">
          <div class="item-content" style="margin-left: 20%">
            <h3>品牌营销包装</h3>
            <p>一个故事，一张图片，一段文字，</p>
            <p>有节有度让产品血肉丰满</p>
            <div class="tag-list">
              <p>
                <span>品牌故事挖掘</span>
                <span>营销立项</span>
                <span>视觉输出</span>
              </p>
              <p>
                <span>原创内容</span>
                <span>精准推广路径</span>
              </p>
            </div>
          </div>
        </Col>
      </Row>
    </div>

    <div class="item black">
      <h3>品牌案例</h3>
      <div class="container card_list">

        <Row :gutter="20">
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/sushi_1.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">素士 Soocare</h3>
                <div class="des">
                  <p>种子期孵化项目，资本助力团队搭建和产品开发</p>
                  <p>原创内容输出，营销推广包装</p>
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/mzj_1.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">美妆镜 Amiro</h3>
                <div class="des">
                  <p>种子期孵化项目，资本助力团队搭建和产品开发</p>
                  <p>原创内容输出，营销推广包装</p>
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/lsd_1.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">螺丝刀 wowstick</h3>
                <div class="des">
                  <p>线上总代理品牌，联合定义产品</p>
                  <p>原创内容输出，营销推广包装</p>
                </div>
              </div>
            </Card>
          </Col>
        </Row>
        <div class="blank20"></div>
        <Row :gutter="20">
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/yunma_1.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">云马 UMA</h3>
                <div class="des">
                  <p>种子期孵化项目，资本助力团队搭建和产品开发</p>
                  <p>原创内容输出，营销推广包装</p>
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/swdk_1.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">洒哇地咔 SWDK</h3>
                <div class="des">
                  <p>自媒体总代理品牌，联合定义产品开发</p>
                  <p>产品工业设计助力产品包装设计</p>
                  <p>原创内容输出，营销推广包装</p>
                </div>
              </div>
            </Card>
          </Col>
          <Col :span="8">
            <Card :padding="0">
              <div class="image-box">
                <img src="../../../assets/images/home/case/wwy_1.jpg" />
              </div>
              <div class="content">
                <h3 href="javascript:void(0);">吻吻鱼 KissKissFish</h3>
                <div class="des">
                  <p>种子期孵化项目，资本助力团队搭建和产品开发</p>
                  <p>原创内容输出，营销推广包装</p>
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
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .banner {
    height: 650px;
    background: url('../../../assets/images/home/banner10.jpg');
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
    margin: 40px 0 0 0;
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

  .logo_list {
    height: 210px;
    margin-top: 30px;
    background-image: url(../../../assets/images/home/item_40.png);
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
    margin-top: 40px;
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
    padding: 10px 20px;
  }
  .card_list .content h3 {
    color: #222;
    font-size: 1.8rem;
    padding: 0;
  }

  .card_list .des {
    height: 100px;
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


</style>
