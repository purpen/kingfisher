<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>我的产品</Breadcrumb-item>
    </Breadcrumb>
    <div class="blank20"></div>
    <div class="item-list">
      <h3>我的产品</h3>
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="20">

        <Col :span="6" v-for="(d, index) in itemList" :key="index">
          <Card :padding="0" class="item">
            <div class="image-box">
              <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">
                <img v-if="d.image" :src="d.image" style="width: 100%;" />
                <img v-else src="../../../assets/images/product_500.png" style="width: 100%;" />
              </router-link>
            </div>
            <div class="img-content">
              <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">{{ d.name }}</router-link>
              <div class="des">
                <p class="price">¥ {{ d.price }}</p>
                <p class="inventory">库存: {{ d.inventory }}</p>
              </div>
            </div>
          </Card>
        </Col>

      </Row>
      <div class="blank20"></div>
      <Page :total="query.count" :current="query.page" :page-size="query.size" @on-change="handleCurrentChange" show-total></Page>
    
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'center_product',
  data () {
    return {
      isLoading: false,
      itemList: [],
      query: {
        page: 1,
        size: 8,
        count: 0,
        sort: 1,
        test: null
      },
      msg: '我的产品库'
    }
  },
  methods: {
    loadList () {
      const self = this
      self.query.page = parseInt(this.$route.query.page || 1)
      self.isLoading = true
      self.$http.get(api.myProductList, {params: {page: self.query.page, per_page: self.query.size}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          self.query.count = response.data.meta.pagination.total
          self.itemList = response.data.data
          console.log(self.itemList)
          for (var i = 0; i < self.itemList.length; i++) {
          } // endfor
        }
      })
      .catch(function (error) {
        self.isLoading = false
        self.$Message.error(error.message)
      })
    },
    // 分页
    handleCurrentChange (currentPage) {
      this.query.page = currentPage
      this.$router.push({name: this.$route.name, query: {page: currentPage}})
    }
  },
  watch: {
    '$route' (to, from) {
      // 对路由变化作出响应...
      this.loadList()
    }
  },
  created: function () {
    this.loadList()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .item {
    height: 310px;
    margin: 10px 0;
  }

  .item img {
    width: 100%;
  }

  .image-box {
    height: 250px;
    overflow: hidden;
  }

  .item-list h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
  }


</style>
