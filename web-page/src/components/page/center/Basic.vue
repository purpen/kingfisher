<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div class="content">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <div class="item">
        <h3>账户概况</h3>
        <div>
          <Row :gutter="24">
            <Col :span="8">
              <div class="counter-item">
                <p class="des">合作产品</p>
                <p class="counter">{{ cooperationCount }}</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="counter-item">
                <p class="des">销售额</p>
                <p class="counter">{{ saleCount }}</p>
              </div>
            </Col>
            <Col :span="8">
              <div class="counter-item">
                <p class="des">订单数</p>
                <p class="counter">{{ orderCount }}</p>
              </div>
            </Col>
          </Row>
        </div>
      </div>

      <div class="item">
        <h3>最新上架产品</h3>
        <div class="product-list">
          <div class="product">
            <div class="product-img">
              <img src="https://p4.taihuoniao.com/product/161121/5832c1d5fc8b12cc058b4646-1-p500x500.jpg" style="width: 100%;" />
            </div>
            <div class="product-content">
              <h3><a href="#">小蚁运动相机</a></h3>
              <p>¥ 150.00</p>
              <p>库存: 200</p>
            </div>
          </div>
          <div class="product">
            <div class="product-img">
              <img src="https://p4.taihuoniao.com//161216/58539eacfc8b12454e8b660e-1-p500x500.jpg" style="width: 100%;" />
            </div>
            <div class="product-content">
              <h3><a href="#">GoPro HERO4 Black 高清4K运动摄像机</a></h3>
              <p>¥ 450.00</p>
              <p>库存: 500</p>
            </div>
          </div>
        </div>
      </div>

      <div class="item">
        <h3>产品素材更新</h3>
        <div class="product-list">
          <div class="product">
            <div class="product-img">
              <img src="https://p4.taihuoniao.com//161221/5859f61ffc8b12404e8b9a1f-1-p500x500.jpg" style="width: 100%;" />
            </div>
            <div class="product-content">
              <h3><a href="#">奶爸爸魔力塑臀椅S4</a></h3>
              <p>文字素材：2，图片：4，视频：2</p>
              <p>素材已更新</p>
            </div>
          </div>
          <div class="product">
            <div class="product-img">
              <img src="https://p4.taihuoniao.com//170427/59019d93fc8b12a9418c8852-1-p500x500.jpg" style="width: 100%;" />
            </div>
            <div class="product-content">
              <h3><a href="#">倍轻松智能手部按摩仪</a></h3>
              <p>文字素材：2，图片：4，视频：2</p>
              <p>素材已更新</p>
            </div>
          </div>
        </div>
      </div>

      <div class="item">
        <h3>智能推荐</h3>
        <div class="stick-product ">
          <Row :gutter="20">

            <Col :span="6" v-for="(d, index) in itemList" :key="index">
              <Card :padding="0" class="item">
                <div class="image-box">
                  <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">
                    <img v-if="d.image" :src="d.image" style="width: 100%;" />
                    <img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />
                  </router-link>
                </div>
                <div class="content">
                  <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">{{ d.name }}</router-link>
                  <div class="des">
                    <p class="price">¥ {{ d.price }}</p>
                    <p class="inventory">库存: {{ d.inventory }}</p>
                  </div>
                </div>
              </Card>
            </Col>

          </Row>
        </div>
      </div>

      <div class="item">
        <h3>已下载素材</h3>
        <div class="product-list">
          <div class="product">
            <div class="product-img">
              <img src="https://p4.taihuoniao.com//161221/5859f61ffc8b12404e8b9a1f-1-p500x500.jpg" style="width: 100%;" />
            </div>
            <div class="product-content">
              <h3><a href="#">奶爸爸魔力塑臀椅S4</a></h3>

            </div>
          </div>
          <div class="product">
            <div class="product-img">
              <img src="https://p4.taihuoniao.com//170427/59019d93fc8b12a9418c8852-1-p500x500.jpg" style="width: 100%;" />
            </div>
            <div class="product-content">
              <h3><a href="#">倍轻松智能手部按摩仪</a></h3>

            </div>
          </div>
        </div>
      </div>
    
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'center_basic',
  data () {
    return {
      isLoading: false,
      cooperationCount: '',
      saleCount: '',
      orderCount: '',
      itemList: [],
      msg: ''
    }
  },
  created: function () {
    const self = this
    self.isLoading = true

    // 账户
    self.$http.get(api.surveyIndex, {})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        var item = response.data.data
        self.cooperationCount = item.cooperation_count
        self.saleCount = item.sales_volume
        self.orderCount = item.order_quantity
        console.log(response.data.data)
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })

    // 产品列表
    self.$http.get(api.productRecommendList, {params: {page: 1, per_page: 9}})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        self.itemList = response.data.data
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .content {
  
  }

  .content .item {
    margin: 0 0 50px 0;
    clear: both;
  }

  .item h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
    margin-bottom: 15px;
  }

  .counter-item {
    border: 1px solid #ccc;
    text-align: center;
    padding: 20px;
  }

  .counter-item p {
    line-height: 2;
  }

  .counter-item .counter {
    font-size: 1.8rem;
    font-weight: 500;
  }

  .product {
    height: 125px;
    border-bottom: 1px solid #ccc;
    margin: 0 0 10px 0;
  
  }
  .product .product-img {
    float: left;
    width: 120px;
    overflow:hidden
  }

  .product .product-content {
    float: left;
    margin: 0 0 0 20px;
  }
  .product .product-content h3 {
    font-size: 1.6rem;
    padding: 0;
    margin: 0;
  }
  .product-list .product-content p {
    line-height: 2;
  }

  .stick-product .item {
    height: 310px;
    margin: 10px 0;
  }

  .stick-product .item img {
    width: 100%;
  }

  .stick-product .image-box {
    height: 250px;
    overflow: hidden;
  }

  .stick-product .content {
    padding: 10px;
  }
  .stick-product .content a {
    font-size: 1.5rem;
  }

  .stick-product .content .des {
    height: 30px;
    margin: 10px 0;
    overflow: hidden;
  }

  .stick-product .content .des p {
    color: #666;
    font-size: 1.2rem;
    line-height: 1.3;
    text-overflow: ellipsis;
  }

  .stick-product .content .des .price {
    float: left;
  }
  .stick-product .content .des .inventory {
    float: right;
  }

</style>
