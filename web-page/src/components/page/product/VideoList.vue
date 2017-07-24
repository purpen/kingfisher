<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item>视频</Breadcrumb-item>
      </Breadcrumb>
    </div>
    <div class="item-list">
      <h3><i class="fa fa-picture-o" aria-hidden="true"></i> 视频</h3>
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="20">
        <Col :span="6" v-for="(d, index) in itemList" :key="index">
          <Card :padding="0" class="card-box">
            <div class="image-box">
              <router-link :to="{name: 'productVideoShow', params: {id: d.id}}" target="_blank">
                <img v-if="d.video_image" :src="d.video_image" style="width: 100%;" />
                <img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />
              </router-link>
            </div>
            <div class="img-content">
              <router-link :to="{name: 'productVideoShow', params: {id: d.id}}" target="_blank">{{ d.describe }}</router-link>
            </div>
          </Card>
        </Col>


      </Row>
    
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'product_video_list',
  data () {
    return {
      isLoading: false,
      itemId: '',
      itemList: [],
      itemCount: '',
      msg: '产品视频库'
    }
  },
  methods: {
  },
  created: function () {
    const self = this
    const productId = this.$route.params.product_id
    if (!productId) {
      this.$Message.error('缺少请求参数!')
      this.$router.replace({name: 'home'})
      return
    }
    self.itemId = productId

    // 视频列表
    self.isVideoLoading = true
    self.$http.get(api.productVideoList, {params: {product_id: productId, per_page: 40}})
    .then(function (response) {
      self.isVideoLoading = false
      if (response.data.meta.status_code === 200) {
        var videoList = response.data.data
        for (var i = 0; i < videoList.length; i++) {
        } // endfor
        self.itemList = videoList
        self.itemCount = response.data.meta.pagination.count
        console.log(self.itemList)
      }
    })
    .catch(function (error) {
      self.isVideoLoading = false
      self.$Message.error(error.message)
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .item-list {
    margin: 20px 0;
  }

  .item-list h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
  }

  .image-box {
    height: 180px;
    overflow: hidden;
  }

  .img-content {
    padding: 10px;
  }
  .img-content a {
    font-size: 1.5rem;
  }

  .img-content .des {
    height: 20px;
    margin: 5px 0 0 0;
    overflow: hidden;
  }

  .img-content .des .price {
    float: left;
  }
  .img-content .des .inventory {
    float: right;
  }

  .img-content .des p, .img-content .des p a {
    color: #666;
    font-size: 1.2rem;
    line-height: 2;
    text-overflow: ellipsis;
  }


</style>
