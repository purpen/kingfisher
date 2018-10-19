<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <!--
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>我的产品</Breadcrumb-item>
    </Breadcrumb>
    -->

    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="product"></v-menu>
      </Col>

      <Col :span="21">
        <h3>智能推荐</h3>
        <div class="item-list" v-if="itemList.length !== 0">
          <Spin size="large" fix v-if="isLoading"></Spin>
          <Row>
            <Col>
              <div class="text-right">
                <div class="allOrder">
                  <span class="font-14 cursor" @click="allOrder">全部产品</span>
                </div>
                <div style="display: flex">
                  <Input v-model="search" icon="ios-search" placeholder="输入产品名称搜索" style="width: 200px"></Input>
                  <div>
                    <Button class="color-ff5a5f" @click="searchOrder(search)">确定</Button>
                  </div>
                </div>
              </div>
            </Col>
          </Row>
          <Row :gutter="20">

            <Col :span="6" v-for="(d, index) in itemList" :key="index">
              <Card :padding="0" class="item">
                <router-link :to="{name: 'productShow', params: {id: d.id}}" target="_blank">
                  <div class="image-box">
                    <img v-if="d.image" :src="d.image" style="width: 100%;" />
                    <img v-else src="../../../assets/images/product_500.png" style="width: 100%;" />
                  </div>
                </router-link>
                <div class="img-content">
                  <router-link :to="{name: 'productShow', params: {id: d.id}}" target="_blank">{{ d.name }}</router-link>
                  <div class="des">
                    <p class="price">¥ {{ d.price }}</p>
                    <p class="inventory">库存: {{ d.inventory }}</p>
                  </div>
                </div>
              </Card>
            </Col>

          </Row>
          <div class="blank20"></div>
          <div class="fr">
            <Page :total="query.count" :current="query.page" :page-size="query.size" @on-change="handleCurrentChange" show-total></Page>
          </div>
        </div>
        <div class="wid-200" v-else>
          <p class="text-center">暂无商品...</p>
        </div>
      </Col>
    </Row>
    <div class="blank20"></div>
  </div>
</template>

<script>
import vMenu from '@/components/page/center/Menu'
import api from '@/api/api'
export default {
  name: 'center_product',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      itemList: [],
      itemList2: [],
      count: '',     // 全部商品,搜索为空时总条数
      query: {
        page: 1,
        size: 8,
        count: 0,
        sort: 1,
        test: null
      },
      msg: '我的产品库',
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
            console.log(response)
            self.isLoading = false
            if (response.data.meta.status_code === 200) {
              if (response.data.data.length !== 0) {
                localStorage.setItem('item', item)
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
    // 加载列表
    loadList () {
      const self = this
      let token = this.$store.state.event.token
      self.query.page = parseInt(this.$route.query.page || 1)
      self.isLoading = true
      self.$http.get(api.productRecommendList, {params: {token: token, per_page: this.query.size, page: this.query.page}})
      .then(function (response) {
        self.isLoading = false
        if (response.data && response.data.meta.status_code === 200) {
          if (response.data.data.length !== 0) {
            if (response.data.meta.pagination.total) {
              self.query.count = response.data.meta.pagination.total
            }
            if (response.data.meta.pagination.total) {
              self.count = response.data.meta.pagination.total
            }
            self.itemList = response.data.data
            self.itemList2 = response.data.data
            for (var i = 0; i < self.itemList.length; i++) {
            } // endfor
          }
        }
      })
      .catch(function () {
        self.isLoading = false
        self.$Message.error('暂无数据')
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
  watch: {
    '$route' (to, from) {
      // 对路由变化作出响应...
      this.loadList()
    },
    search () {
      if (!this.search) {
        this.itemList = this.itemList2
        // this.query.count = this.count
      }
    }
  },
  computed: {
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
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .item {
    height: 290px;
    margin: 10px 0;
  }

  .item img {
    width: 100%;
  }

  .image-box {
    height: 220px;
    overflow: hidden;
  }

   h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
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

  .wid-200 {
    width: 100%;
    background: #f8f8f9;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>
