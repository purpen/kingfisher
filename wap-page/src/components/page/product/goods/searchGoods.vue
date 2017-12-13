<template>
  <div class="cover">
    <div class="cover-header clearfix">
      <span class="fr cancel" @click="searchCancel">取消</span>
      <div class="search">
        <input type="search" class="search-title" @blur="searchBlur(goods)"
               v-focus="focus" v-model="goods" ref="goods">
      </div>
    </div>
    <div class="cover-body">
      <section v-if="!searchList.length && !message">
        <Spin fix v-if="isloading"></Spin>
        <div class="most">
          <p>大家都在搜</p>
          <div class="tags">
            <span @click="searchClick('无人机')">无人机</span>
            <span>云马</span>
          </div>
        </div>
        <div class="history">
          <p>搜索历史</p>
        </div>
        <div class="tags">
          <span>云马</span>
          <span>无人机</span>
        </div>
      </section>
      <section class="search-list" v-if="searchList.length || message">
        <p class="donot-have">{{message}}</p>
        <ul v-if="searchList.length" class="goods-list clearfix">
          <li v-for="(d, index) in searchList" :key="index" ref="searchGoods">
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
      </section>
    </div>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    data () {
      return {
        searchList: [],
        goods: '',
        focus: true,
        message: '',
        isloading: false
      }
    },
    name: 'searchGoods',
    methods: {
      searchBlur (goods) {
        if (goods) {
          this.isloading = true
          this.$http.get(api.productSearch, {params: {name: goods, page: 1}}).then((res) => {
            if (res.data.meta.status_code === 200) {
              this.isloading = false
              if (res.data.data.length) {
                this.searchList = res.data.data
                this.message = ''
              } else {
                this.searchList = []
                this.message = '暂无此商品'
              }
            }
          }).catch((err) => {
            console.error(err)
          })
        } else {
          this.searchList = []
          this.message = ''
        }
      },
      searchCancel () {
        this.$router.push({name: 'home'})
      },
      searchClick (ele) {
        this.goods = ele
        this.searchBlur(ele)
      }
    },
    watch: {
      goods () {
        if (!this.goods) {
          this.searchList = []
          this.message = ''
        }
      }
    },
    mounted () {
      let self = this
      window.addEventListener('keydown', function (e) {
        if (e.keyCode === 13) {
          self.searchBlur(self.goods)
        }
      })
    }
  }
</script>
<style scoped>
  .cover {
    position: absolute;
    z-index: 100;
    width: 100%;
    min-height: 100vh;
    top: 0;
    left: 0;
    padding-bottom: 50px;
    background: #fafafa;
  }

  .home-header {
    position: absolute;
    top: -47px;
    left: 0;
    width: 100%;
    height: 44px;
    background: #fff;
    padding-left: 15px;
    overflow: hidden;
  }

  .donot-have {
    line-height: 50px;
    text-align: center;
  }

  .header-logo {
    width: 54px;
    height: 38px;
    background: url('../../../../assets/images/D3IN_logo.png') no-repeat center;
    margin-right: 8px;
  }

  .search {
    height: 44px;
    display: flex;
    align-items: center;
  }

  .search-title {
    width: 100%;
    line-height: 1;
    height: 30px;
    border: none;
    background: url("../../../../assets/images/icon/search.png") no-repeat left top rgba(230, 230, 230, 0.30);
    background-size: contain;
    border-radius: 15px;
    padding-left: 28px;
    padding-right: 8px;
    transition: .3s all ease;
    color: #666;
    font-size: 12px;
  }

  .search-title:focus {
  }

  .cover-header {
    background: #ffffff;
    padding-left: 15px;
    border-bottom: 1px solid #E6E6E6;
  }

  .cancel {
    padding: 0 8px;
    line-height: 44px;
  }

  .cover-body {
    position: relative;
  }

  .cover-body .most p, .cover-body .history p {
    padding-left: 15px;
    height: 40px;
    line-height: 40px;
  }

  .cover-body .tags {
    display: flex;
    flex-wrap: wrap;
    background: #ffffff;
    padding: 10px 15px;
    border-top: 1px solid #e6e6e6;
    border-bottom: 1px solid #e6e6e6;
  }

  .cover-body .tags span {
    font-size: 12px;
    line-height: 25px;
    padding: 0 10px;
    margin: 4px 10px 4px 0;
    border: 1px solid #e6e6e6;
    border-radius: 6px;
  }

  .search-list {
    padding: 0 15px;
    min-height: 400px;
  }

  .mail {
    width: 30px;
    height: 44px;
    margin-right: 8px;
    background: url("../../../../assets/images/icon/news.png") no-repeat left;
    background-size: contain;
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
