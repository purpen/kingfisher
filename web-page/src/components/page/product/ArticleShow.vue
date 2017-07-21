<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品名称</Breadcrumb-item>
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
              <p class="from">{{ item.article_time }} &nbsp;&nbsp;&nbsp;&nbsp;来源: {{ item.site_from }}</p>
            </div>
            <div class="body" v-html="item.content">
              {{ item.content }}
            </div>
          </div>
        </Col>
        <Col :span="6">
          <div class="slider">
          
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
    border: 1px solid #ccc;
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
    border-top: 2px solid #ccc;
    line-height: 2;
    font-size: 1.2rem;
    color: #666;
  }

  .content .body {
    
  }
  .content .body p {
    line-height: 2;
  }
  .content .body img {
    text-align: center;
    width: 100%;
  }

  .slider {
    border: 1px solid #ccc;
  }


</style>
