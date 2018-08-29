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
        <Button @click.native="the_new_address()"><i class="fa fa-plus-square-o fa-1x" aria-hidden="true"></i> 新增收货地址</Button>
        <div class="management-index-remind">
          <Icon type="ios-information-circle" />
          您以创建{{management_index_beforeNumber}}个收货地址,最多可创建{{management_index_afterNumber}}个
        </div>
        <div class="management-index-list">
          <Spin size="large" fix v-if="isLoading"></Spin>
          <div class="blank20"></div>
          <address-management-table :dataTable="dataTable"></address-management-table>
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
.ivu-icon-ios-information-circle{
  color: #2d8cf0;
  position: absolute;
  font-size: 16px;
  top: 8px;
  left: 17px;
}
.management-index-list{
  width: 100%;
  min-height: 300px;
  padding-bottom: 50px;
}
</style>

<script>
import vMenu from '@/components/page/center/Menu'
import AddressManagementTable from '@/components/addressManagement/AddressManagementTable'
export default {
  name: 'addressManagementIndex',
  data () {
    return {
      Bus: this.$BusFactory(this), // bus方法
      management_index_beforeNumber: 2, // 已经创建了几个地址
      management_index_afterNumber: 5, // 最多能创建几个地址
      dataTable: [
        {
          name: '刘旭阳',
          theConsignee: '刘旭阳',
          region: '北京朝阳',
          address: '朝阳区大西洋新城100栋1005室',
          mobilePhone: '15811678945',
          fixedTelephone: '010-12345678',
          email: '3206599456@qq.com',
          state: '1',
          ids: 'asdk123',
          zip: '101500', // 邮编
          province_id: 11, // 省份ID
          city_id: 870, // 城市ID
          county_id: 875, // 区县ID
          town_id: 14360 // 城镇／乡ID
        },
        {
          name: '刘旭阳0',
          theConsignee: '刘旭阳0',
          region: '北京朝阳0',
          address: '朝阳区大西洋新城100栋1005室0',
          mobilePhone: '158116789450',
          fixedTelephone: '010-123456780',
          email: '3206599456@qq.com0',
          state: '0',
          ids: '1234567',
          zip: '101500', // 邮编
          province_id: 11, // 省份ID
          city_id: 870, // 城市ID
          county_id: 875, // 区县ID
          town_id: 14360 // 城镇／乡ID
        },
        {
          name: '刘旭阳0',
          theConsignee: '刘旭阳0',
          region: '北京朝阳0',
          address: '朝阳区大西洋新城100栋1005室0',
          mobilePhone: '158116789450',
          fixedTelephone: '010-123456780',
          email: '3206599456@qq.com0',
          state: '0',
          ids: '1234567',
          zip: '101500', // 邮编
          province_id: 11, // 省份ID
          city_id: 870, // 城市ID
          county_id: 875, // 区县ID
          town_id: 14360 // 城镇／乡ID
        },
        {
          name: '刘旭阳0',
          theConsignee: '刘旭阳0',
          region: '北京朝阳0',
          address: '朝阳区大西洋新城100栋1005室0',
          mobilePhone: '158116789450',
          fixedTelephone: '010-123456780',
          email: '3206599456@qq.com0',
          state: '0',
          ids: '1234567',
          zip: '101500', // 邮编
          province_id: 11, // 省份ID
          city_id: 870, // 城市ID
          county_id: 875, // 区县ID
          town_id: 14360 // 城镇／乡ID
        },
        {
          name: '刘旭阳0',
          theConsignee: '刘旭阳0',
          region: '北京朝阳0',
          address: '朝阳区大西洋新城100栋1005室0',
          mobilePhone: '158116789450',
          fixedTelephone: '010-123456780',
          email: '3206599456@qq.com0',
          state: '0',
          ids: '1234567',
          zip: '101500', // 邮编
          province_id: 11, // 省份ID
          city_id: 870, // 城市ID
          county_id: 875, // 区县ID
          town_id: 14360 // 城镇／乡ID
        }
      ], // 请求回来的地址参数
      isLoading: false // loading
    }
  },
  components: {
    vMenu,
    AddressManagementTable
  },
  methods: {
    the_new_address: function () {
      if (this.management_index_beforeNumber === 5) {
        this.$Message.warning('最多只能创建5个地址,请删除一个地址之后再重新创建')
      } else if (this.management_index_beforeNumber < 5) {
        console.log(this.dataTable.length)
      } else if (this.management_index_beforeNumber > 5) {
        this.management_index_beforeNumber = 5
      }
    }
  },
  created: function () {

  },
  beforeMount () {

  },
  mounted () {
    this.Bus.$on('erp-address-management-deletion', (em) => {
      // 删除地址
      console.log(em)
    })
    this.Bus.$on('erp-address-management-modifyThe', (em) => {
      // 修改地址
      console.log(
        em.name,
        em.theConsignee,
        em.region,
        em.address,
        em.mobilePhone,
        em.fixedTelephone,
        em.email,
        em.state,
        em.ids
      )
    })
    this.Bus.$on('erp-address-management-setTheDefault', (em) => {
      // 默认地址
      console.log(em)
    })
  },
  watch: {

  }
}
</script>
