<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <!--
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>我的订单</Breadcrumb-item>
    </Breadcrumb>
    -->

    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="order"></v-menu>
      </Col>
      <Col :span="21">
        <div class="testTable">
          <table class="product-table">
            <tr class="product-tr">
              <td style="width: 40%;text-align: left;padding-left: 20px">订单详情</td>
              <td style="width: 10%;">收货人</td>
              <td style="width: 15%;">金额</td>
              <td style="width: 10%;">状态</td>
              <td style="width: 15%;">操作</td>
            </tr>
          </table>
          <div class="padding-l-r-20">
            <div class="border-b-c8">
              <table class="forTable">
                <tr class="sku-table-tr text-left color_999" style="margin-top: 16px;margin-bottom: 20px">2018-08-27 13：22 <span class="margin-l-30 margin-r-5">订单编号:</span> <span class="color_666">7884707442</span></tr>
                <tr class="padd-t-30">
                  <td class="sku-box" style="width: 40%">
                    <table class="sku-table">
                      <tr>
                        <td class="text-left padding-t-30">
                          <div class="sku-box-flex">
                            <img class="wid-80 margin-r-15" src="../../../../assets/images/home/banner/bannertest.png">
                            <div class="wid-158">
                              <p class="color_666 margin-b-10 font-12 lin-clamp-3">商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称</p>
                              <p class="color_666 font-12">白色</p>
                            </div>
                            <div style="flex: 1;text-align: right">
                              <p>x1</p>
                            </div>
                          </div>
                        </td>
                      </tr><tr>
                      <td class="text-left padding-t-30">
                        <div class="sku-box-flex">
                          <img class="wid-80 margin-r-15" src="../../../../assets/images/home/banner/bannertest.png">
                          <div class="wid-158">
                            <p class="color_666 margin-b-10 font-12">商品名称商品名称商品名称商品名称商品名称商品名称商品名称</p>
                            <p class="color_666 font-12">白色</p>
                          </div>
                          <div style="flex: 1;text-align: right">
                            <p>x1</p>
                          </div>
                        </div>
                      </td>
                    </tr>
                    </table>
                  </td>
                  <td  class="wid_15 border-l text-style-p-linhei text-style-p-color" style="width: 10%">
                    <p class="font-14 color_666">张三</p>
                  </td>
                  <td class="wid_15 border-l text-style-p-linhei" style="width: 15%">
                    <p class="font-14 color_333">总额:¥ <span>338.00</span></p>
                    <p class="color_666 font-12">在线支付</p>
                  </td>
                  <td class="wid_15 border-l text-style-p-linhei text-style-p-color" style="width: 10%">
                    <p class="font-12">已完成</p>
                    <!--<p>待付款</p>-->
                    <!--<p>待收货</p>-->
                    <!--<p>已取消</p>-->
                    <router-link :to="{name: 'orderDetails'}"><p class="font-12"></p>订单详情</router-link>
                  </td>
                  <td class="wid_15 border-l text-style-p-linhei text-style-p-color" style="width: 15%">
                    <div class="display-felx-c">
                      <span class="font-14 line-hei-1 color_ed3a display-flex-ju-center"><Icon type="ios-time-outline" />23:59:59</span>
                      <span class="margin-t-5 margin-b-5">取消订单</span>
                      <Button class="back_c8 button-style display-flex-ju-center">立即付款</Button>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div class="padding-l-r-20">
            <div class="border-b-c8">
              <table>
                <tr class="sku-table-tr text-left color_999" style="margin-top: 16px;margin-bottom: 20px">2018-08-27 13：22 <span class="margin-l-30 margin-r-5">订单编号:</span> <span class="color_666">7884707442</span></tr>
                <tr class="padd-t-30">
                  <td class="sku-box" style="width: 40%">
                    <table class="sku-table">
                      <tr>
                        <td class="text-left">
                          <div class="sku-box-flex">
                            <img class="wid-80 margin-r-15" src="../../../../assets/images/home/banner/bannertest.png">
                            <div class="wid-158">
                              <p class="color_666 margin-b-10 font-12">商品名称商品名称商品名称商品名称商品名称商品名称商品名称</p>
                              <p class="color_666 font-12">白色</p>
                            </div>
                            <div style="flex: 1;text-align: right">
                              <p>x1</p>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td  class="wid_15 border-l text-style-p-linhei" style="width: 10%">
                    <p class="font-14 color_666">张三</p>
                  </td>
                  <td class="wid_15 text-style-p-linhei" style="width: 15%">
                    <p class="font-14 color_333">总额:¥ <span>338.00</span></p>
                    <p class="color_666 font-12">在线支付</p>
                  </td>
                  <td class="wid_15 text-style-p-linhei" style="width: 10%">
                    <p class="font-12">已完成</p>
                    <p class="font-12">订单详情</p>
                  </td>
                  <td class="wid_15 text-style-p-linhei" style="width: 15%">
                    <div class="display-felx-c">
                      <Button class="button-style display-flex-ju-center">确认收货</Button>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <!--<div class="order-box padd-t-10">-->
          <!--<div class="center-menu-sub">-->
            <!--<div class="center-menu-sub-list">-->
              <!--<router-link :to="{name: 'centerOrder'}" active-class="false" :class="{'item': true, 'active': query.status === 0 ? true : false}">全部订单</router-link>-->
              <!--<router-link :to="{name: 'centerOrder', query: {status: 5}}" active-class="false" :class="{'item': true, 'active': query.status === 5 ? true : false}">待付款</router-link>-->
              <!--<router-link :to="{name: 'centerOrder', query: {status: 10}}" active-class="false" :class="{'item': true, 'active': query.status === 10 ? true : false}">待收货</router-link>-->
              <!--&lt;!&ndash;<router-link :to="{name: 'centerOrder', query: {status: 5}}" active-class="false" :class="{'item': true, 'active': query.status === 5 ? true : false}">待审核</router-link>&ndash;&gt;-->
              <!--<router-link :to="{name: 'centerOrder', query: {status: 8}}" active-class="false" :class="{'item': true, 'active': query.status === 8 ? true : false}">待发货</router-link>-->
              <!--&lt;!&ndash;<router-link :to="{name: 'centerOrder', query: {status: 20}}" active-class="false" :class="{'item': true, 'active': query.status === 20 ? true : false}">已完成</router-link>&ndash;&gt;-->
              <!--<router-link :to="{name: 'centerOrder', query: {status: -1}}" active-class="false" :class="{'item': true, 'active': query.status === -1 ? true : false}">已取消</router-link>-->
            <!--</div>-->
            <!--&lt;!&ndash;<div class="center-menu-sub-list right">&ndash;&gt;-->
              <!--&lt;!&ndash;<router-link :to="{name: 'centerOrderImportRecord'}" active-class="false" :class="{'item': true}"><i class="fa fa-area-chart" aria-hidden="true"></i> 导入记录</router-link>&ndash;&gt;-->
            <!--&lt;!&ndash;</div>&ndash;&gt;-->
          <!--</div>-->
          <!--<v-sub-menu></v-sub-menu>-->
          <!--<div class="order-list">-->
            <!--<Spin size="large" fix v-if="isLoading"></Spin>-->
            <!--<Table :columns="orderHead" :data="itemList"></Table>-->
            <!--<div class="blank20"></div>-->
            <!--<Page class="pager" :total="query.count" :current="query.page" :page-size="query.size" @on-change="handleCurrentChange" show-total></Page>-->
          <!--</div>-->
        <!--</div>-->
      </Col>
    </Row>
  </div>
</template>

<script>
import api from '@/api/api'
import '@/assets/js/date_format'
import rowView from '@/components/page/center/order/RowView'
import vSubMenu from '@/components/page/center/order/SubMenu'
import vMenu from '@/components/page/center/Menu'
export default {
  name: 'center_order_list',
  components: {
    vMenu,
    vSubMenu
  },
  data () {
    return {
      isLoading: false,
      uploadMsg: '只限上传exel csv格式文件',
      itemList: [],
      orderHead: [
        {
          title: '查看详情',
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
          width: 160,
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
          width: 140,
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
          width: 140,
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
        },
        {
          title: '操作',
          key: 'action',
          render: (h, params) => {
            return h('a', {
              style: {
                fontSize: '2.5rem'
              },
              on: {
                click: () => {
                  this.delBtn(params.row.id, params.index)
                }
              }
            }, [
              h('img', {
                attrs: {
                  src: require('@/assets/images/icon/delete.png')
                },
                style: {
                  width: '15%',
                  height: '15%'
                }
              })
            ])
          }
        }
      ],
      query: {
        page: 1,
        pageSize: 10,
        count: 0,
        sort: 1,
        type: 0,
        status: 0,
        test: null
      },
      msg: ''
    }
  },
  methods: {
    // 加载列表
    loadList () {
      const self = this
      self.query.page = parseInt(this.$route.query.page || 1)
      self.query.status = parseInt(this.$route.query.status || 0)
      self.isLoading = true
      self.$http.get(api.orders, {params: {page: self.query.page, per_page: self.query.pageSize, status: self.query.status}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          self.query.count = parseInt(response.data.meta.pagination.total)
          var itemList = response.data.data
          for (var i = 0; i < itemList.length; i++) {
            var d = itemList[i]
            itemList[i].order_start_time = d.order_start_time.date_format().format('yy-MM-dd hh:mm')
          } // endfor
          self.itemList = itemList
        } else {
          self.$Message.error(response.data.meta.message)
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        self.isLoading = false
      })
    },
    // 分页
    handleCurrentChange (currentPage) {
      this.query.page = currentPage
      this.$router.push({name: this.$route.name, query: {page: currentPage, status: this.query.status}})
    },
    // 删除订单
    delBtn (id, index) {
      this.$Modal.confirm({
        title: '确认操作',
        content: '<p>确认要删除当前订单?</p>',
        onOk: () => {
          const self = this
          self.$http.post(api.orderDestroy, {order_id: id})
          .then(function (response) {
            if (response.data.meta.status_code === 200) {
              self.$Message.success('删除成功!')
              self.itemList.splice(index, 1)
            }
          })
          .catch(function (error) {
            self.$Message.error(error.message)
          })
        },
        onCancel: () => {
        }
      })
    }
  },
  created: function () {
    this.loadList()
  },
  watch: {
    '$route' (to, from) {
      // 对路由变化作出响应...
      this.loadList()
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .testTable table {
    width: 100%;
    text-align: center;
  }

  .product-tr td {
    height: 36px;
    line-height: 36px;
    background:rgba(240,240,240,1);
  }

  .sku-table-tr {
    display: block;
    margin-top: 16px;
    margin-bottom: 33px;
  }

  .sku-box {
    padding-right: 20px;
  }
  .padding-t-30 {
    padding-top: 30px;
  }
  .sku-table :first-child td{
    padding: 0;
  }

  .sku-box-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .wid-80 {
    width: 80px;
    height: 80px;
  }

  .wid-158 {
    width: 158px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .height-82 {
    height: 82px;
    line-height: 82px;
  }

  .testTable th:first-child {
    text-align: left;
    width: 28%;
  }

  .order-box h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
    margin-bottom: 15px;
  }

  .wid_15 {
    width: 15%;
  }

  .padd-l-20 {
    padding-left: 20px;
  }

  .border-l {
    border-left: 1px solid rgba(240,240,240,1);
  }


  .text-style-p-linhei p {
    line-height: 2;
  }
  .text-style-p-color p {
    color: #666666;
  }

  .testTable :last-child .border-b-c8{
    border: none;
  }

  .back_c8 {
    background:rgba(240,240,240,1);
    border-color: rgba(200,200,200,1);
    color:rgba(102,102,102,1);
  }

  .padding-l-r-20 {
    padding-left: 20px;
  }

  .border-b-c8 {
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(200,200,200,1);
  }

  .display-felx-c {
    display: flex;
    flex-direction: column;
  }

  .display-flex-ju-center i {
    font-size: 16px;
    margin-right: 5px;
  }

  .line-hei-1 {
    line-height: 1;
  }

  .button-style {
    width: 90px;
    height: 30px;
    margin: 0 auto;
    border-radius: 0;
    font-size: 12px;
  }
</style>
