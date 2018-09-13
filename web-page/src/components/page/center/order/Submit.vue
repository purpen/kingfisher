<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <!--
    <Breadcrumb>
        <Breadcrumb-item><router-link :to="{name: 'home'}">首页</router-link></Breadcrumb-item>
        <Breadcrumb-item><router-link :to="{name: 'centerBasic'}">个人中心</router-link></Breadcrumb-item>
        <Breadcrumb-item>创建订单</Breadcrumb-item>
    </Breadcrumb>
    -->
    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="order"></v-menu>
      </Col>

      <Col :span="21">
        <div class="order-box">
          <h3>创建订单</h3>
          <Form :model="form" ref="form" :rules="formValidate" label-position="top">
            <div class="order-content">
              <p class="banner b-first">
                订单信息
              </p>
              <Row :gutter="10" class="content">
                <Col :span="8">
                  <FormItem label="站外订单号" prop="outside_target_id">
                    <Input v-model="form.outside_target_id" placeholder=""></Input>
                  </FormItem>
                </Col>
              </Row>
              <Row :gutter="10" class="content">
                <Col :span="12">
                  <FormItem label="买家备注" prop="buyer_summary">
                    <Input v-model="form.buyer_summary" type="textarea" placeholder=""></Input>
                  </FormItem>
                </Col>
                <Col :span="12">
                  <FormItem label="卖家备注" prop="seller_summary">
                    <Input v-model="form.seller_summary" type="textarea" placeholder=""></Input>
                  </FormItem>
                </Col>
              </Row>
              <p class="banner">
                个人信息
              </p>
              <Row :gutter="10" class="content">
                <Col :span="8">
                  <FormItem label="收货人" prop="buyer_name">
                    <Input v-model="form.buyer_name" placeholder=""></Input>
                  </FormItem>
                </Col>
              </Row>
              <Row :gutter="10" class="content" prop="buyer_phone">
                <Col :span="8">
                  <FormItem label="手机号" prop="buyer_phone">
                    <Input v-model="form.buyer_phone" placeholder=""></Input>
                  </FormItem>
                </Col>
                <Col :span="8">
                  <FormItem label="电话号码">
                    <Input v-model.number="form.buyer_tel" placeholder=""></Input>
                  </FormItem>
                </Col>
                <Col :span="8">
                  <FormItem label="邮编" prop="buyer_zip">
                    <Input v-model="form.buyer_zip" placeholder="默认可输入000000"></Input>
                  </FormItem>
                </Col>
              </Row>
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
              <div class="blank20"></div>
              <!--<Row :gutter="10" class="content">-->
                <!--<div class="city-tag">-->
                  <!--<input type="hidden" v-model="form.buyer_province" />-->
                  <!--<Tag color="blue" v-show="form.buyer_province">{{ form.buyer_province }}</Tag>-->
                  <!--<input type="hidden" v-model="form.buyer_city" />-->
                  <!--<Tag color="blue" v-show="form.buyer_city">{{ form.buyer_city }}</Tag>-->
                  <!--<input type="hidden" v-model="form.buyer_county" />-->
                  <!--<Tag color="blue" v-show="form.buyer_county">{{ form.buyer_county }}</Tag>-->
                  <!--<input type="hidden" v-model="form.buyer_township" />-->
                  <!--<Tag color="blue" v-show="form.buyer_township">{{ form.buyer_township }}</Tag>-->
                <!--</div>-->
              <!--</Row>-->
              <Row :gutter="10" class="content">
                <Col :span="24">
                  <FormItem label="" prop="buyer_address">
                    <Input v-model="form.buyer_address" type="textarea" placeholder="详细地址"></Input>
                  </FormItem>
                </Col>
              </Row>
              <p class="banner">
                商品信息
                <a href="javascript:void(0);" @click="addProductBtn" class="fr" style="font-size: 1.2rem;"><Icon type="plus-round"></Icon> 添加产品</a>
              </p>
              <div class="sku-list">
                <Table :columns="skuHead" :data="skuList"></Table>
                <div class="product-total">
                  <Row class="content">
                    <Col class="wid-200 text-l">
                      <FormItem  prop="settlement" v-if="skuList.length !== 0">
                        <RadioGroup v-model="form.payment_type">
                          <p class="text-l">结算方式</p>
                          <Radio label="5">现结</Radio>
                          <Radio label="4">月结</Radio>
                        </RadioGroup>
                      </FormItem>
                      <p class="wid-200 text-l">SKU数量: <span><b>{{ skuCount }}</b>个</span>&nbsp;&nbsp;&nbsp; 总金额: <span class="price">¥ <b>{{ skuMoney }}</b></span></p>

                    </Col>
                    <!--<Col :span="8">-->
                      <!--<p>SKU数量: <span><b>{{ skuCount }}</b>个</span>&nbsp;&nbsp;&nbsp; 总金额: <span class="price">¥ <b>{{ skuMoney }}</b></span></p>-->
                    <!--</Col>-->
                  </Row>
                </div>
                <div class="blank20"></div>
              </div>
            </div>

            <div class="form-btn">
              <FormItem>
                <Button type="ghost" @click="returnUrl" style="margin-left: 8px">取消</Button>
                <Button type="primary" @click="submit('form')">提交</Button>
              </FormItem>
            </div>
          </Form>
        </div>

      </Col>
    </Row>

    <Modal
      v-model="productModel"
      title="添加产品"
      width="1000"
      :styles="{top: '20px'}"
      @on-ok="productModel = false"
      @on-cancel="productModel = false">

      <div class="product-list">
        <Table :columns="productHead" :data="productList" class="addOrder"></Table>
        <div class="blank20"></div>
        <Page class="pager" :total="query.count" :current="query.page" :page-size="query.size" @on-change="handleCurrentProductChange" show-total></Page>
      </div>

    </Modal>

  </div>
</template>

<script>
  import api from '@/api/api'
  import rowProductView from '@/components/page/center/order/RowProductView'
  import vMenu from '@/components/page/center/Menu'
  import '@/assets/js/math_format'
  export default {
    name: 'center_order_submit',
    components: {
      vMenu
    },
    data () {
      const validateZip = (rule, value, callback) => {
        if (!(/^\d+$/.test(value))) {
          callback(new Error('请输入正确邮编'))
        } else {
          if (value.toString().length !== 6) {
            callback(new Error('必须为6位'))
          } else {
            callback()
          }
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
        productModel: false,
        isProductLoading: false,
        productList: [],  // 商品列表
        skuList: [],      // SKU列表
        skuCount: 0,   // 总数量
        skuMoney: 0,    // 总价
        status: null, // 审核状态
        productHead: [
          {
            title: '产品展开SKU',
            key: 'options',
            type: 'expand',
            width: 120,
            render: (h, params) => {
              return h(rowProductView, {
                props: {
                  productId: params.row.product_id
                },
                on: {
                  skuData: this.fetchSkuData
                }
              })
            }
          },
          {
            title: '产品图',
            key: 'img',
            width: 140,
            render: (h, params) => {
              return h('p', {
                style: {
                  margin: '5px'
                }
              }, [
                h('img', {
                  attrs: {
                    src: params.row.image
                  },
                  style: {
                    width: '80px'
                  }
                })
              ])
            }
          },
          {
            title: '名称',
            key: 'name'
          },
          {
            title: '编号',
            key: 'number'
          },
          {
            title: '价格',
            key: 'price'
          },
          {
            title: '库存',
            key: 'inventory'
          }
        ],
        // 添加之后的列表
        skuHead: [
          {
            title: '产品图',
            key: 'img',
            width: 120,
            render: (h, params) => {
              return h('p', {
                style: {
                  margin: '5px'
                }
              }, [
                h('img', {
                  attrs: {
                    src: params.row.product_cover
                  },
                  style: {
                    width: '80px'
                  }
                })
              ])
            }
          },
          {
            title: 'sku编码',
            key: 'number',
            width: 120
          },
          {
            title: '产品名称',
            key: 'product_name',
            width: 300
          },
          {
            title: '属性',
            key: 'mode'
          },
          {
            title: '单价',
            key: 'price'
          },
          {
            title: '数量',
            key: 'quantity'
          },
          {
            title: '总价',
            key: 'total_price'
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
                    this.removeSkuBtn(params.row.number)
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
          test: ''
        },
        formValidate: {
          outside_target_id: [
            { required: true, message: '站外订单号不能为空', trigger: 'blur' }
          ],
          buyer_name: [
            { required: true, message: '收货人不能为空', trigger: 'blur' }
          ],
          buyer_phone: [
            { required: true, validator: validatePhone, trigger: 'blur' }
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
        },
        msg: ''
      }
    },
    computed: {
      // testPhone () {
      //   if (this.form.buyer_tel.length > 1) {
      //     alert(1)
      //   }
      // }
    },
    directives: {
      blur: {
        // el.blur()
      }
    },
    methods: {
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
      },
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
      // 提交
      submit (ruleName) {
        console.log(typeof this.$store.state.event.user.distributor_status)
        this.distributor_status = this.$store.state.event.user.distributor_status
        if (this.distributor_status === '2') {
          const self = this
          this.$refs[ruleName].validate((valid) => {
            if (valid) {
              if (!self.form.buyer_province || !self.form.buyer_city) {
                self.$Message.error('请选择所在地区!')
                return false
              }
              var skuArr = []
              for (var i = 0; i < self.skuList.length; i++) {
                var sku = {
                  sku_id: self.skuList[i].sku_id,
                  quantity: self.skuList[i].quantity
                }
                skuArr.push(sku)
              }
              if (skuArr.length === 0) {
                self.$Message.error('请至少选择一件产品!')
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
                sku_id_quantity: JSON.stringify(skuArr),
                buyer_summary: self.form.buyer_summary,   // 买家
                seller_summary: self.form.seller_summary, // 卖家
                payment_type: self.form.payment_type   // 结算方式
              }
              // 保存数据
              self.$http.post(api.orderStore, row)
                .then(function (response) {
                  if (response.data.meta.status_code) {
                    self.$Message.success('操作成功！')
                    self.$router.push({name: 'centerOrder'})
                  } else {
                    self.$Message.error(response.data.message)
                  }
                })
                .catch(function (error) {
                  self.$Message.error(error.message)
                })
            } else {
              return
            }
          })
        } else if (this.distributor_status === '1') {
          this.$Message.error('您的实名认证正在审核中,请耐心等待!')
        } else {
          this.$Message.error('您的实名认证暂未通过!')
        }
      },
      // 返回列表页
      returnUrl () {
        this.$router.push({name: 'centerOrder'})
      },
      // 添加产品弹层
      addProductBtn () {
        this.productModel = true
        this.loadProductList()
      },
      // 加载产品列表
      loadProductList () {
        const self = this
        self.isProductLoading = true
        self.$http.get(api.productRecommendList, {params: {page: self.query.page, per_page: self.query.pageSize, status: self.query.status}})
          .then(function (response) {
            self.isProductLoading = false
            console.log(response)
            if (response.data.meta.status_code === 200) {
              self.query.count = parseInt(response.data.meta.pagination.total)
              var productList = response.data.data
              for (var i = 0; i < productList.length; i++) {
              } // endfor
              self.productList = productList
            } else {
              self.$Message.error(response.data.meta.message)
            }
          })
          .catch(function (error) {
            self.$Message.error(error.message)
            self.isProductLoading = false
          })
      },
      // 产品分页
      handleCurrentProductChange (currentPage) {
        this.query.page = currentPage
        this.loadProductList()
      },
      // 添加sku
      fetchSkuData (sku) {
        var hasOne = false
        var skuList = this.skuList
        for (var i = 0; i < skuList.length; i++) {
          if (skuList[i].number === sku.number) {
            var newSku = skuList[i]  // 得到点击相同的这一条数据
            newSku.quantity += sku.value
            newSku.total_price = newSku.price * newSku.quantity
            skuList.splice(i, 1, newSku)   // 删除原本数据,重新添加
            hasOne = true
          }
        }
        if (!hasOne) {
          sku.quantity = sku.value
          sku.total_price = sku.price * sku.quantity
          skuList.push(sku)
        }
        this.skuList = skuList
        this.productStat()
        this.$Message.success('添加成功！')
      },
      // 删除sku
      removeSkuBtn (skuId) {
        for (var i = 0; i < this.skuList.length; i++) {
          if (this.skuList[i].number === skuId) {
            this.skuList.splice(i, 1)
          }
        }
        this.productStat()
      },
      // 统计商品总量
      productStat () {
        this.skuCount = this.skuList.length
        var skuMoney = 0
        for (var i = 0; i < this.skuList.length; i++) {
          skuMoney = skuMoney.add(parseFloat(this.skuList[i].total_price))
        }
        this.skuMoney = skuMoney
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
    watch: {
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
  .order-content {
    border: 1px solid #ccc;
  }
  .order-content .banner {
    height: 40px;
    line-height: 40px;
    background-color: #FAFAFA;
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    font-size: 1.5rem;
    padding: 0 20px;
    margin-bottom: 20px;
  }
  .order-content .banner.b-first {
    border-top: none;
  }
  .order-content .ivu-row {
    padding: 0 20px;
  }
  .order-content .ivu-row .ivu-col {
  }
  .content .form-label {
    font-size: 1.2rem;
    padding-bottom: 10px;
  }
  .form-btn {
    text-align: right;
    margin-top: 10px;
  }
  .city-tag {
    margin: 0 0 5px 5px;
  }
  .product-total {
    text-align: right;
    margin-top: 10px;
  }
  .product-total p span {
    font-weight: 600;
  }
  .product-total p .price {
    color: red;
  }

  .text-l {
    text-align: left;
  }

  .product-total .content{
    display: flex;
    justify-content: flex-end;
  }

  .wid-200 {
    width: 230px;
  }
</style>
