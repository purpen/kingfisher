<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <!--
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>导入记录</Breadcrumb-item>
    </Breadcrumb>
    -->
    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="order"></v-menu>
      </Col>

      <Col :span="21">
        <div class="order-box">
          <h3>导入记录</h3>

          <v-sub-menu></v-sub-menu>
          <div class="order-list">
            <Spin size="large" fix v-if="isLoading"></Spin>
            <Table :columns="orderHead" :data="itemList"></Table>
            <div class="blank20"></div>
            <Page class="pager" :total="query.count" :current="query.page" :page-size="query.pageSize" @on-change="handleCurrentChange" show-total></Page>
          </div>

        </div>
      </Col>
    </Row>
  </div>
</template>

<script>
import api from '@/api/api'
import '@/assets/js/date_format'
import vSubMenu from '@/components/page/center/order/SubMenu'
import vFailRecord from '@/components/page/center/order/FailRecord'
import vMenu from '@/components/page/center/Menu'
export default {
  name: 'center_order_import_record',
  components: {
    vMenu,
    vSubMenu,
    vFailRecord
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
          width: 30,
          render: (h, params) => {
            return h(vFailRecord, {
              props: {
                row: params.row
              }
            })
          }
        },
        {
          title: '文件名',
          key: 'file_name',
          width: 150
        },
        {
          title: '大小',
          key: 'file_size_label'
        },
        {
          title: '总条数',
          key: 'total_count'
        },
        {
          title: '成功数',
          key: 'success_count'
        },
        {
          title: '失败数',
          key: 'fail_count',
          render: (h, params) => {
            var red = ''
            if (params.row.fail_count > 0) {
              red = 'red'
            }
            return h('p', [
              h('p', {
                style: {
                  color: red
                }
              }, params.row.fail_count)
            ])
          }
        },
        {
          title: '状态',
          key: 'status_label'
        },
        {
          title: '创建时间',
          key: 'created_at',
          width: 130
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
                  width: '20%'
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
      self.$http.get(api.fileRecords, {params: {page: self.query.page, per_page: self.query.pageSize}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          self.query.count = parseInt(response.data.meta.pagination.total)
          var itemList = response.data.data
          for (var i = 0; i < itemList.length; i++) {
            var d = itemList[i]

            var k = 1024
            var sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
            var m = Math.floor(Math.log(parseInt(d.file_size)) / Math.log(k))
            itemList[i]['file_size_label'] = (parseInt(d.file_size) / Math.pow(k, m)).toFixed(1) + ' ' + sizes[m]
            if (parseInt(d.status) === 0) {
              itemList[i].status_label = '进行中'
            } else if (parseInt(d.status) === 1) {
              itemList[i].status_label = '已完成'
            } else if (parseInt(d.status) === 2) {
              itemList[i].status_label = '失败'
            }
            itemList[i].fail_count = parseInt(d.no_sku_count) + parseInt(d.repeat_outside_count) + parseInt(d.null_field_count) + parseInt(d.sku_storage_quantity_count)
            itemList[i].created_at = d.created_at.date_format().format('yy-MM-dd hh:mm')
          } // endfor
          self.itemList = itemList
          console.log(response.data.data)
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
      this.$router.push({name: this.$route.name, query: {page: currentPage}})
    },
    // 删除记录
    delBtn (id, index) {
      const self = this
      self.$http.post(api.fileRecordsDestroy, {id: id})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          self.$Message.success('删除成功!')
          self.itemList.splice(index, 1)
        } else {
          self.$Message.error(response.data.meta.message)
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
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
