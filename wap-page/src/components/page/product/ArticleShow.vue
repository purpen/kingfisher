<template>
  <div class="container">
    <Spin size="large" fix v-if="isLoading"></Spin>
    <div class="content">
      <div class="c-title">
        <h2>{{ item.title }}</h2>
        <p>{{ item.article_time }} &nbsp;&nbsp;&nbsp;&nbsp;来源: {{ item.site_from }}</p>
      </div>
      <div class="body" v-html="item.content"></div>   
    </div>
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'w_product_article_show',
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

  .c-title {
  
  }
  .c-title h2 {
    font-size: 0.45rem; 
    line-height: 1.2;
    color: #222;
  }
  .c-title p {
    color: #666;
    font-size: 0.3rem;
    line-height: 2;
  }


</style>
