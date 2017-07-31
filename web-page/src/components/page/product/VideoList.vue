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
      <h3><i class="fa fa-picture-o" aria-hidden="true"></i> 视频 <span>({{ itemCount }})</span></h3>
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="20">
        <Col :span="6" v-for="(d, index) in itemList" :key="index">
          <Card :padding="0" class="card-box">
            <div class="image-box video">
              <router-link :to="{name: 'productVideoShow', params: {id: d.id}}" target="_blank">
                <img v-if="d.asset" :src="d.asset.video" style="width: 100%;" />
                <img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />
                <div class="play">
                  <i class="fa fa-play-circle-o fa-5x" aria-hidden="true"></i>
                </div>
              </router-link>

            </div>

            <div class="img-content">
              <router-link :to="{name: 'productVideoShow', params: {id: d.id}}" target="_blank">{{ d.describe }}</router-link>
              <div class="des">
                <p class="price">视频大小: {{ d.video_size_label }}</p>
                <p class="inventory"><a href="javascript:void(0);" @click="download(d.asset.srcfile + '?attname=' + d.asset.name)">下载视频</a></p>
              </div>
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
    // 下载
    download (url) {
      location.href = url
    }
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
          var videoSize = videoList[i]['video_size']
          if (videoSize === 0) {
            videoList[i]['video_size_label'] = '0B'
          } else {
            var k = 1024
            var sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            var m = Math.floor(Math.log(videoSize) / Math.log(k))
            videoList[i]['video_size_label'] = (videoSize / Math.pow(k, m)).toFixed(1) + ' ' + sizes[m]
          }
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

</style>
