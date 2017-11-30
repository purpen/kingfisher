<template>
  <div class="home">
    <div class="container">
      <div class="banner">
        <ul v-if="productList.length" class="goods-list clearfix">
          <li v-for="(d, index) in productList" :key="index" ref="goods">
            <router-link :to="{name: 'GoodsShow', params: {id: d.id}}"
                         class="card">
              <img v-lazy="d.image" alt="d.name">
              <div class="intro">
                <p class="title">{{d.name}}</p>
                <p class="info">
                  <span class="price">{{d.price}}</span>
                </p>
              </div>
            </router-link>
          </li>
        </ul>
        <Page v-if="productList.length" :total="pagination.total" size="small" class-name="pagin"
              @on-change="getProduct"></Page>
      </div>
    </div>
  </div>
</template>

<script>
  import api from '@/api/api'

  export default {
    name: 'hello',
    data () {
      return {
        productList: [],
        pagination: {
          total: 1,
          total_pages: 1,
          current_page: 1,
          per_page: 10
        }
      }
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    created () {
      this.getProduct()
    },
    methods: {
      getProduct (val) {
        this.$Spin.show()
        let that = this
        that.$http.get(api.productList, {params: {page: val, token: this.isLogin}})
          .then((response) => {
            that.$Spin.hide()
//            console.log(response.data.data)
            this.productList = response.data.data
            this.pagination.total = response.data.meta.pagination.total
            this.pagination.total_pages = response.data.meta.pagination.total_pages
            this.pagination.current_page = response.data.meta.pagination.current_page
          })
          .catch((error) => {
            that.$Spin.hide()
            console.error(error)
          })
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .home {
    background: #fafafa;
    min-height: calc(100vh - 50px);
  }

  .goods-list {
    padding: 10px 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
  }

  .goods-list li {
    float: left;
    width: 21%;
    margin: 10px 2%;
    background: #fff;
    font-size: 12px;
    transition: .5s all ease;
  }

  .goods-list li:hover {
    transform: translate3d(0, -3px, 0);
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.3);
  }

  .goods-list li img {
    width: 100%;
  }

  .intro {
    padding: 20px 10px;
    color: #333;
  }

  .intro .title {
    margin-bottom: 10px;
  }

  .intro .price {
    color: #f60
  }

  .pagin {
    font-size: 14px;
    display: flex;
    justify-content: center;
    padding-bottom: 20px;
  }

  @media screen and (max-width: 767px) {
    .goods-list li {
      width: 46%;
    }
  }
</style>
