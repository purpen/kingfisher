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
  <address-management-shipping-address v-if="isShoShipping"></address-management-shipping-address>
  <address-management-savesuccess v-if="isShoShippingOk"></address-management-savesuccess>
  <address-management-shipping-address-new v-if="isShoShippingNew"></address-management-shipping-address-new>
  <address-management-savesuccess-new v-if="isShoShippingOkNew"></address-management-savesuccess-new>
</div>
</template>

<script>
import vMenu from '@/components/page/center/Menu'
import AddressManagementTable from '@/components/addressManagement/AddressManagementTable'
import AddressManagementShippingAddress from '@/components/addressManagement/AddressManagementShippingAddress'
import AddressManagementSavesuccess from '@/components/addressManagement/AddressManagementSavesuccess'
import AddressManagementShippingAddressNew from '@/components/addressManagement/AddressManagementShippingAddressNew'
import AddressManagementSavesuccessNew from '@/components/addressManagement/AddressManagementSavesuccessNew'
export default {
  name: 'addressManagementIndex',
  data () {
    return {
      Bus: this.$BusFactory(this), // bus方法
      management_index_beforeNumber: 2, // 已经创建了几个地址
      management_index_afterNumber: 5, // 最多能创建几个地址
      shipping_address: false, // 修改地址是否显示
      isShoShipping: false, // 显示修改地址弹框组件
      isShoShippingOk: false, // 显示修改地址成功提示
      isShoShippingNew: false, // 新增收货地址
      isShoShippingOkNew: false, // 新增收货地址确认
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
          town_id: 0 // 城镇／乡ID
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
          town_id: 0 // 城镇／乡ID
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
    AddressManagementTable,
    AddressManagementShippingAddress,
    AddressManagementSavesuccess,
    AddressManagementShippingAddressNew,
    AddressManagementSavesuccessNew
  },
  methods: {
    the_new_address: function () {
      let _this = this
      if (this.management_index_beforeNumber === 5) {
        this.$Message.warning('最多只能创建5个地址,请删除一个地址之后再重新创建')
      } else if (this.management_index_beforeNumber < 5) {
        this.isShoShippingNew = true
        setTimeout(function () {
          _this.Bus.$emit('address-management-shipping-address-new', 'change')
        }, 120)
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
      this.isShoShipping = true
      let _this = this
      setTimeout(function () {
        _this.Bus.$emit('address-management-shipping-address', em)
      }, 120)
    })
    this.Bus.$on('erp-address-management-setTheDefault', (em) => {
      // 默认地址
      console.log(em)
    })
    this.Bus.$on('AddressManagementShippingAddress_hide', (em) => {
      let _this = this
      // 关闭地址修改弹框
      if (em === 'hide') {
        setTimeout(function () {
          _this.isShoShipping = false
          _this.isShoShippingOk = true
          setTimeout(function () {
            _this.Bus.$emit('AddressManagementShippingAddress_hide_okshow', 'show')
          }, 300)
        }, 100)
      }
    })
    this.Bus.$on('AddressManagementShippingAddress_hide_hide', (em) => {
      let _this = this
      // 关闭地址修改弹框
      if (em === 'hide') {
        setTimeout(function () {
          _this.isShoShipping = false
        }, 100)
      }
    })
    this.Bus.$on('AddressManagementShippingAddress_hide_new', (em) => {
      let _this = this
      // 关闭新建地址修改弹框
      if (em === 'hide') {
        setTimeout(function () {
          _this.isShoShippingNew = false
          _this.isShoShippingOkNew = true
          setTimeout(function () {
            _this.Bus.$emit('AddressManagementShippingAddress_hide_okshow_new', 'show')
          }, 300)
        }, 100)
      }
    })
    this.Bus.$on('AddressManagementShippingAddress_hide_hide_new', (em) => {
      let _this = this
      // (取消)关闭新建地址地址修改弹框
      if (em === 'hide') {
        setTimeout(function () {
          _this.isShoShippingNew = false
        }, 100)
      }
    })
    this.Bus.$on('AddressManagementShippingAddress_address_row', (em) => {
      // 编辑收货地址
      console.log(em)
      if (em !== 1) {
        this.Bus.$emit('ddressManagementShippingAddress_address_oks', 0)
      } else {
        this.Bus.$emit('ddressManagementShippingAddress_address_oks', 1)
      }
      // 保存数据
//              self.$http.post(api.orderStore, row)
//                .then(function (response) {
//                  if (response.data.meta.status_code === 200) {
//                    self.$Message.success('操作成功！')
//                    self.$router.push({name: 'centerOrder'})
//                  } else {
//                    self.$Message.error(response.data.message)
//                  }
//                })
//                .catch(function (error) {
//                  self.$Message.error(error.message)
//                })
    })
    this.Bus.$on('AddressManagementShippingAddress_address_row_new', (em) => {
      // 新建收货地址
      console.log(em)
      if (em !== 1) {
        this.Bus.$emit('ddressManagementShippingAddress_address_oks_new', 0)
      } else {
        this.Bus.$emit('ddressManagementShippingAddress_address_oks_new', 1)
      }
      // 保存数据
//              self.$http.post(api.orderStore, row)
//                .then(function (response) {
//                  if (response.data.meta.status_code === 200) {
//                    self.$Message.success('操作成功！')
//                    self.$router.push({name: 'centerOrder'})
//                  } else {
//                    self.$Message.error(response.data.message)
//                  }
//                })
//                .catch(function (error) {
//                  self.$Message.error(error.message)
//                })
    })
    this.Bus.$emit('AddressManagementShippingAddress_hide_okHide', (em) => {
      // 关闭成功提示
      let _this = this
      setTimeout(function () {
        _this.isShoShippingOk = false
      }, 1500)
    })
    this.Bus.$emit('AddressManagementShippingAddress_hide_okHide_new', (em) => {
      // 关闭新建成功提示
      let _this = this
      setTimeout(function () {
        _this.isShoShippingOkNew = false
      }, 1500)
    })
  },
  watch: {

  }
}
</script>

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
