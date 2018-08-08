<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="account"></v-menu>
      </Col>

      <Col :span="21">
        <div class="right-content">
          <div class="content-box no-border">
            <div class="form-title" style="margin-top: 0;">
              <span>实名认证申请</span>
            </div>
            <Form :model="form" ref="form" :rules="formValidate" label-position="top">
              <div class="order-content">
                <p class="banner b-first">
                  门店信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="门店名称" prop="storeName">
                      <Input v-model="form.storeName" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="地址" prop="provinceValue">
                      <Cascader :data="province" :load-data="loadData" @on-change="handleChange" v-model="form.provinceValue"></Cascader>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="详细地址" prop="storeAddress">
                      <Input v-model="form.storeAddress" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="商品分类" prop="category_id">
                      <Select v-model="form.category_id" placeholder="请选择商品分类">
                        <Option v-for="(item, index) of categoryList" :key="index" :value="item.id">{{item.title}}</Option>
                      </Select>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="经营情况" prop="operation_situation">
                      <Input v-model="form.operation_situation" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="授权条件" prop="authorization_id">
                      <CheckboxGroup v-model="form.authorization_id">
                        <Checkbox  v-for="(item, index) of AuthorizationList" :key="index" :label="item.id">{{item.title}}</Checkbox>
                      </CheckboxGroup>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="营业执照号" prop="business_license_number">
                      <Input v-model="form.business_license_number" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="4" class="mar-b-0">
                    <FormItem label="营业执照">
                      <div class="demo-upload-list" v-for="item in uploadBusinessList">
                        <template>
                          <img :src="item.url">
                          <div class="demo-upload-list-cover">
                            <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                            <Icon type="ios-trash-outline" @click.native="handleBusinessRemove(item)"></Icon>
                          </div>
                        </template>
                        <template>
                          <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
                        </template>
                      </div>
                      <Upload
                        ref="upload"
                        :action="uploadParam.url"
                        :show-upload-list="false"
                        :on-success="handleBusinessSuccess"
                        :format="['jpg','jpeg','png']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleBusinessBeforeUpload"
                        :data="uploadParam"
                        type="drag"
                      >
                        <Button type="ghost" icon="ios-cloud-upload-outline"  class="border-none">上传营业执照</Button>
                      </Upload>
                      <Modal title="查看" v-model="visible">
                        <img :src="imgName" v-if="visible" style="width: 100%">
                      </Modal>
                    </FormItem>
                  </Col>
                </Row>
                <Row>
                  <Col :span="8">
                    <FormItem>
                      <div class="">上传jpg/png图片，且不超过5M</div>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="4" class="mar-b-0">
                    <FormItem label="门店照片">
                      <div class="demo-upload-list" v-for="item in uploadshopList">
                        <template>
                          <img :src="item.url">
                          <div class="demo-upload-list-cover">
                            <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                            <Icon type="ios-trash-outline" @click.native="handleshopRemove(item)"></Icon>
                          </div>
                        </template>
                        <template>
                          <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
                        </template>
                      </div>
                      <!--门店正面-->
                      <Upload
                        ref="upload"
                        :action="uploadParam.url"
                        :show-upload-list="false"
                        :on-success="handleshopSuccess_f"
                        :format="['jpg','jpeg','png']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleshopBeforeUpload_f"
                        :data="uploadParam"
                        type="drag"
                        v-if="uploadshopList.length === 0"
                      >
                          <Button type="ghost" icon="ios-cloud-upload-outline"  class="border-none">上传门店正面照</Button>
                      </Upload>
                      <!--门店内部-->
                      <Upload
                        ref="upload"
                        :action="uploadParam.url"
                        :show-upload-list="false"
                        :on-success="handleshopSuccess_r"
                        :format="['jpg','jpeg','png']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleshopBeforeUpload_r"
                        :data="uploadParam"
                        type="drag"
                        v-else
                      >
                          <Button type="ghost" icon="ios-cloud-upload-outline"  class="border-none">上传门店内部照</Button>
                      </Upload>
                      <Modal title="查看" v-model="visible">
                        <img :src="imgName" v-if="visible" style="width: 100%">
                      </Modal>
                    </FormItem>
                  </Col>
                </Row>
                <Row>
                  <Col :span="8">
                    <FormItem>
                      <div class="">上传jpg/png图片，且不超过5M</div>
                    </FormItem>
                  </Col>
                </Row>
                <p class="banner">
                  个人信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="5">
                    <FormItem label="姓名" prop="user_name">
                      <Input v-model="form.user_name" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="5">
                    <FormItem label="手机号" prop="phone">
                      <Input v-model="form.phone" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="5">
                    <FormItem label="银行卡账号" prop="bank_number">
                      <Input v-model="form.bank_number" placeholder=""></Input>
                    </FormItem>
                  </Col>
                  <Col :span="5">
                    <FormItem label="开户行" prop="bank_name">
                      <Input v-model="form.bank_name" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="4" class="mar-b-0">
                    <FormItem label="身份证照片">
                      <div class="demo-upload-list" v-for="item in uploadIdentityList">
                        <template>
                          <img :src="item.url">
                          <div class="demo-upload-list-cover">
                            <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                            <Icon type="ios-trash-outline" @click.native="handleIdentityRemove(item)"></Icon>
                          </div>
                        </template>
                        <template>
                          <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
                        </template>
                      </div>
                      <Upload
                        ref="upload"
                        :action="uploadParam.url"
                        :show-upload-list="false"
                        :on-success="handleIdentitySuccess_f"
                        :format="['jpg','jpeg','png']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleIdentityBeforeUpload_f"
                        :data="uploadParam"
                        type="drag"
                        v-if="uploadIdentityList.length === 0"
                      >
                          <Button type="ghost" icon="ios-cloud-upload-outline" class="border-none">上传身份证正面</Button>
                      </Upload>
                      <Upload
                        ref="upload"
                        :action="uploadParam.url"
                        :show-upload-list="false"
                        :on-success="handleIdentitySuccess_r"
                        :format="['jpg','jpeg','png']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :before-upload="handleIdentityBeforeUpload_r"
                        :data="uploadParam"
                        type="drag"
                        v-else
                      >
                        <Button type="ghost" icon="ios-cloud-upload-outline" class="border-none">上传身份证背面</Button>
                      </Upload>
                    </FormItem>
                  </Col>
                </Row>
                <Row>
                  <Col :span="8">
                    <FormItem>
                      <div class="">上传jpg/png图片，且不超过5M</div>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="12">
                    <FormItem label="纳税类型" prop="taxpayer">
                      <RadioGroup v-model="form.taxpayer">
                        <Radio label="1">一般纳税人</Radio>
                        <Radio label="2">小规模纳税人</Radio>
                      </RadioGroup>
                    </FormItem>
                  </Col>
                </Row>
                <div class="form-btn">
                  <FormItem>
                    <!--<Button type="ghost" style="margin-left: 8px" @click="backShow" v-if="id === 2">取消</Button>-->
                    <Button type="primary" :loading="btnLoading" @click="submit('form')">提交</Button>
                  </FormItem>
                </div>
              </div>
            </Form>
          </div>
        </div>
      </Col>
    </Row>
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/Menu'
import '@/assets/js/math_format'
export default {
  name: 'centerIdentifySubmit',
  components: {
    vMenu
  },
  data () {
    // 验证手机号
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
    // 验证授权信息
    const validateAuthorization = (rule, value, callback) => {
      if (!value) {
        callback(new Error('请填写授权信息!'))
      }
      callback()
    }
    // 验证商品分类
    const validateCategory = (rule, value, callback) => {
      if (!value) {
        callback(new Error('请填写商品分类!'))
      }
      callback()
    }
    const validateProvince = (rule, value, callback) => {
      if (value.length === 0) {
        callback(new Error('请填写地址!'))
      }
      callback()
    }
    return {
      btnLoading: false,
      imgName: '',               // 预览
      visible: false,
      uploadshopList: [],        // 门店照片存储
      uploadBusinessList: [],    // 营业执照
      uploadIdentityList: [],    // 身份证
      categoryList: [],          // 商品分类
      AuthorizationList: [],     // 授权条件
      id: null,                // 修改或者第一次填写
      test: 1,
      form: {
        storeName: '',     // 门店名称
        storeAddress: '',  // 门店地址
        category_id: '',  // 商品分类id
        authorization_id: [], // 授权条件
        operation_situation: '', // 经营情况
        user_name: '', // 姓名
        bank_number: '', // 银行卡账号
        bank_name: '', // 开户行
        taxpayer: '', // 纳税类型  1.一般纳税人  2.小规模
        phone: '', // 手机号
        provinceValue: [], // 省市
        business_license_number: '', // 营业执照号
        license_id: null,   // 营业执照id
        front_id: null,   // 门店正面照片id
        Inside_id: null,   // 门店内部照片id
        portrait_id: null,   // 身份证正面id
        national_emblem_id: null   // 身份证背面id
      },
      uploadParam: {   // 传值后台
        'url': '',
        'token': '',
        'x:random': '',
        'x:user_id': this.$store.state.event.user.id,
        'x:target_id': this.$route.query.id,
        'x:type': 0
      },
      formValidate: {
        // 门店名称
        storeName: [
          { required: true, message: '门店名称不能为空', trigger: 'blur' },
          { type: 'string', min: 4, max: 20, message: '名称范围在4-20字符之间', trigger: 'blur' }
        ],
        // 门店地址
        storeAddress: [
          { required: true, message: '详细地址不能为空', trigger: 'blur' },
          { type: 'string', min: 4, max: 30, message: '名称范围在4-30字符之间', trigger: 'blur' }
        ],
        // 商品分类
        category_id: [
          { required: true, validator: validateCategory, trigger: 'change' }
        ],
        provinceValue: [
          { required: true, validator: validateProvince, trigger: 'change' }
        ],
        // 授权条件
        authorization_id: [
          { required: true, validator: validateAuthorization, trigger: 'blur' }
        ],
        // 营业执照号
        business_license_number: [
          { required: true, message: '请填写营业执照号码', trigger: 'blur' },
          { type: 'string', min: 15, max: 15, message: '请检查号码位数', trigger: 'blur' }
        ],
        // 经营情况
        operation_situation: [
          { required: true, message: '请选择经营情况', trigger: 'blur' },
          { type: 'string', min: 1, max: 10, message: '范围在1-10字符之间', trigger: 'blur' }
        ],
        user_name: [
          { required: true, message: '姓名不能为空', trigger: 'blur' }
        ],
        // 银行卡
        bank_number: [
          { required: true, message: '银行卡账号不能为空', trigger: 'blur' }
        ],
        // 开户行
        bank_name: [
          { required: true, message: '开户行不能为空', trigger: 'blur' },
          {type: 'string', min: 3, max: 15, message: '范围在3-15字符之间', trigger: 'blur'}
        ],
        // 纳税类型
        taxpayer: [
          { required: true, message: '请选择纳税类型', trigger: 'change' }
        ],
        // 手机号
        phone: [
          { required: true, message: '手机号不能为空', trigger: 'blur' },
          { validator: validatePhone, trigger: 'blur' }
        ]
      },
      msg: '',
      province: []
    }
  },
  methods: {
    // 预览
    handleView (name) {
      this.imgName = name
      this.visible = true
    },
    // 营业执照删除
    handleBusinessRemove (file) {
      const fileList = this.uploadBusinessList
      this.uploadBusinessList.splice(fileList.indexOf(file), 1)
    },
    // 门店删除
    handleshopRemove (file) {
      const fileList = this.uploadshopList
      this.uploadshopList.splice(fileList.indexOf(file), 1)
    },
    // 身份证删除
    handleIdentityRemove (file) {
      const fileList = this.uploadIdentityList
      this.uploadIdentityList.splice(fileList.indexOf(file), 1)
    },
    // 上传门店正面成功
    handleshopSuccess_f (res, file, fileList) {
      this.form.front_id = res.asset_id
      var add = fileList[fileList.length - 1]
      var itemt = {
        name: add.response.fileName,
        url: add.response.name,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.uploadshopList.push(itemt)
    },
    // 上传门店内部成功
    handleshopSuccess_r (res, file, fileList) {
      this.form.Inside_id = res.asset_id
      var add = fileList[fileList.length - 1]
      var itemt = {
        name: add.response.fileName,
        url: add.response.name,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.uploadshopList.push(itemt)
    },
    // 门店正面执行
    handleshopBeforeUpload_f () {
      this.uploadParam['x:type'] = 17
      const check = this.uploadshopList.length < 2
      if (!check) {
        this.$Message.warning('最多上传两张照片')
      }
      return check
    },
    // 门店内部执行
    handleshopBeforeUpload_r () {
      this.uploadParam['x:type'] = 18
      const check = this.uploadshopList.length < 2
      if (!check) {
        this.$Message.warning('最多上传两张照片')
      }
      return check
    },
    // 营业执照上传成功
    handleBusinessSuccess (res, file, fileList) {
      this.form.license_id = res.asset_id
      var add = fileList[fileList.length - 1]
      var itemt = {
        name: add.response.fileName,
        url: add.response.name,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.uploadBusinessList.push(itemt)
    },
    // 营业执照执行之前
    handleBusinessBeforeUpload () {
      this.uploadParam['x:type'] = 19
      const check = this.uploadBusinessList.length < 1
      if (!check) {
        this.$Message.warning('最多上传一张营业执照')
      }
      return check
    },
    // 身份证正面上传成功
    handleIdentitySuccess_f (res, file, fileList) {
      this.form.portrait_id = res.asset_id
      var add = fileList[fileList.length - 1]
      var itemt = {
        name: add.response.fileName,
        url: add.response.name,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.uploadIdentityList.push(itemt)
    },
    // 身份证背面上传成功
    handleIdentitySuccess_r (res, file, fileList) {
      this.form.national_emblem_id = res.asset_id
      var add = fileList[fileList.length - 1]
      var itemt = {
        name: add.response.fileName,
        url: add.response.name,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.uploadIdentityList.push(itemt)
    },
    // 身份证人像面上传之前
    handleIdentityBeforeUpload_f () {
      this.uploadParam['x:type'] = 20
      const check = this.uploadIdentityList.length < 2
      if (!check) {
        this.$Message.warning('最多上传两张照片')
      }
      return check
    },
    // 身份证国徽面上传之前
    handleIdentityBeforeUpload_r () {
      this.uploadParam['x:type'] = 21
      const check = this.uploadIdentityList.length < 2
      if (!check) {
        this.$Message.warning('最多上传两张照片')
      }
      return check
    },
    handleFormatError (file) {
      this.$Message.warning('图片格式不正确')
    },
    handleMaxSize (file) {
      this.$Message.warning('图片大小最大为5M')
    },
    handleChange (value, selectedData) {
      this.form.provinceValue = selectedData.map(o => o.value).join(',').split(',')
    },
    // 获取市
    loadData (item, callback) {
      let self = this
      item.loading = true
      self.$http.get(api.fetchCity, {params: {value: item.value, layer: 2}})
        .then(function (response) {
          if (response.data.meta.status_code === 200) {
            console.log(response.data.data)
            if (response.data.data) {
              item.children = response.data.data
              item.loading = false
              callback()
            }
          }
        })
    },
    // 提交
    submit (ruleName) {
      const self = this
      this.$refs[ruleName].validate((valid) => {
        if (valid) {
          if (self.uploadBusinessList.length === 0) {
            self.$Message.error('请上传营业执照!')
            return false
          }
          if (self.uploadshopList.length === 0) {
            self.$Message.error('请上传门店照片!')
            return false
          } else if (self.uploadshopList.length === 1) {
            self.$Message.error('请补全门店照片!')
            return false
          }
          if (self.uploadIdentityList.length === 0) {
            self.$Message.error('请上传身份证照片!')
            return false
          } else if (self.uploadIdentityList.length === 1) {
            self.$Message.error('请补全身份证照片!')
            return false
          }
          var row = {
            token: self.$store.state.event.token,
            name: self.form.user_name,
            store_name: self.form.storeName,
            phone: self.form.phone,
            user_id: self.$store.state.event.user.id,
            province_id: self.form.provinceValue[0],
            city_id: self.form.provinceValue[1],
            category_id: self.form.category_id,
            authorization_id: self.form.authorization_id.join(','),
            store_address: self.form.storeAddress,
            operation_situation: self.form.operation_situation,
            bank_number: self.form.bank_number,
            bank_name: self.form.bank_name,
            taxpayer: self.form.taxpayer,
            business_license_number: self.form.business_license_number,
            license_id: self.form.license_id,
            front_id: self.form.front_id,
            Inside_id: self.form.Inside_id,
            portrait_id: self.form.portrait_id,
            national_emblem_id: self.form.national_emblem_id
          }
          self.btnLoading = true
          let commitMessage = null
          if (self.id) {
            commitMessage = api.updateMessage
            row.id = self.id
          } else {
            commitMessage = api.addMessage
          }
          // 保存数据
          self.$http.post(commitMessage, row)
            .then(function (response) {
              self.btnLoading = false
              if (response.data.meta.status_code === 200) {
                self.$Message.success('操作成功！')
                self.$router.push({name: 'centerIdentifyShow'})
              } else {
                self.$Message.error(response.data.meta.message)
              }
            })
            .catch(function (error) {
              self.btnLoading = false
              self.$Message.error(error.message)
            })
        } else {
          return
        }
      })
    },
    backShow () {
      this.$router.replace({name: 'centerIdentifyShow'})
    }
  },
  computed: {
  },
  created: function () {
    let token = this.$store.state.event.token
    this.id = this.$route.query.id
    console.log(this.id)
    let self = this
    // 获取图片上传信息
    self.$http.get(api.upToken, {params: {token: token}})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (response.data.data) {
            self.uploadParam.token = response.data.data.token
            self.uploadParam.url = response.data.data.url
            self.uploadParam['x:random'] = response.data.data.random
          }
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        return false
      })
    // 获取商品分类
    self.$http.get(api.category, {params: {token: token}})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (response.data.data) {
            self.categoryList = response.data.data
          }
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        return false
      })
    // 获取授权条件
    self.$http.get(api.authorization, {params: {token: token}})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (response.data.data) {
            self.AuthorizationList = response.data.data
          }
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        return false
      })
    // 获取省份城市
    self.$http.get(api.city, {params: {token: token}})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (response.data.data) {
            let city = response.data.data
            for (let i = 0; i < city.length; i++) {
              self.province = city
              for (let i = 0; i < self.province.length; i++) {
                self.province[i].loading = false
                self.province[i].children = []
              }
            }
            console.log(self.province)
          }
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        return false
      })
  },
  mounted () {
    // this.uploadList = this.$refs.upload.fileList
  },
  watch: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

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
    padding-right: 20px;
  }

  .city-tag {
    margin: 0 0 5px 5px;
  }

  .product-total {
    text-align: right;
    margin-right: 40px;
    margin-top: 10px;
  }
  .product-total p span {
    font-weight: 600;
  }
  .product-total p .price {
    color: red;
  }

  .demo-upload-list{
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    margin-right: 4px;
  }
  .demo-upload-list img{
    width: 100%;
    height: 100%;
  }
  .demo-upload-list-cover{
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,.6);
  }
  .demo-upload-list:hover .demo-upload-list-cover{
    display: block;
  }
  .demo-upload-list-cover i{
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
  }

  .border-none {
    border: none;
  }

  .ivu-upload .ivu-upload {
    width: 100px !important;
  }
</style>
