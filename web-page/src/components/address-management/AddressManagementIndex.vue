<template>
<div>
  <div class="container min-height350">
    <div class="blank20"></div>
    <Row :gutter="20">
      <Col :span="3" class="left-menu">
      <v-menu currentName="management_index"></v-menu>
      </Col>
      <Col :span="21">
      <div class="management-index-box">
        <h3>地址管理</h3>
        <Button type="ghost" @click="the_new_address()"><i class="fa fa-plus-square-o fa-1x" aria-hidden="true"></i> 新增收货地址</Button>
        <div class="management-index-remind">
          <Icon type="ios-information" />
          您以创建{{management_index_beforeNumber}}个收货地址,最多可创建{{management_index_afterNumber}}个
        </div>
        <div class="management-index-list">
          <Spin size="large" fix v-if="isLoading"></Spin>
          <div class="blank20"></div>
          <Table border :columns="myAddress" :data="dataTable"></Table>
        </div>
      </div>
      </Col>
    </Row>
  </div>
</div>
</template>

<style scoped>
.management-index-box h3{
  font-size: 1.8rem;
  color: #222;
  line-height: 2;
  margin-bottom: 15px;
}
.management-index-remind{
  margin-top: 16px;
  padding: 8px 48px 8px 38px;
  border: 1px solid #abdcff;
  background-color: #f0faff;
  position: relative;
}
.ivu-icon-ios-information{
  color: #2d8cf0;
  position: absolute;
  font-size: 16px;
  top: 8px;
  left: 17px;
}
.management-index-list{
  width: 100%;
  height: 300px;
}
</style>

<script>
import vMenu from '@/components/page/center/Menu'
export default {
  name: 'addressManagementIndex',
  data () {
    return {
      Bus: this.$BusFactory(this),
      management_index_beforeNumber: 2,
      management_index_afterNumber: 5,
      myAddress: [
        {
          title: '姓名',
          key: 'name',
          align: 'left'
        },
        {
          title: '收货人',
          key: 'theConsignee',
          align: 'left'
        },
        {
          title: '所在地区',
          key: 'region',
          align: 'left'
        },
        {
          title: '地址',
          key: 'address',
          width: 350,
          align: 'left'
        },
        {
          title: '手机',
          key: 'mobilePhone',
          align: 'left'
        },
        {
          title: '固定电话',
          key: 'fixedTelephone',
          align: 'left'
        },
        {
          title: '电子邮箱',
          key: 'email',
          align: 'left'
        },
        {
          title: '操作',
          key: 'operation',
          width: 150,
          align: 'left',
          render: (h, params) => {
            return h('div', [
              h('Button', {
                props: {
                  type: 'primary',
                  size: 'small'
                },
                style: {
                  marginRight: '5px'
                },
                on: {
                  click: () => {
                    this.show(params.index)
                  }
                }
              }, 'View'),
              h('Button', {
                props: {
                  type: 'error',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.remove(params.index)
                  }
                }
              }, 'Delete')
            ])
          }
        }
      ],
      dataTable: [
        {
          name: '刘旭阳',
          theConsignee: '刘旭阳',
          region: '北京朝阳',
          address: '朝阳区大西洋新城100栋1005室',
          mobilePhone: '15811678945',
          fixedTelephone: '010-12345678',
          email: '3206599456@qq.com'
        }
      ],
      isLoading: false
    }
  },
  components: {
    vMenu
  },
  methods: {
    the_new_address: function () {
      if (this.management_index_beforeNumber === 5) {
        this.$Message.warning('最多只能创建5个地址,请删除一个地址之后再重新创建')
      } else if (this.management_index_beforeNumber < 5) {

      } else if (this.management_index_beforeNumber > 5) {
        this.management_index_beforeNumber = 5
      }
    }
  },
  created: function () {

  },
  mounted () {

  },
  watch: {

  }
}
</script>
