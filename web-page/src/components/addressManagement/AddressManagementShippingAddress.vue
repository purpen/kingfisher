<template>
  <Modal
    title="编辑收货地址"
    @on-ok="ok"
    @on-cancel="cancel">
    <Form :model="form" ref="form" :rules="formValidate" label-position="top">
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">收货地址</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="4">
        <Select v-model="province.id" number label-in-value @on-change="provinceChange" placeholder="请选择">
          <Option :value="d.value" v-for="(d, index) in province.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
        <Col :span="4">
        <Select v-model="city.id" number label-in-value @on-change="cityChange" placeholder="请选择" v-if="city.show">
          <Option :value="d.value" v-for="(d, index) in city.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
        <Col :span="4">
        <Select v-model="county.id" number label-in-value @on-change="countyChange" placeholder="请选择" v-if="county.show">
          <Option :value="d.value" v-for="(d, index) in county.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
        <Col :span="4">
        <Select v-model="town.id" number label-in-value @on-change="townChange" placeholder="请选择" v-if="town.show">
          <Option :value="d.value" v-for="(d, index) in town.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
      </Row>
    </Form>
  </Modal>
</template>

<style scoped>

</style>

<script>
    import api from '@/api/api'
    export default {
      name: 'AddressManagementShippingAddress',
      data () {
        const validateZip = (rule, value, callback) => {
          if (!(/^\d*?$/.test(value))) {
            callback(new Error('请输入正确邮编'))
          } else {
            if (value) {
              if (value.toString().length !== 6) {
                callback(new Error('必须为6位'))
              } else {
                callback()
              }
            } else {
              callback()
            }
          }
        }
        const validateTel = (rule, value, callback) => {
          if (!(/^\d*?$/.test(value))) {
            callback(new Error('请输入正确电话号'))
          } else {
            callback()
          }
        }
        const validatePhone = (rule, value, callback) => {
          if (value) {
            var reg = /^[1][3,4,5,7,8][0-9]{9}$/
            if (!reg.test(value)) {
              callback(new Error('手机号码格式不正确!'))
            } else {
              callback()
            }
          } else {
            callback(new Error('请输入手机号!'))
          }
        }
        return {
          Bus: this.$BusFactory(this), // bus方法
          form: {
            outside_target_id: '', // 站外订单号
            buyer_name: '',   // 收货人
            buyer_phone: '',  // 手机号
            buyer_tel: '', // 电话
            buyer_zip: '',    // 邮编
            buyer_address: '',    // 详细地址
            buyer_province: '',  // 省
            buyer_city: '',       // 市
            buyer_county: '',     // 区
            buyer_township: '',   // 镇
            buyer_summary: '', // 买家备注
            seller_summary: '', // 卖家备注
            sku_id_quantity: '',  // sku数量
            payment_type: '',     // 结算
            invoice_type: '',     // 发票类型
            test: ''
          },
          formValidate: {
            outside_target_id: [
              { required: false, message: '站外订单号不能为空', trigger: 'blur' }
            ],
            invoice_type: [
              { required: true, message: '请选择发票类型', trigger: 'change' }
            ],
            buyer_name: [
              { required: true, message: '收货人不能为空', trigger: 'blur' }
            ],
            buyer_phone: [
              { required: true, validator: validatePhone, trigger: 'blur' }
            ],
            buyer_tel: [
              { validator: validateTel, trigger: 'blur' }
            ],
            buyer_zip: [
              { validator: validateZip, trigger: 'blur' }
            ],
            payment_type: [
              { required: true, message: '请选择结算方式', trigger: 'blur' }
            ],
            buyer_address: [
              { required: true, message: '收货地址详情不能为空', trigger: 'blur' },
              { type: 'string', min: 4, message: '详细地址不能少于5个字符', trigger: 'blur' }
            ]
          },
          province: {
            id: 0,
            name: '',
            list: [],
            show: true
          },
          city: {
            id: 0,
            name: '',
            list: [],
            show: false
          },
          county: {
            id: 0,
            name: '',
            list: [],
            show: false
          },
          town: {
            id: 0,
            name: '',
            list: [],
            show: false
          }
        }
      },
      components: {},
      methods: {
        provinceChange (data) {
          if (data.value) {
            this.resetArea(1)
            this.province.id = data.value
            this.province.name = data.label
            this.form.buyer_province = data.label
            this.fetchCity(data.value, 2)
          }
        },
        cityChange (data) {
          if (data.value) {
            this.resetArea(2)
            this.city.id = data.value
            this.city.name = data.label
            this.form.buyer_city = data.label
            this.fetchCity(data.value, 3)
          }
        },
        countyChange (data) {
          if (data.value) {
            this.resetArea(3)
            this.county.id = data.value
            this.county.name = data.label
            this.form.buyer_county = data.label
            this.fetchCity(data.value, 4)
          }
        },
        townChange (data) {
          if (data.value) {
            this.town.id = data.value
            this.town.name = data.label
            this.form.buyer_township = data.label
          }
        },
        // 收货地址市
        fetchCity (value, layer) {
          const self = this
          self.$http.get(api.orderFetchCity, {params: {value: value, layer: layer}})
            .then(function (response) {
              if (response.data.meta.status_code === 200) {
                var itemList = response.data.data
                if (itemList.length > 0) {
                  if (layer === 1) {
                    self.province.list = itemList
                  } else if (layer === 2) {
                    self.city.list = itemList
                    self.city.show = true
                  } else if (layer === 3) {
                    self.county.list = itemList
                    self.county.show = true
                  } else if (layer === 4) {
                    self.town.list = itemList
                    self.town.show = true
                  }
                }
                // console.log(response.data.data)
              } else {
                self.$Message.error(response.data.meta.message)
              }
            })
            .catch(function (error) {
              self.$Message.error(error.message)
            })
        },
        // 清空城市对象
        resetArea (type) {
          switch (type) {
            case 1:
              this.city = this.areaMode()
              this.county = this.areaMode()
              this.town = this.areaMode()
              this.form.buyer_city = this.form.buyer_county = this.form.buyer_township = ''
              break
            case 2:
              this.county = this.areaMode()
              this.town = this.areaMode()
              this.form.buyer_county = this.form.buyer_township = ''
              break
            case 3:
              this.town = this.areaMode()
              this.form.buyer_township = ''
              break
          }
        },
        areaMode () {
          var mode = {
            id: 0,
            name: '',
            list: [],
            show: false
          }
          return mode
        }
      },
      created: function () {
        let self = this
        let token = this.$store.state.event.token
        self.$http.get(api.orderCity, {params: {token: token}})
          .then(function (response) {
            if (response.data.meta.status_code === 200) {
              if (response.data.data) {
                self.province.list = response.data.data
                // self.fetchCity(token, 2)
              }
            }
          })
      },
      mounted () {
        this.provinceChange({value: 11})
        this.cityChange({value: 870})
        this.countyChange({value: 875})
        this.townChange({value: 14360})
      },
      watch: {}
    }
</script>
