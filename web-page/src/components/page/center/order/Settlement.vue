<template>
    <div class="container min-height350">
      <div class="settlement">
        <div class="settlement-title">
          <p class="font-16 margin-b-15 color_333">结算页</p>
          <p class="font-20 color_333">填写并核对订单信息</p>
        </div>
        <div class="address">
          <div class="display-start-end">
            <p class="font-16">收货人信息</p>
            <p class="font-14 cursor add_address" @click="addNewAddress">新增收货地址</p>
          </div>
          <div class="addressInfo margin-t-15">
            <ul class="addressInfo-ul">
              <li v-for="(item, index) of showAddressList">
                <div class="wid-200 display-flex-ju-center text-center border-e" @click="setCurrentAddress(index)" :class="{back_icon: item.chooseAddress === 1}">
                  <p class="font-14">{{item.name}}</p>
                </div>
                <div class="flex-1 text-left margin-l-40">
                  <p class="address_details margin-b-5">{{item.province}}</p>
                  <p class="address_phone font-weight">{{item.phone}}</p>
                </div>
                <div class="wid-200 text-right btn_default">
                  <Button v-if="item.is_default === 1" style="opacity: 1">默认地址</Button>
                  <div class="display-space-b address_operation" v-if="item.is_default !== 1">
                    <p class="color_ed3a" @click="setDefaultAddress(item, index)">设置默认地址</p>
                    <p>编辑</p>
                    <p @click="deleteAddress(item, index)" v-if="item.chooseAddress !== 1">删除</p>
                  </div>
                </div>
                <Modal
                  v-model="showDeleteAddress"
                  width="400"
                  class="showDeleteAddress"
                >
                  <div slot="footer" class="showDeleteAddress">
                    <Button  @click="cancelDelete()">取消</Button>
                    <Button  @click="confirmDelete(index)">确认</Button>
                  </div>
                  <p>确认删除该条地址吗</p>
                </Modal>
              </li>
            </ul>
            <div class="display-f" v-show="!isshowAddress">
              <div class="display-f show_hide_img" @click="anAddressList" v-if="address.data.length !== 1">
                <p class="margin-r-5">展开地址</p>
                <img src="../../../../assets/images/icon/icon05.png" alt="">
              </div>
            </div>
            <div class="display-f wid_80" @click="packUpAddressList" v-show="isshowAddress">
              <div class="display-f show_hide_img" v-if="address.data.length !== 1">
                <p class="margin-r-5">收起地址</p>
                <img src="../../../../assets/images/icon/icon06.png" alt="">
              </div>
            </div>
          </div>
        </div>
        <!--支付方式-->
        <div class="pay border-t-b">
          <div class="pay_title margin-b-20">
            <p class="font-16 ">支付方式</p>
          </div>
          <div class="pay_type padding-l-r display-f">
            <div :class="{back_icon2: isShowpay === 1, border_200: isShowpay !== 1}" @click="payType(1)" class="wid-125 display-flex-ju-center text-center">
              <p class="color_666">支付宝</p>
            </div>
            <div :class="{back_icon2: isShowpay === 2, border_200: isShowpay !== 2}" @click="payType(2)" class="wid-125 margin-l-25 display-flex-ju-center text-center">
              <p class="color_666">月结</p>
            </div>
          </div>
        </div>
        <!--订单-->
        <div class="orderLit border-t-b">
          <div class="margin-b-20">
            <p class="font-16 ">送货清单</p>
          </div>
          <div class="padding-l-r">
            <ul class="order-ul">
              <li>
                <div class="wid_400 display-f">
                  <div class="wid_110">
                    <img src="../../../../assets/images/home/banner/bannertest.png" alt="">
                  </div>
                  <div class="margin-l-20 display-felx-c">
                    <p class="lin-clamp-3">商品名称商品名称商品名称商品名称商品名称商品名称</p>
                    <p>颜色: <span>白色</span></p>
                  </div>
                </div>
                <div class="flex_1">x1</div>
                <div class="flex_1">￥412.00</div>
              </li>
              <li>
                <div class="wid_400 display-f">
                  <div>
                    <img src="../../../../assets/images/home/banner/bannertest.png" alt="">
                  </div>
                  <div class="margin-l-20 display-felx-c">
                    <p class="lin-clamp-3">商品名称商品名称商品名商品名称商品名称商品名称商品商品名商品名品名称商品商品名称商品名称商品名称商品名称名称商品名称称商品名称商品名称商品名称名称商品名称
                      商品名称</p>
                    <p>颜色: <span>白色</span></p>
                  </div>
                </div>
                <div class="flex_1">x1</div>
                <div class="flex_1">￥412.00</div>
              </li>
            </ul>
          </div>
        </div>
        <div class="invoice">
          <span class="margin-r-15">发票信息</span>
          <div class="invoice_prompt color_333">开增值税专票需提供一般纳税人证明，以免影响报销</div>
          <Modal
            v-model="showinvoice"
            class="showinvoice"
          >
            <div slot="footer" class="display-flex-ju-bet footer_invoice">
              <Button  @click="addinvoice()">新增发票</Button>
              <Button  @click="invoiceConfirm">确认选择</Button>
            </div>
            <RadioGroup v-model="noInvoice" vertical>
              <div class="border_200 noinvoece margin-b-15">
                <Radio label="1">不开发票</Radio>
              </div>
              <div class="border_200 noinvoece margin-b-15">
                <Radio label="2">
                  北京太火红鸟科技有限公司
                </Radio>
              </div>
              {{noInvoice}}
            </RadioGroup>

          </Modal>
        </div>
        <div class="invoiceInfo">
          <div class="display-felx-space width_298">
            <span class="margin-r-15 color_333">增值税发票</span>
            <span class="color_666">北京铟立方科技有限公司</span>
          </div>
          <div class="width_135 display-felx-space margin-l-77">
            <span>商品明细</span>
            <span class="span_hover">修改</span>
          </div>
          <div class="width_285 margin-l-254 padding-r-20 text-right">
            <span><i class="color_ed3a">3</i> 件商品,</span>
            <span>总商品金额:</span>
            <span>￥8876.00</span>
          </div>
        </div>
        <div class="confirmInfo">
          <div class="display-flex-end margin-5">
            <p class="font-14">应付总额：</p>
            <p class="font-18 color_ed3a">￥1876.00</p>
          </div>
          <div class="margin-5">
            <p class="font-14">寄送至：北京 朝阳区 酒仙桥4号751北京时尚设计广场B7栋 收货人：曹恒瑞 13768390888</p>
          </div>
        </div>
        <div id="submitOrder">
          <router-link :to="{name: 'PaymentMethod'}"><Button>提交订单</Button></router-link>
        </div>
      </div>
      <Modal
        v-model="add_address"
        title="新增收货地址"
        class="newAddress"
        width="650"
      >
        <div slot="footer">
          <Button  @click="addConfirm('form')">保存</Button>
          <Button  @click="cancel">取消</Button>
        </div>
        <Form ref="form" :model="form" :rules="ruleValidate" label-position="top">
          <Row>
            <Col :span="14">
              <FormItem label="收货人" prop="name">
                <Input v-model="form.name" placeholder="请输入收货人姓名"></Input>
              </FormItem>
            </Col>
          </Row>
          <Row>
            <Col :span="14">
              <FormItem label="手机号码" prop="phone">
                <Input v-model="form.phone" placeholder="请输入收货人手机号"></Input>
              </FormItem>
            </Col>
          </Row>
          <FormItem label="门店地址">
            <Row :gutter="10" class="content">
              <Col :span="6">
                <Select v-model="province.id" number label-in-value @on-change="provinceChange" placeholder="请选择">
                  <Option :value="d.value" v-for="(d, index) in province.list" :key="index">{{ d.label }}</Option>
                </Select>
              </Col>
              <Col :span="6">
                <Select v-model="city.id" number label-in-value @on-change="cityChange" placeholder="请选择">
                  <Option :value="d.value" v-for="(d, index) in city.list" :key="index">{{ d.label }}</Option>
                </Select>
              </Col>
              <Col :span="6">
                <Select v-model="county.id" number label-in-value @on-change="countyChange" placeholder="请选择">
                  <Option :value="d.value" v-for="(d, index) in county.list" :key="index">{{ d.label }}</Option>
                </Select>
              </Col>
              <!--<Col :span="4">-->
              <!--<Select v-model="town.id" number label-in-value @on-change="townChange" placeholder="请选择" v-if="town.show">-->
              <!--<Option :value="d.value" v-for="(d, index) in town.list" :key="index">{{ d.label }}</Option>-->
              <!--</Select>-->
              <!--</Col>-->
            </Row>
          </FormItem>
          <Row>
            <Col :span="14">
              <FormItem label="详细地址" prop="detailedAddress">
                <Input v-model="form.detailedAddress" placeholder="请输入详细地址"></Input>
              </FormItem>
            </Col>
          </Row>
        </Form>
      </Modal>
    </div>
</template>

<script>
  import api from '@/api/api'
  export default {
    name: 'orderSettiement',
    data () {
      const validatePhone = (rule, value, callback) => {
        if (value) {
          var reg = /^[1][3,4,5,7,8][0-9]{9}$/
          if (!reg.test(value) || value.replace(/(^\s*)|(\s*$)/g, '') === '') {
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
      return {
        form: {
          name: '',             // 收货人
          phone: '',            // 手机号
          detailedAddress: '',  // 详细地址
          buyer_province: '',   // 省
          buyer_city: '',       // 市
          buyer_county: '',     // 区
          buyer_township: ''    // 镇
        },
        showDeleteAddress: false,  // 删除收货地址提示框
        DeleteAddressNum: null,    // 删除地址
        showinvoice: false,      // 发票提示框
        isShowpay: 1,        // 选择支付方式
        isshowAddress: false,      // 显示隐藏地址
        noInvoice: '',        // 不开发票
        setAddressDefault: 0,   // 设置默认地址
        add_address: false,      // 新增收货地址
        address: {
          'data': [
            {
              'id': 2,                            // ID
              'name': '张明',                   // 收货人
              'phone': '13020663711',           // 电话
              'zip': '101500',                      // 邮编
              'province': '北京市',                         // 省份
              'city': '朝阳区',                         // 城市
              'county': '三环到四环',                         // 区县
              'town': '某某村',                         // 城镇／乡
              'address': '酒仙桥798',                // 详细地址
              'is_default': 1,                      // 是否默认收货地址
              'status': 1,                            // 状态: 0.禁用；1.正常；
              'chooseAddress': 1
            },
            {
              'id': 3,                            // ID
              'name': '李四',                   // 收货人
              'phone': '13005399999',           // 电话
              'zip': '101500',                      // 邮编
              'province': '北京市',                         // 省份
              'city': '朝阳区',                         // 城市
              'county': '三环到四环',                         // 区县
              'town': '某某村',                         // 城镇／乡
              'address': '酒仙桥798',                // 详细地址
              'is_default': 0,                      // 是否默认收货地址
              'status': 1,                            // 状态: 0.禁用；1.正常；
              'chooseAddress': 0
            },
            {
              'id': 4,                            // ID
              'name': '王五',                   // 收货人
              'phone': '13888888888',           // 电话
              'zip': '101500',                      // 邮编
              'province': '北京市',                         // 省份
              'city': '朝阳区',                         // 城市
              'county': '三环到四环',                         // 区县
              'town': '某某村',                         // 城镇／乡
              'address': '酒仙桥798',                // 详细地址
              'is_default': 0,                      // 是否默认收货地址
              'status': 1,                         // 状态: 0.禁用；1.正常；
              'chooseAddress': 0
            }
          ],
          'meta': {
            'message': 'Success',
            'status_code': 200
          }
        },
        province: {            // 省
          id: 0,
          name: '',
          list: [],
          show: true
        },  // province city county town
        city: {                 // 市
          id: 0,
          name: '',
          list: [],
          show: false
        },
        county: {               // 区
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
        },
        ruleValidate: {
          name: [
            { required: true, message: '姓名不能为空', trigger: 'blur' },
            { type: 'string', min: 1, max: 20, message: '名称在1-20字符之间', trigger: 'blur' }
          ],
          phone: [
            { required: true, validator: validatePhone, trigger: 'blur' }
          ],
          detailedAddress: [
            { required: true, message: '详细地址不能为空', trigger: 'blur' },
            { type: 'string', min: 2, max: 30, message: '范围在2-30字符之间', trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      // 新增收货地址
      addNewAddress () {
        if (this.address.data.length !== 5) {
          this.add_address = true
        } else {
          this.$Message.error('最多只能创建五个收货地址')
        }
      },
      // 删除收货地址
      confirmDelete () {
        this.address.data.forEach((item, key) => {
          if (key === this.DeleteAddressNum) {
            this.address.data.splice(key, 1)
            this.DeleteAddressNum = null
            this.showDeleteAddress = false
          }
        })
      },
      // 取消删除
      cancelDelete () {
        this.showDeleteAddress = false
      },
      // 触发删除弹出框
      deleteAddress (item, index) {
        this.DeleteAddressNum = index
        this.showDeleteAddress = true
      },
      // 确认新增
      addConfirm (formName) {
        let self = this
        this.$refs[formName].validate((valid) => {
          if (valid) {
            if (!self.form.buyer_province || !self.form.buyer_city || !self.form.buyer_county) {
              self.$Message.error('请选择所在地区!')
              return false
            }
            let row = {
              'id': 6,
              'name': this.form.name,                   // 收货人
              'phone': this.form.phone,           // 电话
              'zip': '000000',                      // 邮编
              'province': this.form.buyer_province,                         // 省份
              'city': this.form.buyer_city,                         // 城市
              'county': this.form.buyer_county,                         // 区县
              'town': '某某村',                         // 城镇／乡
              'address': this.form.detailedAddress,                // 详细地址
              'is_default': 1,                      // 是否默认收货地址
              'status': 1,
              'chooseAddress': 1
            }
            this.address.data.push(row)
            this.add_address = false
            this.form = {}
            this.form.buyer_province = ''
          } else {
            // this.$Message.error('请填写信息')
          }
        })
      },
      // 取消
      cancel () {
        this.add_address = false
      },
      // 点击设为默认地址
      setDefaultAddress (item, index) {
        this.address.data.forEach((item, key) => {
          if (item.is_default === 1) {
            item.is_default = 0
          }
          if (item.chooseAddress === 1) {
            item.chooseAddress = 0
          }
          if (key === index) {
            item.is_default = 1
            item.chooseAddress = 1
          }
        })
      },
      // 选择当前收货地址
      setCurrentAddress (index) {
        this.address.data.forEach((item, key) => {
          if (item.chooseAddress === 1) {
            item.chooseAddress = 0
          }
          if (index === key) {
            item.chooseAddress = 1
          }
        })
      },
      // 展开收货地址
      anAddressList () {
        if (this.address.data.length !== 1) {
          this.isshowAddress = !this.isshowAddress
        }
      },
      // 收起
      packUpAddressList () {
        this.isshowAddress = !this.isshowAddress
      },
      // 选择支付类型
      payType (num) {
        this.isShowpay = num
      },
      // 新增发票
      addinvoice () {},
      // 确认发票
      invoiceConfirm () {},
      // 收货地址市
      fetchCity (value, layer) {
        const self = this
        self.$http.get(api.fetchCity, {params: {value: value, layer: layer}})
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
      },
      provinceChange (data) {
        if (data.value) {
          this.resetArea(1)
          this.province.id = data.value
          this.province.name = data.label
          this.form.buyer_province = data.value
          this.fetchCity(data.value, 2)
        }
      },
      cityChange (data) {
        if (data) {
          if (data.value) {
            this.resetArea(2)
            this.city.id = data.value
            this.city.name = data.label
            this.form.buyer_city = data.value
            this.fetchCity(data.value, 3)
          }
        }
      },
      countyChange (data) {
        if (data) {
          if (data.value) {
            this.resetArea(3)
            this.county.id = data.value
            this.county.name = data.label
            this.form.buyer_county = data.value
            this.fetchCity(data.value, 4)
          }
        }
      },
      townChange (data) {
        if (data.value) {
          this.town.id = data.value
          this.town.name = data.label
          this.form.buyer_township = data.value
        }
      }
    },
    created () {
      // console.log(this.address.data)
      // let data = this.address.data
      // data.forEach((item, index) => {
      //   if (item.chooseAddress === 1) {
      //     item.chooseAddress2 = 1
      //   } else {
      //     item.chooseAddress2 = 0
      //   }
      // })
      // console.log(this.address.data)
      let self = this
      self.$http.get(api.city)
        .then(function (response) {
          if (response.data.meta.status_code === 200) {
            if (response.data.data) {
              self.province.list = response.data.data
              // self.fetchCity(token, 2)
            }
          }
        })
    },
    components: {},
    computed: {
      showAddressList () {
        if (!this.isshowAddress) {
          let showAddress = []
          if (this.address.data.length > 1) {
            for (let i = 0; i < 1; i++) {
              showAddress.push(this.address.data[i])
            }
          } else {
            showAddress = this.address.data
          }
          return showAddress
        } else {
          return this.address.data
        }
      }
    }
  }
</script>

<style scoped>
  .settlement {
    padding: 30px 105px;
  }
  .settlement-title {
    margin-bottom: 30px;
  }

  .display-start-end {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-right: 20px;
  }
  .addressInfo {
    padding: 18px 20px 28px 20px;
    border-top: 1px solid rgba(240,240,240,1);
  }

  .addressInfo-ul li {
    min-height: 72px;
    display: flex;
    justify-content: space-between;
    padding-bottom: 20px;
    cursor: pointer;
  }

  .wid-200 {
    width: 200px;
    height: 40px;
  }

  .wid-125 {
    width: 125px;
    height: 40px;
  }
  .border-e {
    /*border: 2px solid #ED3A4A;*/
  }

  .flex-1 {
    flex: 1;
    max-width: 490px;
    padding-right: 100px;
  }

  .flex-1 p {
    font-size: 14px;
    color: #666666;
  }

  .address_operation {
    transition: all .5s ease;
    opacity: 0;
  }

  /*结算页地址*/
  .btn_default .ivu-btn {
    width: 90px;
    height: 30px;
    background:rgba(153,153,153,1);
    border: 1px solid rgba(153,153,153,1);
    border-radius: 0;
    font-size: 12px;
    line-height: 1;
  }

  .text-right {
    text-align: right;
  }

  .display-space-b {
    display: flex;
    justify-content: space-between;
    padding-right: 20px;
  }
  .display-space-b p {
    font-size: 12px;
    cursor: pointer;
  }

  .addressInfo-ul li:hover .address_operation {
    opacity: 1;
  }

  .wid_80 {
    width: 80px;
  }

  .display-f {
    display: flex;
    cursor: pointer;
    align-items: center;
  }

  .border_200 {
    border: 1px solid rgba(200,200,200,1);
  }
  .padding-l-r {
    padding: 0 20px;
  }
  .border-t-b {
    padding: 30px 0 28px 0;
    border-top: 1px solid rgba(240,240,240,1);
    border-bottom: 1px solid rgba(240,240,240,1);
  }
  .orderLit {

  }

  .order-ul li {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
  }

  .order-ul li:last-child {
    margin-bottom: 0;
  }

  .wid_400 {
    width: 400px;
  }

  .flex_1 {
    flex: 1;
    text-align: right;
  }

  .display-felx-c {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .invoice {
    display: flex;
    align-items: center;
    padding-top: 30px;
    position: relative;
  }

  .invoiceInfo {
    margin-top: 38px;
    display: flex;
    margin-bottom: 18px;
  }

  .invoiceInfo span {
    font-size: 14px;
  }

  .width_298 {
    width: 298px;
  }

  .width_135 {
    width: 135px;
  }

  .width_285 {
    width: 285px;
  }

  .margin-l-77 {
    margin-left: 77px;
  }

  .margin-l-254 {
    margin-left: 254px;
  }

  .padding-r-20 {
    padding-right: 20px;
  }
  .display-felx-space {
    display: flex;
    justify-content: space-between;
  }

  .confirmInfo {
    height: 76px;
    background:rgba(240,240,240,1);
    padding-right: 20px;
    text-align: right;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .display-flex-end {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    line-height: 1;
  }
  .margin-5 {
    margin: 5px 0 5px 5px;
  }

  #submitOrder {
    margin: 30px 0;
    text-align: right;
  }
  #submitOrder .ivu-btn {
    width: 150px;
    height: 40px;
    font-size: 18px;
    line-height: 1;
    color:rgba(240,240,240,1);
    font-weight:bold;
    border-radius: 0;
  }

  .invoice_prompt {
    width: 80%;
    height: 32px;
    background: url('../../../../assets/images/icon/icon100.png') no-repeat;
    background-size: contain;
    line-height: 32px;
    padding-left: 50px;
  }

  .span_hover {
    transition: all .5s ease;
  }

  .span_hover:hover {
    color: #ED3A4A;
  }

  .invoice_bounced {
    width: 524px;
    height: 293px;
    background:rgba(255,255,255,1);
    padding: 35px 30px 25px 30px ;
    position: absolute;
    margin-left: 50%;
    transform: translate(-50%);
    bottom: 0;
    border: 4px solid rgba(240,240,240,1);
  }

  .noinvoece {
    height: 36px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 18px;
    color: #666666;
    margin-top: 30px;
  }

  .wid_110 {
    width: 110px;
    height: 110px;
    position: relative;
  }
  .wid_110 img {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    margin: auto;
  }

  .back_icon {
    background: url("../../../../assets/images/icon/icon48.png")no-repeat;
    background-size: 100% 40px;
  }
  .back_icon2 {
    background: url("../../../../assets/images/icon/icon49.png")no-repeat;
    background-size: 100% 40px;
  }

  .add_address:hover {
    color: #ED3A4A;
  }

  .show_hide_img img {
    width: 10px;
    height: 10px;
  }

  .footer_invoice .ivu-btn{
    width: 90px;
    height: 32px;
    line-height: 1;
    font-size: 12px;
    border-radius: 0;
  }

  .showDeleteAddress .ivu-btn{
    width: 90px;
    height: 32px;
    line-height: 1;
    font-size: 12px;
    border-radius: 0;
  }

  .footer_invoice .ivu-btn:first-child{
    background:rgba(240,240,240,1);
    border:1px solid rgba(200,200,200,1);
    color: #666666;
  }

  .showDeleteAddress .ivu-btn:first-child{
    background:rgba(240,240,240,1);
    border:1px solid rgba(200,200,200,1);
    color: #666666;
  }
</style>
