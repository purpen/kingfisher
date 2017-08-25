<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>我的订单</Breadcrumb-item>
    </Breadcrumb>
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
      </div>
      <div class="tools">
        <Button type="ghost" @click="createBtn"><i class="fa fa-plus-square-o fa-1x" aria-hidden="true"></i> 创建订单</Button>
        <Button type="ghost" @click="exportModal = true"><i class="fa fa-cloud-upload" aria-hidden="true"></i> 导入订单</Button>
        <a class="down-mode" href="https://kg.erp.taihuoniao.com/order/thn_order_mode.csv"><i class="fa fa-download" aria-hidden="true"></i> 下载太火鸟订单格式文件</a>
      </div>
      <div class="order-list">
        <Spin size="large" fix v-if="isLoading"></Spin>
        <Table :columns="orderHead" :data="itemList"></Table>
        <div class="blank20"></div>
        <Page class="pager" :total="query.count" :current="query.page" :page-size="query.size" @on-change="handleCurrentChange" show-total></Page>
      </div>

    </div>


    <Modal v-model="exportModal" width="360" class="no-footer">
        <p slot="header" style="text-align:center">
            <span>导入订单</span>
        </p>
        <div class="export-box">
          <Upload
            :action="uploadUrl"
            name="file"
            :data="{excel_type: fileType, token: currentToken}"
            :format="['csv','excel', 'xlsx']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :on-preview="handlePreview"
            :on-success="handleSuccess"
            :on-error="handleError"
            :show-upload-list="false"
            :before-upload="handleBefore"
            :on-progress="handleProgress"
            >
            <Button type="primary">上传文件</Button>
          </Upload>
          <p class="up-des">{{ uploadMsg }}</p>
          <p class="order-type"><span>——————&nbsp;&nbsp;</span>请选择订单格式类型<span>&nbsp;&nbsp;——————</span></p>

          <Radio-group v-model="fileType">
              <Radio label="1">太火鸟</Radio>
              <Radio label="2">京东</Radio>
              <Radio label="3">淘宝</Radio>
          </Radio-group>

        </div>

    </Modal>
    
  </div>
</template>

<script>
import api from '@/api/api'
import '@/assets/js/date_format'
import rowView from '@/components/page/center/order/RowView'
export default {
  name: 'center_order_list',
  data () {
    return {
      isLoading: false,
      exportModal: false,
      fileType: 1,
      uploadUrl: process.env.API_ROOT + api.orderExcel,
      currentToken: this.$store.state.event.token,
      uploadMsg: '只限上传exel csv格式文件',
      itemList: [],
      orderHead: [
        {
          title: '订单操作',
          key: 'options',
          type: 'expand',
          width: 50,
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
        {
          title: '买家备注',
          key: 'buyer_summary'
        },
        {
          title: '卖家备注',
          key: 'seller_summary'
        },
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
      ],
      query: {
        page: 1,
        pageSize: 20,
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
    // 创建订单
    createBtn () {
      this.$router.push({name: 'centerOrderSubmit'})
    },
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
          // console.log(response.data.data)
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
    // 上传之前钩子
    handleBefore (file) {
    },
    // 导入文件格式钩子
    handleFormatError (file, fileList) {
      this.$Message.error('文件格式不正确!')
      return false
    },
    // 文件大小钩子
    handleMaxSize (file, fileList) {
      this.$Message.error('文件大小不能超过2M!')
      return false
    },
    // 文件上传钩子
    handlePreview (file) {
    },
    // 上传成功构子
    handleSuccess (response, file, fileList) {
      console.log(response)
      this.uploadMsg = '只限上传exel csv格式文件'
      if (response.meta.status_code === 200) {
        this.$Message.success('导入成功!')
        this.$router.push({name: this.$route.name})
        this.exportModal = false
      } else {
        this.$Message.error(response.meta.message)
        return false
      }
    },
    // 上传进行中钩子
    handleProgress (event, file, fileList) {
      this.uploadMsg = '上传中...'
    },
    // 上传失败钩子
    handleError (error, file, fileList) {
      this.$Message.error(error)
      this.uploadMsg = '只限上传exel csv格式文件'
      return false
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
    margin: 20px 0 0 0;
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
  .tools {
    margin: 10px 0;
  }
  .tools button {
    margin-right: 10px;
  }
  a.down-mode {
    color: #C18D1D;
  }
  .export-box {
    text-align: center;
    padding-bottom: 20px;
  }
  .export-box p {
    font-size: 1.2rem;
    line-height: 2.5;
  }
  .export-box .up-des {
    color: #777;
  }
  .export-box .order-type span {
    color: #ccc;
  }

</style>
