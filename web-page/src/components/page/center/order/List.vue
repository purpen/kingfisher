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
              <td style="width: 35%;text-align: left;padding-left: 20px">订单详情</td>
              <td style="width: 15%;">收货人</td>
              <td style="width: 15%;">金额</td>
              <td style="width: 15%;">状态</td>
              <td style="width: 15%;">操作</td>
            </tr>
          </table>
          <table>
            <tr class="padd-l-20 sku-table-tr text-left color_999" style="margin-top: 16px">2018-08-27 13：22 <span class="margin-l-30 margin-r-5">订单编号:</span> <span class="color_666">7884707442</span></tr>
            <tr>
              <td class="sku-box" style="width: 35%">
                <table class="sku-table">
                  <tr>
                    <td class="text-left">
                      <div class="sku-box-flex">
                        <img class="wid-80 margin-r-15" src="../../../../assets/images/product_500.png">
                        <div class="wid-158">
                          <p class="color_666 margin-b-10 font-12">商品名称商品名称商品名称商品名称商品名称商品名称商品名称</p>
                          <p class="color_666 font-12">白色</p>
                        </div>
                        <div style="flex: 1;text-align: right">
                          <p>x1</p>
                        </div>
                      </div>
                    </td>
                  </tr><tr>
                  <td class="text-left">
                    <div class="sku-box-flex">
                      <img class="wid-80 margin-r-15" src="../../../../assets/images/product_500.png">
                      <div class="wid-158">
                        <p class="color_666 margin-b-10 font-12">商品名称商品名称商品名称商品名称商品名称商品名称商品名称</p>
                        <p class="color_666 font-12">白色</p>
                      </div>
                      <div style="flex: 1;text-align: right">
                        <p>x1</p>
                      </div>
                    </div>
                  </td>
                </tr><tr>
                  <td class="text-left">
                    <div class="sku-box-flex">
                      <img class="wid-80 margin-r-15" src="../../../../assets/images/product_500.png">
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
              <td  class="wid_15 border-l">
                <p class="height-82">张三</p>
              </td>
              <td class="wid_15">
                <p class="height-82">金额</p>
              </td>
              <td class="wid_15">
                <p class="height-82">状态</p>
              </td>
              <td class="wid_15">
                <p class="height-82">操作</p>
              </td>
            </tr>
          </table>

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
    padding-left: 20px;
    padding-right: 20px;
  }

  .padding-t-67 {
    padding-top: 67px;
  }

  .sku-box-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 25px;
  }

  .text-left:first-child {
    margin: 0;
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

  .padd-t-18 {
    padding-top: 67px;
  }

  .padd-l-20 {
    /*padding-left: 20px;*/
  }
  .wid_15 {
    width: 15%;
  }

  .padd-l-20 {
    padding-left: 20px;
  }

  .border-l {
    border-left: 1px solid red;
  }
</style>
