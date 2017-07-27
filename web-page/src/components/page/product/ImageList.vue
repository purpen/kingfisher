<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item>图片</Breadcrumb-item>
      </Breadcrumb>
    </div>
    <div class="item-list">
      <h3><i class="fa fa-picture-o" aria-hidden="true"></i> 图片</h3>
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="20">
        <Col :span="6" v-for="(d, index) in itemList" :key="index">
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
                <p class="inventory"><a :href="d.image.srcfile" :download="d.image.srcfile">下载</a></p>
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
  name: 'product_image_list',
  data () {
    return {
      isLoading: false,
      itemId: '',
      itemList: [],
      itemCount: '',
      msg: '产品图片库'
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

    // 图片列表
    self.isLoading = true
    self.$http.get(api.productImageList, {params: {product_id: productId, per_page: 40}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        var itemList = response.data.data
        for (var i = 0; i < itemList.length; i++) {
          switch (parseInt(itemList[i].image_type)) {
            case 1:
              itemList[i]['image_type_label'] = '场景'
              break
            case 2:
              itemList[i]['image_type_label'] = '细节'
              break
            case 3:
              itemList[i]['image_type_label'] = '展示'
              break
            default:
              itemList[i]['image_type_label'] = ''
          }
        } // endfor
        self.itemList = itemList
        self.itemCount = response.data.meta.pagination.count
        console.log(self.itemList)
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


</style>
