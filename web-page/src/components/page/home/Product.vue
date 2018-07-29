<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div class="item-list">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row>
        <Col>
          <div class="text-right">
            <div class="allOrder">
              <span class="font-14 cursor" @click="allOrder">全部商品</span>
            </div>
            <div>
              <Input v-model="search" icon="ios-search" placeholder="输入商品名称搜索" style="width: 200px"></Input>
              <Button class="color-ff5a5f" @click="searchOrder(search)">确定</Button>
            </div>
          </div>
        </Col>
      </Row>
      <Row :gutter="20">

        <Col :span="6" v-for="(d, index) in itemList" :key="index">
          <Card :padding="0" class="product-item">
            <div class="image-box">
              <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">
                <img v-if="d.image" :src="d.image" style="width: 100%;" />
                <img v-else src="../../../assets/images/product_500.png" style="width: 100%;" />
              </router-link>
              <Tag class="stat" color="green" v-show="d.status === 1">已合作</Tag>
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
  name: 'product',
  data () {
    return {
      isLoading: false,
      itemList: [],
      itemList2: [],
      count: '',
      query: {
        page: 1,
        size: 8,
        count: 0,
        sort: 1,
        test: null
      },
      msg: '产品库',
      search: ''
    }
  },
  methods: {
    // 搜索
    searchOrder (item) {
      let self = this
      if (item) {
        self.isLoading = true
        self.$http.get(api.search, {params: {name: item}})
          .then(function (response) {
            self.isLoading = false
            if (response.data.meta.status_code === 200) {
              if (response.data.data.length !== 0) {
                localStorage.setItem('item', item)
                console.log(response.data.data)
                self.query.count = response.data.meta.pagination.total
                self.itemList = response.data.data
              } else {
                self.$Message.error('暂无' + item + '的商品')
              }
            }
          })
          .catch(function (error) {
            self.isLoading = false
            self.$Message.error(error.message)
          })
      }
    },
    loadList () {
      let token = this.$store.state.event.token
      const self = this
      self.query.page = parseInt(this.$route.query.page || 1)
      self.isLoading = true
      self.$http.get(api.productlist, {params: {per_page: self.query.size, page: self.query.page, token: token}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          self.query.count = response.data.meta.pagination.total
          self.count = response.data.meta.pagination.total
          self.itemList = response.data.data
          self.itemList2 = response.data.data
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
    },
    allOrder () {
      this.itemList = this.itemList2
      this.search = ''
    }
  },
  created: function () {
    this.loadList()
    let self = this
    window.addEventListener('keydown', function (e) {
      if (e.keyCode === 13) {
        e.preventDefault()
        if (self.search !== '') {
          self.searchOrder(self.search)
        }
      }
    })
  },
  watch: {
    '$route' (to, from) {
      // 对路由变化作出响应...
      this.loadList()
    },
    search () {
      if (!this.search) {
        console.log(this.itemList2)
        this.itemList = this.itemList2
        this.query.count = this.count
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .product-item {
    height: 310px;
    margin: 10px 0;
  }

  .product-item img {
    width: 100%;
  }

  .product-item .image-box {
    height: 250px;
    overflow: hidden;
  }

  .text-right {
    margin: 10px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .text-right button {
    margin-left: 5px;
  }

  .cursor {
    transition: color .5s ease;
  }

  .allOrder:hover .cursor {
    color: #FF5A5F;
  }
</style>
