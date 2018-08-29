<template>
<div>
  <Modal
    title="新增收货地址"
    v-model="bounced"
    :styles="{top: '30px'}"
    width="720"
    :mask-closable="false"
    :closable="false"
    class-name="vertical-center-modal AddressManagementShippingAddress"
    >
    <Form :model="form" ref="form" :rules="formValidate" label-position="top">
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">收货人</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <FormItem prop="buyer_name">
          <Input v-model="form.buyer_name" placeholder=""></Input>
        </FormItem>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">收货地址</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content margin_bottom_top">
        <Col :span="6">
        <Select v-model="province.id" number label-in-value @on-change="provinceChange" placeholder="请选择">
          <Option :value="d.value" v-for="(d, index) in province.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
        <Col :span="6">
        <Select v-model="city.id" number label-in-value @on-change="cityChange" placeholder="请选择" v-if="city.show">
          <Option :value="d.value" v-for="(d, index) in city.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
        <Col :span="6">
        <Select v-model="county.id" number label-in-value @on-change="countyChange" placeholder="请选择" v-if="county.show">
          <Option :value="d.value" v-for="(d, index) in county.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
        <Col :span="6">
        <Select v-model="town.id" number label-in-value @on-change="townChange" placeholder="请选择" v-if="town.show">
          <Option :value="d.value" v-for="(d, index) in town.list" :key="index">{{ d.label }}</Option>
        </Select>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">详细收货地址</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="24">
        <FormItem label="" prop="buyer_address">
          <Input v-model="form.buyer_address" type="textarea" placeholder="详细地址"></Input>
        </FormItem>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">手机号</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <FormItem prop="buyer_phone">
          <Input v-model="form.buyer_phone" placeholder=""></Input>
        </FormItem>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">电话号</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <FormItem prop="buyer_tel">
          <Input v-model="form.buyer_tel" placeholder=""></Input>
        </FormItem>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">邮编</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <FormItem prop="buyer_zip">
          <Input v-model="form.buyer_zip" placeholder=""></Input>
        </FormItem>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <p class="form-label">邮箱</p>
        </Col>
      </Row>
      <Row :gutter="10" class="content">
        <Col :span="8">
        <FormItem  prop="email">
          <Input v-model="form.email" placeholder=""></Input>
        </FormItem>
        </Col>
      </Row>
    </Form>
    <div class="modal-footer">
      <Button type="text" @click.native="cancel" :disabled="disabled">取消</Button>
      <Button type="primary" @click.native="asyncOK('form')" :loading="loading">确定</Button>
    </div>
  </Modal>
</div>
</template>

<script>
    import api from '@/api/api'
    export default {
      name: 'AddressManagementShippingAddress',
      data () {
        const validateZip = (rule, value, callback) => {
          if (value) {
            if (!(/^\d*?$/.test(value))) {
              callback(new Error('请输入正确邮编'))
              this.loading = false
              this.disabled = false
            } else {
              if (value) {
                if (value.toString().length !== 6) {
                  callback(new Error('必须为6位'))
                  this.loading = false
                  this.disabled = false
                } else {
                  callback()
                }
              } else {
                callback()
              }
            }
          } else {
            callback(new Error('请输入邮编'))
          }
        }
        const validateTel = (rule, value, callback) => {
          if (value) {
            if (!(/0\d{2,3}-\d{7,8}/.test(value))) {
              callback(new Error('请输入正确电话号'))
              this.loading = false
              this.disabled = false
            } else {
              callback()
            }
          } else {
            callback()
          }
        }
        const validatePhone = (rule, value, callback) => {
          if (value) {
            var reg = /^[1][3,4,5,7,8][0-9]{9}$/
            if (!reg.test(value)) {
              callback(new Error('手机号码格式不正确!'))
              this.loading = false
              this.disabled = false
            } else {
              callback()
            }
          } else {
            callback(new Error('请输入手机号!'))
            this.loading = false
            this.disabled = false
          }
        }
        const valdateEmail = (rule, value, callback) => {
          if (value) {
            var emails = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/
            if (!emails.test(value)) {
              callback(new Error('邮箱格式不正确!'))
              this.loading = false
              this.disabled = false
            } else {
              callback()
            }
          } else {
            callback(new Error('请输入邮箱号!'))
            this.loading = false
            this.disabled = false
          }
        }
        return {
          Bus: this.$BusFactory(this), // bus方法
          bounced: false, // 弹框是否显示
          loading: false, // 旋转等待
          disabled: true, // 点击按钮误触发
          form: {
            buyer_name: '',   // 收货人
            buyer_phone: '',  // 手机号
            buyer_tel: '', // 电话
            buyer_zip: '',    // 邮编
            buyer_address: '',    // 详细地址
            buyer_province: '',  // 省
            buyer_city: '',       // 市
            buyer_county: '',     // 区
            buyer_township: '',   // 镇
            email: '', // 邮箱
            ids: '' // 地址id
          },
          formValidate: {
            buyer_name: [
              { required: true, message: '收货人不能为空', trigger: 'blur' }
            ],
            buyer_phone: [
              { required: true, validator: validatePhone, trigger: 'blur' }
            ],
            buyer_zip: [
              { required: true, validator: validateZip, trigger: 'blur' }
            ],
            buyer_address: [
              { required: true, message: '收货地址详情不能为空', trigger: 'blur' },
              { type: 'string', min: 4, message: '详细地址不能少于5个字符', trigger: 'blur' }
            ],
            email: [
              {required: true, validator: valdateEmail, trigger: 'blur'}
            ],
            buyer_tel: [
              { required: true, validator: validateTel, trigger: 'blur' }
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
            this.form.buyer_province = data.value
//              data.label
            this.fetchCity(data.value, 2)
          }
        },
        cityChange (data) {
          if (data.value) {
            this.resetArea(2)
            this.city.id = data.value
            this.city.name = data.label
            this.form.buyer_city = data.value
//              data.label
            this.fetchCity(data.value, 3)
          }
        },
        countyChange (data) {
          if (data.value) {
            this.resetArea(3)
            this.county.id = data.value
            this.county.name = data.label
            this.form.buyer_county = data.value
//              data.label
            this.fetchCity(data.value, 4)
          }
        },
        townChange (data) {
          if (data.value) {
            this.town.id = data.value
            this.town.name = data.label
            this.form.buyer_township = data.value
//              data.label
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
        },
        asyncOK (ruleName) { // 确定操作
          const self = this
          this.$refs[ruleName].validate((valid) => {
            let reg = /^[1][3,4,5,7,8][0-9]{9}$/
            let sz = /^\d*?$/
            let emails = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/
            let bable = /0\d{2,3}-\d{7,8}/
            if (self.form.buyer_zip.length < 6 || !sz.test(self.form.buyer_zip)) {
              self.disabled = false
              self.loading = false
              console.log(1)
              return false
            } else if (self.form.buyer_name === '' || self.form.buyer_name === null || self.form.buyer_name === undefined || self.form.buyer_name === 'undefined') {
              self.disabled = false
              self.loading = false
              console.log(2)
              return false
            } else if (self.form.buyer_phone === '' || self.form.buyer_phone === null || self.form.buyer_phone === undefined || self.form.buyer_phone === 'undefined' || !reg.test(self.form.buyer_phone)) {
              self.disabled = false
              self.loading = false
              console.log(3)
              return false
            } else if (self.form.buyer_address === '' || self.form.buyer_address === null || self.form.buyer_address === undefined || self.form.buyer_address === 'undefined' || self.form.buyer_address.length < 5) {
              self.disabled = false
              self.loading = false
              console.log(4)
              return false
            } else if (self.form.email === '' || self.form.email === null || self.form.email === undefined || self.form.email === 'undefined' || !emails.test(self.form.email)) {
              self.disabled = false
              self.loading = false
              console.log(5)
              return false
            } else if (self.form.buyer_tel === '' || self.form.buyer_tel === null || self.form.buyer_tel === undefined || self.form.buyer_tel === 'undefined') {
              if (!bable.test(self.form.buyer_tel)) {
                self.disabled = false
                self.loading = false
                console.log(6)
                return false
              }
            }
            self.disabled = true
            self.loading = true
            if (valid) {
              if (!self.form.buyer_province || !self.form.buyer_city || !self.form.buyer_county) {
                self.$Message.error('请选择所在地区!')
                self.disabled = false
                self.loading = false
                return false
              }
              var row = {
                outside_target_id: self.form.outside_target_id,
                buyer_name: self.form.buyer_name,
                buyer_tel: self.form.buyer_tel,
                buyer_phone: self.form.buyer_phone,
                buyer_zip: self.form.buyer_zip,
                buyer_province: self.form.buyer_province,
                buyer_city: self.form.buyer_city,
                buyer_county: self.form.buyer_county,
                buyer_township: self.form.buyer_township || '',
                buyer_address: self.form.buyer_address,
                email: self.form.email
              }
              this.Bus.$emit('AddressManagementShippingAddress_address_row_new', row)
            } else {
              return
            }
          })
        },
        cancel () { // 取消操作
          this.bounced = false
          this.form = {
            buyer_name: '',   // 收货人
            buyer_phone: '',  // 手机号
            buyer_tel: '', // 电话
            buyer_zip: '',    // 邮编
            buyer_address: '',    // 详细地址
            buyer_province: '',  // 省
            buyer_city: '',       // 市
            buyer_county: '',     // 区
            buyer_township: '',   // 镇
            email: '', // 邮箱
            ids: '' // 地址id
          }
          this.Bus.$emit('AddressManagementShippingAddress_hide_hide_new', 'hide') // 取消操作关闭此组件
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
        this.Bus.$on('address-management-shipping-address-new', (em) => {
          // 显示弹框
          this.bounced = true
          this.disabled = false
        })
        this.Bus.$on('ddressManagementShippingAddress_address_oks_new', (em) => {
          let _this = this
          console.log(em)
          if (em === 0) {
            this.bounced = false
            setTimeout(() => {
              _this.disabled = false
              this.Bus.$emit('AddressManagementShippingAddress_hide_new', 'hide')
            }, 100)
          } else if (em === 1) {
            this.$Message.error('错误')
          }
        })
      },
      watch: {}
    }
</script>

<style scoped>
.ivu-form-item{
  margin-bottom: 24px;
  margin-top: 6px;
}
.margin_bottom_top{
  margin-bottom: 24px;
  margin-top: 6px;
}
.vertical-center-modal{
  display: flex;
  align-items: center;
  justify-content: center;
}
.vertical-center-modal .ivu-modal{
  top: 0;
}
.modal-footer{
  border-top: 1px solid #e8eaec;
  padding: 12px 18px 0 18px;
  text-align: right;
  box-sizing: border-box;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}
</style>
