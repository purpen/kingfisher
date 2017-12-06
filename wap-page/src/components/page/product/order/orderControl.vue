<template>
  <div class="order-control fullscreen">
    <h2>{{title}}</h2>
    <orderMenu @spanClick="clickHandler"></orderMenu>
    <section class="order-cont">
      <ul class="order-list">
        <li v-for="(ele, index) in orderList" class="order-item clearfix">
          <p class="order-head clearfix">
            <span class="fl startTime">{{ele.order_start_time}}</span>
            <span class="order-more fr">查看详情</span>
          </p>
          <div class="order-body">
            <ul class="skus-list">
              <li v-for="(d, i) in ele.orderSkus" class="clearfix module">
                <!--{{d}}-->
                <div class="sku-left fl">
                  <img :src="d.image" alt="d.sku_name">
                </div>
                <div class="sku-right fl">
                  <p class="sku-name">{{d.sku_name}}</p>
                  <p class="sku-amount">数量：{{d.quantity}}</p>
                  <p class="sku-price">￥{{d.price}}</p>
                </div>
              </li>
            </ul>
          </div>
          <div class="order-foot clearfix">
            <p class="order-total"><span>共计{{22}}件商品</span> <span>合计：￥{{175}}</span><span>(含运费￥{{6.00}})</span>
            </p>
            <p class="opt-btn clearfix">
              <span class="order-del fr" @click="del(ele.id)">删除订单</span>
            </p>
          </div>
        </li>
      </ul>
    </section>
    <Modal
      title="确认删除"
      v-model="modal"
      width="90%"
      :styles="{top: '20px'}"
      @on-ok="delorder">
      确认删除？
    </Modal>
  </div>
</template>
<script>
  import api from '@/api/api'
  import orderMenu from '@/components/page/product/order/orderMenu'
  export default {
    name: 'orderControl',
    data () {
      return {
        title: '',
        orderList: [],
        oid: 0,
        modal: false,
        delid: 0
      }
    },
    created () {
      this.title = this.$route.meta.title
      this.clickHandler()
    },
    methods: {
      clickHandler (i) {
        this.$Spin.show()
        this.oid = i
        const that = this
        this.$http.get(api.orderLists, {params: {page: 1, status: i, token: this.isLogin}})
          .then((res) => {
            this.$Spin.hide()
            if (res.data.meta.status_code === 200) {
              that.orderList = res.data.data
              for (let i of that.orderList) {
                i.order_start_time = i.order_start_time.split(' ')[0]
              }
            } else {
              that.$Message.error(res.data.meta.message)
            }
          })
          .catch((err) => {
            this.$Spin.hide()
            console.err(err)
          })
      },
      del (id) {
        this.delid = id
        this.modal = true
      },
      delorder () {
        this.$http.get(api.delorder, {params: {order_id: this.delid, token: this.isLogin}})
          .then((res) => {
            if (res.data.meta.status_code === 200) {
              this.clickHandler(this.oid)
            }
          })
          .catch((err) => {
            console.log(err)
          })
      }
    },
    components: {
      orderMenu
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    }
  }
</script>
<style scoped>
  .order-control {
    padding-bottom: 0;
  }

  h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
  }

  .order-list {
    overflow: hidden;
  }

  .order-list .order-item {
    padding-bottom: 15px;
    margin-bottom: 10px;
    border-bottom: 0.5px solid #e6e6e6;
    background: #fff;
  }

  .order-head {
    padding: 0 25px 0 15px;
    line-height: 45px;
    border-bottom: 0.5px solid #e6e6e6;
    position: relative;
  }

  .order-body {
    padding: 0 15px;
  }

  .module {
    padding: 15px 0;
    border-bottom: 0.5px solid #e6e6e6;
  }

  .skus-list .module:last-child {
    margin-bottom: 15px;
  }

  .sku-left img {
    width: 100px;
  }

  .sku-right {
    max-width: calc(100% - 100px);
    padding-left: 10px;
  }

  .sku-name {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    font-size: 15px;
    color: #222222;
    font-weight: 600;
    line-height: 20px;
  }

  .sku-amount {
    font-size: 12px;
    color: #666;
    line-height: 30px;
  }

  .sku-price {
    font-size: 15px;
    color: #BE8914;
    line-height: 30px;
  }

  .order-foot {
    padding: 0 15px;
    line-height: 2;
  }

  .order-total {
    text-align: right;
  }

  .opt-btn span {
    border: 0.5px solid #BE8914;
    border-radius: 2px;
    color: #BE8914;
    font-size: 12px;
    padding: 0 8px;
  }

  .order-more::after {
    display: block;
    position: absolute;
    content: "";
    width: 10px;
    height: 10px;
    border: 0.5px solid #ccc;
    border-bottom: none;
    border-left: none;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    right: 10px;
    top: 18px;
  }
</style>
