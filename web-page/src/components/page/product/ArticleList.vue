<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item>文章</Breadcrumb-item>
      </Breadcrumb>
    </div>
    <div class="item-list">
      <h3><i class="fa fa-file-text" aria-hidden="true"></i> 文章</h3>
      <Spin size="large" fix v-if="isLoading"></Spin>
          <Row :gutter="20">
            <Col :span="6" v-for="(d, index) in itemList" :key="index">
              <Card :padding="0" class="card-box">
                <div class="article-box">
                  <router-link :to="{name: 'productArticleShow', params: {id: d.id}}" target="_blank">
                  <p class="source">{{ d.site_from }}</p>
                  <p class="title">{{ d.title }}</p>
                  <p class="cont" v-if="d.cover">
                    <img :src="d.cover.p280_210" />
                  </p>
                  <p class="cont" v-else>{{ d.article_describe }}</p>
                  </router-link>
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
  name: 'product_text_list',
  data () {
    return {
      isLoading: false,
      showTextModel: false,
      currentText: '',
      itemId: '',
      itemList: [],
      itemCount: '',
      msg: '产品文字库'
    }
  },
  methods: {
    // 查看文字详情弹层
    showTextBtn (obj) {
      this.currentText = obj.describe
      this.showTextModel = true
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

    // 文章列表
    self.isLoading = true
    self.$http.get(api.productArticleList, {params: {product_id: productId, per_page: 40}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        var itemList = response.data.data
        for (var i = 0; i < itemList.length; i++) {
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

</style>
