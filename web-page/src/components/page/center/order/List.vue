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
        <div class="order-box">
          <h3>全部订单</h3>
          <div class="center-menu-sub">
            <div class="center-menu-sub-list">
              <router-link :to="{name: 'centerOrder'}" active-class="false" :class="{'item': true, 'active': query.status === 0 ? true : false}">全部</router-link>
              <router-link :to="{name: 'centerOrder', query: {status: 5}}" active-class="false" :class="{'item': true, 'active': query.status === 5 ? true : false}">待审核</router-link>
              <router-link :to="{name: 'centerOrder', query: {status: 8}}" active-class="false" :class="{'item': true, 'active': query.status === 8 ? true : false}">待发货</router-link>
              <router-link :to="{name: 'centerOrder', query: {status: 10}}" active-class="false" :class="{'item': true, 'active': query.status === 10 ? true : false}">待收货</router-link>
              <router-link :to="{name: 'centerOrder', query: {status: 20}}" active-class="false" :class="{'item': true, 'active': query.status === 20 ? true : false}">已完成</router-link>
              <router-link :to="{name: 'centerOrder', query: {status: -1}}" active-class="false" :class="{'item': true, 'active': query.status === -1 ? true : false}">已关闭</router-link>

            </div>
            <!--<div class="center-menu-sub-list right">-->
              <!--<router-link :to="{name: 'centerOrderImportRecord'}" active-class="false" :class="{'item': true}"><i class="fa fa-area-chart" aria-hidden="true"></i> 导入记录</router-link>-->
            <!--</div>-->
          </div>
          <v-sub-menu></v-sub-menu>
          <div class="order-list">
            <Spin size="large" fix v-if="isLoading"></Spin>
            <Table :columns="orderHead" :data="itemList"></Table>
            <div class="blank20"></div>
            <Page class="pager" :total="query.count" :current="query.page" :page-size="query.size" @on-change="handleCurrentChange" show-total></Page>
          </div>
        </div>
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
                  width: '15%'
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
        console.log(response)
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

  .order-box {
  }

  .order-box h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
    margin-bottom: 15px;
  }
  .pager {
    float: right;
  }

</style>
