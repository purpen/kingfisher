<template>
  <div class="container">
    <div class="blank20"></div>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <div class="content">
        <Row :gutter="20">

          <Col :span="6">
            <div>
              <img v-if="item.image" :src="item.image" style="width: 100%;" />
              <img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />
            </div>
          </Col>
          <Col :span="18">
            <div class="info">
              <h3>{{ item.name }}</h3>
              <p v-if="item.status === 0"><Button type="primary" @click="cooperBtn(item.product_id, 1)">+ 添加合作产品</Button></p>
              <p v-else><Button @click="cooperBtn(item.product_id, 0)">取消合作产品</Button></p>
              <p>货号: {{ item.number }}</p>
              <p>类别: {{ item.category }}</p>
              <p>进货价: ¥ {{ item.price }}</p>
              <p>重量: {{ item.weight }}kg</p>
              <p>库存: {{ item.inventory }}</p>
              <p>sku类别: <span v-for="(d, index) in item.skus">{{ d.mode }} </span></p>
              <p>备注: {{ item.summary }}</p>
            </div>
          </Col>

        </Row>
      </div>

      <div class="item">
        <div class="item-banner">
          <p class="banner-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> 文字素材 ({{ itemTextCount }})</p>
          <p class="banner-btn"><router-link :to="{name: 'productTextList', params: {product_id: itemId}}">查看全部</router-link></p>
        </div>
        <div class="asset-list">
          <Row :gutter="20">
            <Col :span="6" v-for="(d, index) in itemTexts" :key="index">
              <Card :padding="0" class="card-box">
                <a href="javascript:void(0);" @click="showTextBtn(d)">
                <div class="text-box">
                  <p>{{ d.describe }}</p>
                </div>
                </a>
                <!--
                <div class="img-content">
                  <div class="des" style="text-align: right;">
                    <p><a href="javascript:void(0);" @click="showTextBtn(d)">查看全部</a></p>
                  </div>
                </div>
                -->
              </Card>
            </Col>

          </Row>

        </div>
      </div>

      <div class="item">
        <div class="item-banner">
          <p class="banner-title"><i class="fa fa-file-text" aria-hidden="true"></i> 文章 ({{ itemArticleCount }})</p>
          <p class="banner-btn"><router-link :to="{name: 'productArticleList', params: {product_id: itemId}}">查看全部</router-link></p>
        </div>
        <div class="asset-list">
          <Row :gutter="20">
            <Col :span="6" v-for="(d, index) in itemArticles" :key="index">
              <Card :padding="0" class="card-box">
                <div class="article-box">
                  <router-link :to="{name: 'productArticleShow', params: {id: d.id}}" target="_blank">
                  <p class="source">{{ d.site_from }}</p>
                  <p class="title">{{ d.title }}</p>
                  <p class="cont" v-if="d.article_image">
                    <img :src="d.article_image" />
                  </p>
                  <p class="cont" v-else>{{ d.article_describe }}</p>
                  </router-link>
                </div>

              </Card>
            </Col>

          </Row>

        </div>
      </div>


      <div class="item">
        <div class="item-banner">
          <p class="banner-title"><i class="fa fa-picture-o" aria-hidden="true"></i> 图片 ({{ itemImageCount }})</p>
          <p class="banner-btn"><router-link :to="{name: 'productImageList', params: {product_id: itemId}}">查看全部</router-link></p>
        </div>
        <div class="asset-list">
          <Row :gutter="20">
            <Col :span="6" v-for="(d, index) in itemImages" :key="index">
              <Card :padding="0" class="card-box">
                <div class="image-box">
                  <a :href="d.image.srcfile" v-if="d.image" target="_blank">
                    <img :src="d.image.p500" style="width: 100%;" />
                  </a>
                  <a href="javascript:void(0);" v-else target="_blank">
                    <img src="../../../assets/images/default_thn.png" style="width: 100%;" />
                  </a>
                </div>
                <div class="img-content">
                  <p class="img-text">{{ d.describe }}</p>
                  <div class="des">
                    <p class="price">类别: {{ d.image_type_label }}</p>
                    <p class="inventory"><a :href="d.image.srcfile" download="aaa">下载</a></p>
                  </div>
                </div>
              </Card>
            </Col>


          </Row>

        </div>
      </div>


      <div class="item">
        <div class="item-banner">
          <p class="banner-title"><i class="fa fa-video-camera" aria-hidden="true"></i> 视频 ({{ itemVideoCount }})</p>
          <p class="banner-btn"><router-link :to="{name: 'productVideoList', params: {product_id: itemId}}">查看全部</router-link></p>
        </div>
        <div class="asset-list">
          <Row :gutter="20">
            <Col :span="6" v-for="(d, index) in itemVideos" :key="index">
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

    
    </div>

    <Modal
        v-model="showTextModel"
        @on-ok="showTextModel = false"
        :closable="false"
        @on-cancel="showTextModel = false">
        <p>{{ currentText }}</p>
    </Modal>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'product',
  data () {
    return {
      isLoading: false,
      isTextLoading: false,
      isArticleLoading: false,
      isVideoLoading: false,
      isImageLoading: false,
      showTextModel: false,
      currentText: '',
      item: '',
      itemId: '',
      itemTextCount: '',
      itemImageCount: '',
      itemVideoCount: '',
      itemArticleCount: '',
      itemTexts: [],
      itemArticles: [],
      itemImages: [],
      itemVideos: [],
      msg: '产品库'
    }
  },
  methods: {
    // 添加 取消合作产品
    cooperBtn (productId, evt) {
      const self = this
      self.$http.post(api.trueCooperProduct, {product_id: productId, status: evt})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          self.item.status = evt
          self.$Message.success('操作成功！')
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
      })
    },
    // 查看文字详情弹层
    showTextBtn (obj) {
      this.currentText = obj.describe
      this.showTextModel = true
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

    // 获取商品详情
    self.isLoading = true
    self.$http.get(api.productShow, {params: {product_id: id}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        const item = response.data.data
        self.item = item
        console.log(self.item)
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })

    // 图片列表
    self.isImageLoading = true
    self.$http.get(api.productImageList, {params: {product_id: id, per_page: 4}})
    .then(function (response) {
      self.isImageLoading = false
      if (response.data.meta.status_code === 200) {
        var imageList = response.data.data
        for (var i = 0; i < imageList.length; i++) {
          switch (parseInt(imageList[i].image_type)) {
            case 1:
              imageList[i]['image_type_label'] = '场景'
              break
            case 2:
              imageList[i]['image_type_label'] = '细节'
              break
            case 3:
              imageList[i]['image_type_label'] = '展示'
              break
            default:
              imageList[i]['image_type_label'] = ''
          }
        } // endfor
        self.itemImages = imageList
        self.itemImageCount = response.data.meta.pagination.count
        console.log(self.itemImages)
      }
    })
    .catch(function (error) {
      self.isImageLoading = false
      self.$Message.error(error.message)
    })

    // 文字列表
    self.isTextLoading = true
    self.$http.get(api.productTextList, {params: {product_id: id, per_page: 4}})
    .then(function (response) {
      self.isTextLoading = false
      if (response.data.meta.status_code === 200) {
        var textList = response.data.data
        for (var i = 0; i < textList.length; i++) {
        } // endfor
        self.itemTexts = textList
        self.itemTextCount = response.data.meta.pagination.count
        console.log(self.itemTexts)
      }
    })
    .catch(function (error) {
      self.isTextLoading = false
      self.$Message.error(error.message)
    })

    // 文章列表
    self.isArticleLoading = true
    self.$http.get(api.productArticleList, {params: {product_id: id, per_page: 4}})
    .then(function (response) {
      self.isArticleLoading = false
      if (response.data.meta.status_code === 200) {
        var articleList = response.data.data
        for (var i = 0; i < articleList.length; i++) {
        } // endfor
        self.itemArticles = articleList
        self.itemArticleCount = response.data.meta.pagination.count
        console.log(self.itemArticles)
      }
    })
    .catch(function (error) {
      self.isArticleLoading = false
      self.$Message.error(error.message)
    })

    // 视频列表
    self.isVideoLoading = true
    self.$http.get(api.productVideoList, {params: {product_id: id, per_page: 4}})
    .then(function (response) {
      self.isVideoLoading = false
      if (response.data.meta.status_code === 200) {
        var videoList = response.data.data
        for (var i = 0; i < videoList.length; i++) {
        } // endfor
        self.itemVideos = videoList
        self.itemVideoCount = response.data.meta.pagination.count
        console.log(self.itemVideos)
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

  .content {
    margin: 0 0 40px 0;
  }

  .info {
  
  }
  .info p {
    line-height: 2;
  }
  .info h3 {
    font-size: 1.8rem;
    margin: 0 0 10px 0;
  }

  .item-banner {
    height: 30px;
    border-bottom: 1px solid #ccc;
  }

  .item-banner p {
    line-height: 2;
  
  }

  .banner-title {
    float: left;
    margin-top: -5px;
  }
  .banner-btn {
    float: right;
    font-size: 1.2rem;
  }

  .asset-list {
    margin: 20px 0;
  }

  .text-box {
    height: 200px;
    padding: 15px;
  }
  .text-box p {
    height: 150px;
    line-height: 1.5;
    text-overflow: ellipsis;
    overflow: hidden;
    text-overflow: clip;
  }

  .image-box {
    height: 180px;
    overflow: hidden;
  }

  .img-content {
    padding: 10px;
  }
  .img-content .img-text {
    font-size: 1.2rem;
    line-height: 1.2;
    height: 30px;
    overflow: hidden;
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

  .article-box {
    padding: 10px;
    height: 200px;
    overflow: hidden;
    margin-bottom: 10px;
  }
  .article-box .source {
    color: #666;
    font-size: 1.3rem;
    line-height: 2;
  }
  .article-box .title {
    color: #222;
    font-size: 1.5rem;
    line-height: 2;
  }
  .article-box .cont {
    color: #666;
    font-size: 1.3rem;
    line-height: 1.5;
  }
  .article-box .cont img {
    width: 100%;
  }


</style>
