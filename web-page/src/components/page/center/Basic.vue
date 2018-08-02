<template>
  <div class="container min-height350">
    <div class="blank20"></div>

    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="base"></v-menu>
      </Col>

      <Col :span="21">
        <div class="content">
          <Spin size="large" fix v-if="isLoading"></Spin>
          <!--<div class="item">-->
            <!--<h3>账户概况</h3>-->
            <!--<div>-->
              <!--<Row :gutter="24">-->
                <!--<Col :span="8">-->
                  <!--<div class="counter-item">-->
                    <!--<p class="des">合作产品</p>-->
                    <!--<p class="counter">{{ cooperationCount }}</p>-->
                  <!--</div>-->
                <!--</Col>-->
                <!--<Col :span="8">-->
                  <!--<div class="counter-item">-->
                    <!--<p class="des">销售额</p>-->
                    <!--<p class="counter">{{ saleCount }}</p>-->
                  <!--</div>-->
                <!--</Col>-->
                <!--<Col :span="8">-->
                  <!--<div class="counter-item">-->
                    <!--<p class="des">订单数</p>-->
                    <!--<p class="counter">{{ orderCount }}</p>-->
                  <!--</div>-->
                <!--</Col>-->
              <!--</Row>-->
            <!--</div>-->
          <!--</div>-->

          <div class="item">
            <h3>最新订单</h3>
            <div class="order-list">
              <template>
                <Table :columns="orderHead" :data="orderList"></Table>
              </template>
            </div>
          </div>

          <!--<div class="item">-->
            <!--<h3>最新上架产品</h3>-->
            <!--<div class="product-list">-->
              <!--<div class="product">-->
                <!--<div class="product-img">-->
                  <!--<img src="https://p4.taihuoniao.com/product/161121/5832c1d5fc8b12cc058b4646-1-p500x500.jpg" style="width: 100%;" />-->
                <!--</div>-->
                <!--<div class="product-content">-->
                  <!--<h3><a href="#">小蚁运动相机</a></h3>-->
                  <!--<p>¥ 150.00</p>-->
                  <!--<p>库存: 200</p>-->
                <!--</div>-->
              <!--</div>-->
              <!--<div class="product">-->
                <!--<div class="product-img">-->
                  <!--<img src="https://p4.taihuoniao.com//161216/58539eacfc8b12454e8b660e-1-p500x500.jpg" style="width: 100%;" />-->
                <!--</div>-->
                <!--<div class="product-content">-->
                  <!--<h3><a href="#">GoPro HERO4 Black 高清4K运动摄像机</a></h3>-->
                  <!--<p>¥ 450.00</p>-->
                  <!--<p>库存: 500</p>-->
                <!--</div>-->
              <!--</div>-->
            <!--</div>-->
          <!--</div>-->

          <!--<div class="item">-->
            <!--<h3>产品素材更新</h3>-->
            <!--<div class="product-list">-->
              <!--<div class="product">-->
                <!--<div class="product-img">-->
                  <!--<img src="https://p4.taihuoniao.com//161221/5859f61ffc8b12404e8b9a1f-1-p500x500.jpg" style="width: 100%;" />-->
                <!--</div>-->
                <!--<div class="product-content">-->
                  <!--<h3><a href="#">奶爸爸魔力塑臀椅S4</a></h3>-->
                  <!--<p>文字素材：2，图片：4，视频：2</p>-->
                  <!--<p>素材已更新</p>-->
                <!--</div>-->
              <!--</div>-->
              <!--<div class="product">-->
                <!--<div class="product-img">-->
                  <!--<img src="https://p4.taihuoniao.com//170427/59019d93fc8b12a9418c8852-1-p500x500.jpg" style="width: 100%;" />-->
                <!--</div>-->
                <!--<div class="product-content">-->
                  <!--<h3><a href="#">倍轻松智能手部按摩仪</a></h3>-->
                  <!--<p>文字素材：2，图片：4，视频：2</p>-->
                  <!--<p>素材已更新</p>-->
                <!--</div>-->
              <!--</div>-->
            <!--</div>-->
          <!--</div>-->

          <div class="item">
            <h3>智能推荐</h3>
            <div class="stick-product" v-if="itemList.length !== 0">
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
            </div>
            <div class="wid-200" v-else>
              <p class="text-center">暂无推荐...</p>
            </div>
          </div>


          <!--
          <div class="item">
            <h3>已下载素材</h3>
            <div class="product-list">
              <div class="product">
                <div class="product-img">
                  <img src="https://p4.taihuoniao.com//161221/5859f61ffc8b12404e8b9a1f-1-p500x500.jpg" style="width: 100%;" />
                </div>
                <div class="product-content">
                  <h3><a href="#">奶爸爸魔力塑臀椅S4</a></h3>

                </div>
              </div>
              <div class="product">
                <div class="product-img">
                  <img src="https://p4.taihuoniao.com//170427/59019d93fc8b12a9418c8852-1-p500x500.jpg" style="width: 100%;" />
                </div>
                <div class="product-content">
                  <h3><a href="#">倍轻松智能手部按摩仪</a></h3>

                </div>
              </div>
            </div>
          </div>
          -->

        </div>
      </Col>
    </Row>

  </div>
</template>

<script>
import api from '@/api/api'
import '@/assets/js/date_format'
import rowView from '@/components/page/center/order/RowView'
import vMenu from '@/components/page/center/Menu'
export default {
  name: 'center_basic',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      cooperationCount: '',
      saleCount: '',
      orderCount: '',
      itemList: [],
      orderHead: [
        {
          title: '订单操作',
          key: 'options',
          type: 'expand',
          width: 120,
          className: 'text-center',
          render: (h, params) => {
            return h(rowView, {
              props: {
                orderId: params.row.id
              }
            })
          }
        },
        {
          title: '状态',
          key: 'status_val'
        },
        {
          title: '订单号/时间',
          key: 'oid',
          width: 180,
          render: (h, params) => {
            return h('div', [
              h('p', {
                style: {
                  fontSize: '1.2rem'
                }
              }, params.row.number),
              h('p', {
                style: {
                  color: '#666',
                  fontSize: '1.2rem',
                  lineHeight: 2
                }
              }, params.row.order_start_time)
            ])
          }
        },
        {
          title: '买家',
          key: 'buyer_name'
        },
        // {
        //   title: '买家备注',
        //   key: 'buyer_summary'
        // },
        // {
        //   title: '卖家备注',
        //   key: 'seller_summary'
        // },
        {
          title: '物流/运单号',
          key: 'express',
          render: (h, params) => {
            return h('div', [
              h('p', {
                style: {
                  fontSize: '1.2rem'
                }
              }, params.row.logistics_name),
              h('p', {
                style: {
                  color: '#666',
                  fontSize: '1.2rem',
                  lineHeight: '2'
                }
              }, params.row.express_no)
            ])
          }
        },
        {
          title: '数量',
          key: 'count'
        },
        {
          title: '实付款/运费',
          key: 'pay',
          width: 150,
          render: (h, params) => {
            return h('div', [
              h('p', {
                style: {
                  color: '#C18D1D',
                  fontSize: '1.2rem',
                  lineHeight: '2'
                }
              }, '¥' + params.row.pay_money + '/' + params.row.freight)
            ])
          }
        }
        /**
        {
          title: '订单操作',
          key: 'options',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {size: 'small'},
                on: {
                  click: () => {
                    this.showDetail(params.row.id, params.index)
                  }
                }
              }, [
                h('span', {
                  style: {
                    verticalAlign: 'middle'
                  }
                }, '详情 '),
                h('i', {
                  class: 'fa fa-sort-desc',
                  style: {
                  }
                })
              ])
            ])
          }
        },
        **/
      ],
      orderList: [],
      msg: ''
    }
  },
  methods: {
    showDetail (id, index) {
    }
  },
  created: function () {
    let token = this.$store.state.event.token
    const self = this
    self.isLoading = true

    // 账户
    self.$http.get(api.surveyIndex, {})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        var item = response.data.data
        self.cooperationCount = item.cooperation_count
        self.saleCount = item.sales_volume
        self.orderCount = item.order_quantity
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })

    // 产品列表/智能推荐
    self.$http.get(api.productRecommendList, {params: {page: 1, per_page: 9, token: token}})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        if (response.data.data) {
          self.itemList = response.data.data
        }
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
    })

    // 订单列表
    self.$http.get(api.orders, {params: {page: 1, per_page: 10}})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        var orderList = response.data.data
        for (var i = 0; i < orderList.length; i++) {
          var d = orderList[i]
          orderList[i].order_start_time = d.order_start_time.date_format().format('yy-MM-dd hh:mm')
        } // endfor
        self.orderList = orderList
        console.log(response.data.data)
      } else {
        self.$Message.error(response.data.meta.message)
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .content {

  }

  .content .item {
    margin: 0 0 50px 0;
    clear: both;
  }

  .item h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
    margin-bottom: 15px;
  }

  .counter-item {
    background-color: #F7F7F7;
    text-align: center;
    padding: 20px;
  }

  .counter-item p {
    line-height: 1.8;
  }

  .counter-item .counter {
    font-size: 2rem;
    font-weight: 500;
  }

  .product {
    height: 125px;
    border-bottom: 1px solid #ccc;
    margin: 0 0 10px 0;

  }
  .product .product-img {
    float: left;
    width: 120px;
    overflow:hidden
  }

  .product .product-content {
    float: left;
    margin: 0 0 0 20px;
  }
  .product .product-content h3 {
    font-size: 1.6rem;
    padding: 0;
    margin: 0;
  }
  .product-list .product-content p {
    line-height: 2;
  }

  .stick-product .item {
    height: 290px;
    margin: 10px 0;
  }

  .stick-product .image-box {
    height: 220px;
    overflow: hidden;
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
