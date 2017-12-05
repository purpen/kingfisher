<template>
  <div class="home">
    <div class="container">
      <div class="banner">
        <ul v-if="productList.length" class="goods-list clearfix">
          <li v-for="(d, index) in productList" :key="index" ref="goods">
            <router-link :to="{name: 'GoodsShow', params: {id: d.id, current_page: pagination.current_page}}"
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
        <Page v-if="productList.length" :total="pagination.total"
              :current="pagination.current_page" size="small"
              class-name="pagin" @on-change="getProduct"
              :show-elevator="!isMob" :show-total="!isMob"
              :simple="isMob"></Page>
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
      isMob () {
        return this.$store.state.event.isMob
      },
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    created () {
      this.getProduct()
      this.$store.commit('INIT_PAGE')
    },
    mounted () {
      let that = this
      window.addEventListener('resize', () => {
        that.$store.commit('INIT_PAGE')
      })
    },
    methods: {
      getProduct (val = this.$route.params.current_page) {
        this.$Spin.show()
        this.$http.get(api.productList, {params: {page: val, token: this.isLogin}})
          .then((response) => {
            this.$Spin.hide()
            this.productList = response.data.data
            this.pagination.total = response.data.meta.pagination.total
            this.pagination.total_pages = response.data.meta.pagination.total_pages
            this.pagination.current_page = response.data.meta.pagination.current_page
          })
          .catch((error) => {
            this.$Spin.hide()
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
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    line-height: 1.5;
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

    .goods-list li:hover {
      transform: none;
      box-shadow: none;
    }
  }
</style>
