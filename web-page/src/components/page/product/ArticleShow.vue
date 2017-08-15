<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item v-if="product"><router-link :to="{name: 'productShow', params: {id: product.product_id}}">{{ product.name }}</router-link></Breadcrumb-item>
          <Breadcrumb-item>文章详情</Breadcrumb-item>
      </Breadcrumb>
    </div>
    <div class="main">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="24">
        <Col :span="18">
          <div class="content">
            <div class="title">
              <h3>{{ item.title }}</h3>
              <div class="title-asset">
                <p class="from">{{ item.article_time }} &nbsp;&nbsp;&nbsp;&nbsp;来源: {{ item.site_from }}</p>
              </div>
            </div>
            <div class="body" v-html="item.content"></div>
          </div>
          <div class="download">
            <Button type="primary" @click="down">打包下载</Button>
          </div>
        </Col>
        <Col :span="6">
          <div class="slider" v-if="product">
            <div>
              <Card :padding="0" class="product">
                <div class="image-box">
                  <router-link :to="{name: 'productShow', params: {id: product.product_id}}" target="_blank">
                    <img v-if="product.image" :src="product.image" style="width: 100%;" />
                    <img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />
                  </router-link>
                </div>
                <div class="p-content">
                  <router-link :to="{name: 'productShow', params: {id: product.product_id}}" target="_blank">{{ product.name }}</router-link>
                  <div class="des">
                    <p class="price">¥ {{ product.price }}</p>
                    <p class="inventory">库存: {{ product.inventory }}</p>
                  </div>
                </div>
              </Card>
            </div>
          </div>
        </Col>
      </Row>
    
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'product_article_show',
  data () {
    return {
      isLoading: false,
      itemId: '',
      item: '',
      product: '',
      msg: '产品文章详情'
    }
  },
  methods: {
    // 下载
    down () {
      alert(123)
    }
  },
  created: function () {
    const self = this
    const id = this.$route.params.id
    if (!id) {
      this.$Message.error('缺少请求参数!')
      this.$router.replace({name: 'home'})
      return
    }
    self.itemId = id

    // 文章详情
    self.isLoading = true
    self.$http.get(api.productArticle, {params: {id: id}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        self.item = response.data.data
        if (self.item.product) {
          self.product = self.item.product
        } else {
          self.$Message.error('产品不存在!')
          self.$router.replace({name: 'home'})
          return
        }
        console.log(self.item)
      } else {
        self.$Message.error(response.data.meta.message)
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .main {
    margin: 20px 0 0 0;
  }

  .content {
  }
  
  .content .title {
    margin: 0 0 10px 0;
  }

  .content .title h3 {
    text-align: center;
    font-size: 2.2rem;
    line-height: 2;
  }
  .title-asset {
    border-top: 1px solid #ccc;
    line-height: 3;
    font-size: 1.2rem;
    color: #666; 
    height: 30px;
  }
  .content .title .from {
    float: left;
  }

  .content .title .down {
    float: right;
  }

  .content .body img {
    text-align: center;
    width: 100%;
  }
  .content .body p img {
    text-align: center;
    width: 100%;
  }

  .slider {
  }

  .product {
    height: 310px;
    margin: 10px 0;
  }

  .product img {
    width: 100%;
  }

  .image-box {
    height: 250px;
    overflow: hidden;
  }

  .p-content {
    padding: 10px;
  }
  .p-content a {
    font-size: 1.5rem;
  }

  .p-content .des {
    height: 30px;
    margin: 10px 0;
    overflow: hidden;
  }

  .p-content .des p {
    color: #666;
    font-size: 1.2rem;
    line-height: 1.3;
    text-overflow: ellipsis;
  }

  .p-content .des .price {
    float: left;
  }
  .p-content .des .inventory {
    float: right;
  }

  .download {
    text-align: right;
    margin-top: 40px;
  }

</style>
