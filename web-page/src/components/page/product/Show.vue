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
              <div class="float-left">
                <h3>{{ item.name }}</h3>
                <!--<p v-if="item.status === 0"><Button type="primary" @click="cooperBtn(item.product_id, 1)">+ 添加合作产品</Button></p>-->
                <!--<p v-else><Button @click="cooperBtn(item.product_id, 0)">取消合作产品</Button></p>-->

                <div class="mar-b-10">
                  <span class="width-100">商品编号:</span>
                  <span>{{ item.number }}</span>
                </div>
                <div class="mar-b-10">
                  <span class="width-100">市场价格: </span>
                  <span>{{ '¥ ' + item.market_price }}</span>
                </div>
                <div class="mar-b-10">
                  <span class="width-100">销售数量: </span>
                  <span>{{ item.sales_number}}</span>
                </div>
                <div class="mar-b-10">
                  <span class="width-100">类别:</span>
                  <span>{{ item.category }}</span>
                </div>
                <div class="mar-b-10">
                  <span class="width-100">重量: </span>
                  <span>{{ item.weight }}kg</span>
                </div>
                <div class="mar-b-10">
                  <span class="width-100">库存: </span>
                  <span>{{ item.inventory }}</span>
                </div>
              </div>
              <div class="float-right">
                <!--<div class="mar-t-20">-->
                <!--</div>-->
                <!--<p>sku类别: <span v-for="(d, index) in item.skus">{{ d.mode }} </span></p>-->

              </div>
            </div>
          </Col>
        </Row>
        <div>
          <div class="margin-10">
            <p class="font-18">SKU</p>
          </div>
          <Table border :columns="skuTitle" :data="skuList"></Table>
        </div>
      </div>

      <!--<div class="item">-->
        <!--<div class="item-banner">-->
          <!--<p class="banner-title"><i class="fa fa-file-text-o" aria-hidden="true"></i> 文字素材 ({{ itemTextCount }})</p>-->
          <!--<p class="banner-btn"><router-link :to="{name: 'productTextList', params: {product_id: itemId}}">查看全部</router-link></p>-->
        <!--</div>-->
        <!--<div class="asset-list">-->
          <!--<Row :gutter="20">-->
            <!--<Col :span="6" v-for="(d, index) in itemTexts" :key="index">-->
              <!--<Card :padding="0" class="card-box">-->
                <!--<a href="javascript:void(0);" @click="showTextBtn(d)">-->
                <!--<div class="text-box">-->
                  <!--<p>{{ d.describe }}</p>-->
                <!--</div>-->
                <!--</a>-->
                <!--&lt;!&ndash;-->
                <!--<div class="img-content">-->
                  <!--<div class="des" style="text-align: right;">-->
                    <!--<p><a href="javascript:void(0);" @click="showTextBtn(d)">查看全部</a></p>-->
                  <!--</div>-->
                <!--</div>-->
                <!--&ndash;&gt;-->
              <!--</Card>-->
            <!--</Col>-->

          <!--</Row>-->

        <!--</div>-->
      <!--</div>-->

      <!--<div class="item">-->
        <!--<div class="item-banner">-->
          <!--<p class="banner-title"><i class="fa fa-file-text" aria-hidden="true"></i> 文章 ({{ itemArticleCount }})</p>-->
          <!--<p class="banner-btn"><router-link :to="{name: 'productArticleList', params: {product_id: itemId}}">查看全部</router-link></p>-->
        <!--</div>-->
        <!--<div class="asset-list">-->
          <!--<Row :gutter="20">-->
            <!--<Col :span="6" v-for="(d, index) in itemArticles" :key="index">-->
              <!--<Card :padding="0" class="card-box">-->
                <!--<div class="article-box">-->
                  <!--<router-link :to="{name: 'productArticleShow', params: {id: d.id}}" target="_blank">-->
                  <!--<div class="article-title">-->
                    <!--<p class="source">{{ d.site_from }}</p>-->
                    <!--<p class="title">{{ d.title }}</p>-->
                  <!--</div>-->
                  <!--<div v-if="d.cover" class="cont">-->
                    <!--<img :src="d.cover.p280_210" />-->
                  <!--</div>-->
                  <!--<div class="cont" v-else>-->
                     <!--<p class="cont">{{ d.article_describe }}</p>-->
                  <!--</div>-->
                  <!--</router-link>-->
                <!--</div>-->

              <!--</Card>-->
            <!--</Col>-->

          <!--</Row>-->

        <!--</div>-->
      <!--</div>-->


      <!--<div class="item">-->
        <!--<div class="item-banner">-->
          <!--<p class="banner-title"><i class="fa fa-picture-o" aria-hidden="true"></i> 图片 ({{ itemImageCount }})</p>-->
          <!--<p class="banner-btn"><router-link :to="{name: 'productImageList', params: {product_id: itemId}}">查看全部</router-link></p>-->
        <!--</div>-->
        <!--<div class="asset-list">-->
          <!--<Row :gutter="20">-->
            <!--<Col :span="6" v-for="(d, index) in itemImages" :key="index">-->
              <!--<Card :padding="0" class="card-box">-->
                <!--<div class="image-box">-->
                  <!--<a href="javascript:void(0);" @click="showImgBtn(d)">-->
                    <!--<img v-if="d.image" :src="d.image.p280_210" style="width: 100%;" />-->
                    <!--<img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />-->
                  <!--</a>-->
                <!--</div>-->
                <!--<div class="img-content">-->
                  <!--<a class="img-text" href="javascript:void(0);" @click="showImgBtn(d)">{{ d.describe }}</a>-->
                  <!--<div class="des">-->
                    <!--<p class="price">类别: {{ d.image_type_label }}</p>-->
                    <!--<p class="inventory"><a href="javascript:void(0);" @click="download(d.image.srcfile + '?attname=' + d.image.name)">下载原图</a></p>-->
                  <!--</div>-->
                <!--</div>-->
              <!--</Card>-->
            <!--</Col>-->


          <!--</Row>-->

        <!--</div>-->
      <!--</div>-->


      <!--<div class="item">-->
        <!--<div class="item-banner">-->
          <!--<p class="banner-title"><i class="fa fa-video-camera" aria-hidden="true"></i> 视频 ({{ itemVideoCount }})</p>-->
          <!--<p class="banner-btn"><router-link :to="{name: 'productVideoList', params: {product_id: itemId}}">查看全部</router-link></p>-->
        <!--</div>-->
        <!--<div class="asset-list">-->
          <!--<Row :gutter="20">-->
            <!--<Col :span="6" v-for="(d, index) in itemVideos" :key="index">-->
              <!--<Card :padding="0" class="card-box">-->
                <!--<div class="image-box video">-->
                  <!--<router-link :to="{name: 'productVideoShow', params: {id: d.id}}" target="_blank">-->
                    <!--<img v-if="d.asset" :src="d.asset.video" style="width: 100%;" />-->
                    <!--<img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />-->
                    <!--<div class="play">-->
                      <!--<i class="fa fa-play-circle-o fa-5x" aria-hidden="true"></i>-->
                    <!--</div>-->
                  <!--</router-link>-->

                <!--</div>-->

                <!--<div class="img-content">-->
                  <!--<router-link :to="{name: 'productVideoShow', params: {id: d.id}}" target="_blank">{{ d.describe }}</router-link>-->
                  <!--<div class="des">-->
                    <!--<p class="price">{{ d.video_size_label }}</p>-->
                    <!--<p class="inventory"><a href="javascript:void(0);" @click="download(d.asset.srcfile + '?attname=' + d.asset.name)">下载视频</a></p>-->
                  <!--</div>-->
                <!--</div>-->
              <!--</Card>-->
            <!--</Col>-->

          <!--</Row>-->
        <!--</div>-->
      <!--</div>-->


    </div>

    <Modal
        v-model="showTextModel"
        @on-ok="showTextModel = false"
        :closable="false"
        @on-cancel="showTextModel = false">
        <p>{{ currentText }}</p>
        <div slot="footer">
          <Button @click="showTextModel = false">关闭</Button>
        </div>
    </Modal>

    <Modal
        v-model="showImgModel"
        @on-ok="showImgModel = false"
        :closable="false"
        :styles="{top: '20px'}"
        @on-cancel="showImgModel = false">
        <p><img :src="currentImg" style="width: 100%;" /></p>
        <p>{{ currentText }}</p>
        <div slot="footer">
          <Button @click="showImgModel = false">关闭</Button>
        </div>
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
      showImgModel: false,
      currentText: '',
      currentImg: '',
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
      msg: '产品库',
      // sku
      skuTitle: [
        {
          title: '规格图',
          key: 'image',
          render: (h, params) => {
            return h('img', {
              style: {
                width: '100px',
                padding: '10px'
              },
              attrs: {
                src: params.row.image
              }
            })
          }
        },
        {
          title: '商品编号',
          key: 'number'
        },
        {
          title: '商品型号',
          key: 'mode'
        },
        {
          title: '价格',
          key: 'price'
        },
        {
          title: '市场价格',
          key: 'market_price'
        },
        {
          title: '库存',
          key: 'inventory'
        }
      ],
      skuList: []
    }
  },
  methods: {
    // 添加 取消合作产品
    // cooperBtn (productId, evt) {
    //   const self = this
    //   self.$http.post(api.trueCooperProduct, {product_id: productId, status: evt})
    //   .then(function (response) {
    //     if (response.data.meta.status_code === 200) {
    //       self.item.status = evt
    //       self.$Message.success('操作成功！')
    //     } else {
    //       self.$Message.error('系统内部错误！')
    //     }
    //   })
    //   .catch(function (error) {
    //     self.$Message.error(error.message)
    //   })
    // },
    // 查看文字详情弹层
    showTextBtn (obj) {
      this.currentText = obj.describe
      this.showTextModel = true
    },
    // 查看图片弹层
    showImgBtn (obj) {
      this.currentText = obj.describe
      this.currentImg = obj.image.p800
      this.showImgModel = true
    },
    // 下载
    download (url) {
      location.href = url
    }
  },
  created: function () {
    const self = this
    let token = this.$store.state.event.token
    const id = this.$route.params.id
    if (!id) {
      this.$Message.error('缺少请求参数!')
      this.$router.replace({name: 'home'})
      return
    }
    self.itemId = id
    // 获取商品详情
    self.isLoading = true
    self.$http.get(api.productShow, {params: {product_id: id, token: token}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        const item = response.data.data
        self.item = item
        self.skuList = item.skus
        for (let i = 0; i < self.skuList.length; i++) {
          if (!self.skuList[i].inventory) {   // 删除库存为0
            self.skuList.splice(i, 1)
          }
        }
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
        // console.log(self.itemImages)
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
        // console.log(self.itemTexts)
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
        // console.log(self.itemArticles)
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
        self.itemVideos = videoList
        self.itemVideoCount = response.data.meta.pagination.count
        // console.log(self.itemVideos)
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
    margin: 0 0 20px 0;
  }

  .info {
    display: flex;
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
    margin: 10px 0 20px 0;
  }

  .width-100 {
    width: 80px;
    display: inline-block;
    font-size: 14px;
  }

  .mar-b-10 {
    margin-bottom: 10px;
  }

  .mar-t-20 {
    padding-top: 20px;
  }

  .float-right {
    width: 50%;
    margin-left: 50px;
  }

  .margin-10 {
    margin: 10px;
  }

  .font-18 {
    font-size: 18px;
  }
</style>
