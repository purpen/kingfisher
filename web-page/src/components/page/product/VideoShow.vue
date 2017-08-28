<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item v-if="product"><router-link :to="{name: 'productShow', params: {id: product.product_id}}">{{ product.name }}</router-link></Breadcrumb-item>
          <Breadcrumb-item>视频详情</Breadcrumb-item>
      </Breadcrumb>
    </div>
    <div class="main">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="24">
        <Col :span="18">
          <div class="content">
            <div class="title">
              <h3>{{ item.describe }}</h3>
              <p class="from">视频大小: {{ video.video_size_label }} &nbsp;&nbsp;&nbsp;&nbsp;长度: {{ item.video_length }}</p>
            </div>
            <div class="body">
                <video :src="video.url" controls="controls" width="800" height="350px">
                  您的浏览器不支持 video 标签。
                </video>
            </div>
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
  name: 'product_video_show',
  data () {
    return {
      isLoading: false,
      itemId: '',
      item: '',
      product: '',
      video: '',
      msg: '产品视频详情'
    }
  },
  methods: {
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

    // 视频详情
    self.isLoading = true
    self.$http.get(api.productVideo, {params: {id: id}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        self.item = response.data.data
        var video = response.data.data.asset
        video.url = response.data.data.asset.srcfile + '?attname=' + response.data.data.asset.name
        var videoSize = self.item['video_size']
        if (videoSize === 0) {
          video['video_size_label'] = '0B'
        } else {
          var k = 1024
          var sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
          var m = Math.floor(Math.log(videoSize) / Math.log(k))
          video['video_size_label'] = (videoSize / Math.pow(k, m)).toFixed(1) + ' ' + sizes[m]
        }
        self.video = video
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
    font-size: 1.8rem;
    line-height: 2;
  }
  .content .title .from {
    border-top: 1px solid #666;
    line-height: 2;
    font-size: 1.2rem;
    color: #666;
  }

  .content .body {
    
  }
  .content .body p {
    color: red;
    line-height: 2;
  }
  .content .body img {
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




</style>
