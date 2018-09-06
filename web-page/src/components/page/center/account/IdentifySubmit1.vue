<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="account"></v-menu>
      </Col>

      <Col :span="21">
        <div class="right-content identifysubmit">
          <div class="content-box no-border">
            <div class="form-title" style="margin-top: 0;">
              <span>实名认证申请</span>
            </div>
            <Form :model="form" ref="form" :rules="formValidate" label-position="top">
              <div class="order-content">
                <p class="banner b-first">
                  企业信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="企业全称" prop="full_name">
                      <Input v-model="form.full_name" placeholder="请输入企业名称"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row class="content padd-none">
                  <Col :span="24">
                    <FormItem label="企业地址">
                      <Row :gutter="10" class="">
                        <Col :span="4">
                          <Select v-model="enterpriseProvince.id" number label-in-value @on-change="enterpriseProvinceChange" placeholder="请选择">
                            <Option :value="d.value" v-for="(d, index) in enterpriseProvince.list" :key="index">{{ d.label }}</Option>
                          </Select>
                        </Col>
                        <Col :span="4">
                          <Select v-model="enterpriseCity.id" number label-in-value @on-change="enterpriseCityChange" placeholder="请选择">
                            <Option :value="d.value" v-for="(d, index) in enterpriseCity.list" :key="index">{{ d.label }}</Option>
                          </Select>
                        </Col>
                        <Col :span="4">
                          <Select v-model="enterpriseCounty.id" number label-in-value @on-change="enterpriseCountyChange" placeholder="请选择">
                            <Option :value="d.value" v-for="(d, index) in enterpriseCounty.list" :key="index">{{ d.label }}</Option>
                          </Select>
                        </Col>
                        <!--<Col :span="4">-->
                          <!--<Select v-model="enterpriseTown.id" number label-in-value @on-change="enterpriseTownChange" placeholder="请选择" v-if="town.show">-->
                            <!--<Option :value="d.value" v-for="(d, index) in enterpriseTown.list" :key="index">{{ d.label }}</Option>-->
                          <!--</Select>-->
                        <!--</Col>-->
                      </Row>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="企业电话" prop="enter_phone">
                      <Input v-model="form.enter_phone" placeholder="请输入企业电话"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="营业执照号" prop="business_license_number">
                      <Input v-model="form.business_license_number" placeholder="请输入营业执照号"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="税号" prop="enterprise_ein">
                      <Input v-model="form.ein" placeholder="请输入税号"></Input>
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
                <Row :gutter="10" class="content">
                  <Col :span="5">
                    <FormItem label="开户行" prop="bank_name">
                      <Input v-model="form.bank_name" placeholder=""></Input>
                    </FormItem>
                  </Col>
                  <Col :span="5">
                    <FormItem label="银行卡账号" prop="bank_number">
                      <Input v-model="form.bank_number" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="法人姓名" prop="legal_person">
                      <Input v-model="form.legal_person" placeholder="请输入法人姓名"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="法人手机号" prop="legal_phone">
                      <Input v-model="form.legal_phone" placeholder="请输入法人手机号"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <!--<Row :gutter="10" class="content">-->
                  <!--<Col :span="8">-->
                    <!--<FormItem label="法人身份证号码" prop="enterpriseIdCard">-->
                      <!--<Input v-model="form.enterpriseIdCard" placeholder="请输入法人身份证"></Input>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <!--<Row :gutter="10" class="content">-->
                  <!--<Col :span="8">-->
                    <!--<FormItem label="统一社会信用代码" prop="enterpriseCreditCode">-->
                      <!--<Input v-model="form.enterpriseCreditCode" placeholder="请输入统一社会信用代码"></Input>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <Row :gutter="10" class="content heigin-none">
                  <Col :span="4" class="mar-b-0 btn-i">
                    <FormItem label="法人身份证照片">
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
                        v-if="uploadIdentityList.length === 0"
                      >
                        <Button icon="md-add" class="border-none"></Button>
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
                        v-else
                      >
                        <Button icon="md-add" class="border-none"></Button>
                      </Upload>
                    </FormItem>
                  </Col>
                </Row>
                <Row>
                  <Col :span="12">
                    <FormItem>
                      <div class="">请上传法人身份证正反照片，上传JPG/PNG图片，且不超过5M</div>
                    </FormItem>
                  </Col>
                </Row>
                <!--<Row :gutter="10" class="content">-->
                  <!--<Col :span="8">-->
                    <!--<FormItem label="经营情况" prop="operation_situation">-->
                      <!--<Input v-model="form.operation_situation" placeholder=""></Input>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <p class="banner">
                  门店信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="门店名称" prop="store_name">
                      <Input v-model="form.store_name" placeholder="请输入门店名称"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row class="content padd-none">
                  <Col :span="24">
                    <FormItem label="门店地址">
                      <Row :gutter="10" class="">
                        <Col :span="4">
                          <Select v-model="province.id" number label-in-value @on-change="provinceChange" placeholder="请选择">
                            <Option :value="d.value" v-for="(d, index) in province.list" :key="index">{{ d.label }}</Option>
                          </Select>
                        </Col>
                        <Col :span="4">
                          <Select v-model="city.id" number label-in-value @on-change="cityChange" placeholder="请选择">
                            <Option :value="d.value" v-for="(d, index) in city.list" :key="index">{{ d.label }}</Option>
                          </Select>
                        </Col>
                        <Col :span="4">
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
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="商品分类" prop="category_id">
                      <CheckboxGroup v-model="form.category_id">
                        <Checkbox  v-for="(item, index) of categoryList" :key="index" :label="item.id">{{item.title}}</Checkbox>
                      </CheckboxGroup>
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
                    <FormItem label="门店联系人姓名" prop="name">
                      <Input v-model="form.name" placeholder="请输入门店联系人"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="门店联系人职位" prop="position">
                      <Input v-model="form.position" placeholder="请输入门店联系人职位"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="门店联系人手机号" prop="phone">
                      <Input v-model="form.phone" placeholder="请输入门店联系人手机号"></Input>
                    </FormItem>
                  </Col>
                </Row>
                <!--<Row :gutter="10" class="content">-->
                  <!--<Col :span="8">-->
                    <!--<FormItem label="邮箱" prop="storeEmail">-->
                      <!--<Input v-model="form.storeEmail" placeholder="请输入邮箱"></Input>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <!--<Row :gutter="10" class="content">-->
                  <!--<Col :span="8">-->
                    <!--<FormItem label="详细地址" prop="storeAddress">-->
                      <!--<Input v-model="form.storeAddress" placeholder="请输入详细地址"></Input>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <!--<Row :gutter="10" class="content heigin-none">-->
                  <!--<Col :span="3" class="mar-b-0 btn-i">-->
                    <!--<FormItem label="营业执照">-->
                      <!--<div class="demo-upload-list" v-for="item in uploadBusinessList">-->
                        <!--<template>-->
                          <!--<img :src="item.url">-->
                          <!--<div class="demo-upload-list-cover">-->
                            <!--<Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>-->
                            <!--<Icon type="ios-trash-outline" @click.native="handleBusinessRemove(item)"></Icon>-->
                          <!--</div>-->
                        <!--</template>-->
                        <!--<template>-->
                          <!--<Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>-->
                        <!--</template>-->
                      <!--</div>-->
                      <!--<Upload-->
                        <!--ref="upload"-->
                        <!--:action="uploadParam.url"-->
                        <!--:show-upload-list="false"-->
                        <!--:on-success="handleBusinessSuccess"-->
                        <!--:format="['jpg','jpeg','png']"-->
                        <!--:max-size="5120"-->
                        <!--:on-format-error="handleFormatError"-->
                        <!--:on-exceeded-size="handleMaxSize"-->
                        <!--:before-upload="handleBusinessBeforeUpload"-->
                        <!--:data="uploadParam"-->
                      <!--&gt;-->
                        <!--<Button icon="md-add" class="border-none"></Button>-->
                      <!--</Upload>-->
                      <!--<Modal title="查看" v-model="visible">-->
                        <!--<img :src="imgName" v-if="visible" style="width: 100%">-->
                      <!--</Modal>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <!--<Row>-->
                  <!--<Col :span="8">-->
                    <!--<FormItem>-->
                      <!--<div class="">上传JPG/PNG图片，且不超过5M</div>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                <!--</Row>-->
                <Row :gutter="10" class="content heigin-none">
                  <Col :span="4" class="mar-b-0 btn-i">
                    <FormItem label="门店正面外观及内部照片">
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
                        v-if="uploadshopList.length === 0"
                      >
                        <Button icon="md-add" class="border-none"></Button>
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
                        v-else
                      >
                        <Button icon="md-add" class="border-none"></Button>
                      </Upload>
                      <Modal title="查看" v-model="visible">
                        <img :src="imgName" v-if="visible" style="width: 100%">
                      </Modal>
                    </FormItem>
                  </Col>
                </Row>
                <Row>
                  <Col :span="12">
                    <FormItem>
                      <div class="">请上传门店正面外观及内部照片，上传JPG/PNG图片，且不超过5M</div>
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
    const validEmail = (rule, value, callback) => {
      if (value) {
        var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/
        if (!reg.test(value)) {
          callback(new Error('邮箱格式不正确'))
        } else {
          callback()
        }
      } else {
        callback(new Error('请输入邮箱'))
      }
    }
    const validateIdCard = (rule, value, callback) => {
      if (value) {
        var reg = /^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/
        if (!reg.test(value)) {
          callback(new Error('身份证号码格式不正确'))
        } else {
          callback()
        }
      } else {
        callback(new Error('请输入身份证号码'))
      }
    }
    // const validateProvince = (rule, value, callback) => {
    //   if (value.length === 0) {
    //     callback(new Error('请填写地址!'))
    //   }
    //   callback()
    // }
    return {
      showItem: '',              // 填充input
      btnLoading: false,
      imgName: '',               // 预览图片
      visible: false,            // 模态框
      uploadshopList: [],        // 门店照片存储
      // uploadBusinessList: [], // 营业执照
      uploadIdentityList: [],    // 身份证
      categoryList: [],          // 商品分类
      AuthorizationList: [],     // 授权条件
      id: null,                  // 修改或者第一次填写
      test: 1,
      random: '',                // 随机数
      form: {
        // 企业信息
        full_name: '',      // 企业全称
        legal_person: '',   // 法人姓名
        enter_phone: '',    // 企业电话
        legal_phone: '',     // 法人手机号
        ein: '',      // 税号
        legal_number: '',    // 法人身份证号
        bank_number: '',         // 银行卡账号
        bank_name: '',           // 开户行
        // enterpriseCreditCode: '',           // 社会信用代码
        taxpayer: '',            // 纳税类型  1.一般纳税人  2.小规模
        // 门店
        store_name: '',           // 门店名称
        name: '',    // 门店联系人姓名
        phone: '',   // 门店联系人手机号
        position: '',       // 职位
        category_id: [],         // 商品分类id
        authorization_id: [],    // 授权条件
        // provinceValue: [],       // 门店地址
        store_address: '',        // 门店详细地址
        operation_situation: '', // 经营情况
        business_license_number: '', // 营业执照号
        // license_id: null,            // 营业执照id
        front_id: null,              // 门店正面照片id
        Inside_id: null,             // 门店内部照片id
        portrait_id: null,           // 身份证正面id
        national_emblem_id: null     // 身份证背面id
      },
      uploadParam: {                 // 传值后台
        'url': '',
        'token': '',
        'x:random': '',
        'x:user_id': this.$store.state.event.user.id,
        'x:target_id': this.$route.query.id,
        'x:type': 0
      },
      province: {             // 门店省
        id: 0,
        name: '',
        list: [],
        show: true
      },  // province city county town
      city: {                 // 门店市
        id: 0,
        name: '',
        list: [],
        show: false
      },
      county: {               // 门店区
        id: 0,
        name: '',
        list: [],
        show: false
      },
      town: {                 // 门店镇/乡
        id: 0,
        name: '',
        list: [],
        show: false
      },
      enterpriseProvince: {             // 企业省
        id: 0,
        name: '',
        list: [],
        show: true
      },  // province city county town
      enterpriseCity: {                 // 企业市
        id: 0,
        name: '',
        list: [],
        show: false
      },
      enterpriseCounty: {               // 企业区
        id: 0,
        name: '',
        list: [],
        show: false
      },
      enterpriseTown: {                 // 企业镇/乡
        id: 0,
        name: '',
        list: [],
        show: false
      },
      formValidate: {
        // 企业信息 >>>
        // 企业全称
        full_name: [
          { required: true, message: '企业全称不能为空', trigger: 'blur' },
          { type: 'string', min: 4, max: 20, message: '企业全称在4-20字符之间', trigger: 'blur' }
        ],
        legal_person: [
          { required: true, message: '姓名不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 30, message: '姓名在2-30字符之间', trigger: 'blur' }
        ],
        // 企业电话
        enter_phone: [
          { required: true, message: '企业电话', trigger: 'blur' },
          { validator: validatePhone, trigger: 'blur' }
        ],
        // 法人手机号
        legal_phone: [
          { required: true, message: '手机号不能为空', trigger: 'blur' },
          { validator: validatePhone, trigger: 'blur' }
        ],
        // 法人身份证号
        enterpriseIdCard: [
          { required: true, message: '身份证号码不能为空', trigger: 'blur' },
          { validator: validateIdCard, trigger: 'blur' }
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
        // 信用代码
        // enterpriseCreditCode: [
        //   { required: true, message: '信用代码不能为空', trigger: 'blur' }
        // ],
        // 纳税类型
        taxpayer: [
          { required: true, message: '请选择纳税类型', trigger: 'change' }
        ],
        // 门店信息  >>>
        // 门店名称
        store_name: [
          { required: true, message: '门店名称不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 20, message: '名称范围在2-20字符之间', trigger: 'blur' }
        ],
        // 门店联系人姓名
        name: [
          { required: true, message: '联系人姓名不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 20, message: '名称范围在2-20字符之间', trigger: 'blur' }
        ],
        // 门店联系人手机号
        phone: [
          { required: true, message: '联系人手机号不能为空', trigger: 'blur' },
          { validator: validatePhone, trigger: 'blur' }
        ],
        // 职位
        position: [
          { required: true, message: '职位不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 20, message: '名称范围在4-20字符之间', trigger: 'blur' }
        ],
        // 邮箱
        storeEmail: [
          { required: true, message: '邮箱不能为空', trigger: 'blur' },
          { validator: validEmail, trigger: 'blur' }
        ],
        // 商品分类
        category_id: [
          { required: true, validator: validateCategory, trigger: 'change' }
        ],
        // 授权条件
        authorization_id: [
          { required: true, validator: validateAuthorization, trigger: 'blur' }
        ],
        // 门店详细地址
        // storeAddress: [
        //   { required: true, message: '详细地址不能为空', trigger: 'blur' },
        //   { type: 'string', min: 4, max: 30, message: '名称范围在4-30字符之间', trigger: 'blur' }
        // ],
        // 经营情况
        operation_situation: [
          { required: true, message: '请选择经营情况', trigger: 'blur' },
          { type: 'string', min: 1, max: 10, message: '范围在1-10字符之间', trigger: 'blur' }
        ],

        // 营业执照号
        business_license_number: [
          { required: true, message: '请填写营业执照号码', trigger: 'blur' },
          { type: 'string', min: 15, max: 18, message: '请检查号码位数', trigger: 'blur' }
        ],
        user_name: [
          { required: true, message: '姓名不能为空', trigger: 'blur' }
        ]
        // 手机号
        // phone: [
        //   { required: true, message: '手机号不能为空', trigger: 'blur' },
        //   { validator: validatePhone, trigger: 'blur' }
        // ]
      },
      msg: ''
    }
  },
  methods: {
    // 预览
    handleView (name) {
      this.imgName = name
      this.visible = true
    },
    // // 营业执照删除
    // handleBusinessRemove (file) {
    //   const fileList = this.uploadBusinessList
    //   this.uploadBusinessList.splice(fileList.indexOf(file), 1)
    // },
    // 营业执照上传成功
    // handleBusinessSuccess (res, file, fileList) {
    //   this.form.license_id = res.asset_id
    //   var add = fileList[fileList.length - 1]
    //   var itemt = {
    //     name: add.response.fileName,
    //     url: add.response.name,
    //     response: {
    //       asset_id: add.response.asset_id
    //     }
    //   }
    //   this.uploadBusinessList.push(itemt)
    // },
    // // 营业执照执行之前
    // handleBusinessBeforeUpload () {
    //   this.uploadParam['x:type'] = 19
    //   const check = this.uploadBusinessList.length < 1
    //   if (!check) {
    //     this.$Message.warning('最多上传一张营业执照')
    //   }
    //   return check
    // },
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
    // handleChange (value, selectedData) {
    //   this.form.provinceValue = selectedData.map(o => o.value).join(',').split(',')
    // },
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
    enterpriseFetchCity (value, layer) {
      const self = this
      self.$http.get(api.fetchCity, {params: {value: value, layer: layer}})
        .then(function (response) {
          if (response.data.meta.status_code === 200) {
            var itemList = response.data.data
            if (itemList.length > 0) {
              if (layer === 1) {
                self.enterpriseProvince.list = itemList
              } else if (layer === 2) {
                self.enterpriseCity.list = itemList
                self.enterpriseCity.show = true
              } else if (layer === 3) {
                self.enterpriseCounty.list = itemList
                self.enterpriseCounty.show = true
              } else if (layer === 4) {
                self.enterpriseTown.list = itemList
                self.enterpriseTown.show = true
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
    enterpriseResetArea (type) {
      switch (type) {
        case 1:
          this.enterpriseCity = this.areaMode()
          this.enterpriseCounty = this.areaMode()
          this.enterpriseTown = this.areaMode()
          this.form.buyer_city = this.form.buyer_county = this.form.buyer_township = ''
          break
        case 2:
          this.enterpriseCounty = this.areaMode()
          this.enterpriseTown = this.areaMode()
          this.form.buyer_county = this.form.buyer_township = ''
          break
        case 3:
          this.enterpriseTown = this.areaMode()
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
        // this.form.buyer_province = data.label
        this.fetchCity(data.value, 2)
      }
    },
    cityChange (data) {
      if (data) {
        if (data.value) {
          this.resetArea(2)
          this.city.id = data.value
          this.city.name = data.label
          // this.form.buyer_city = data.label
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
          // this.form.buyer_county = data.label
          this.fetchCity(data.value, 4)
        }
      }
    },
    townChange (data) {
      if (data.value) {
        this.town.id = data.value
        this.town.name = data.label
        this.form.buyer_township = data.label
      }
    },
    enterpriseProvinceChange (data) {
      if (data.value) {
        this.enterpriseResetArea(1)
        this.enterpriseProvince.id = data.value
        this.enterpriseProvince.name = data.label
        // this.form.buyer_province = data.label
        this.enterpriseFetchCity(data.value, 2)
      }
    },
    enterpriseCityChange (data) {
      if (data) {
        if (data.value) {
          this.enterpriseResetArea(2)
          this.enterpriseCity.id = data.value
          this.enterpriseCity.name = data.label
          // this.form.buyer_city = data.label
          this.enterpriseFetchCity(data.value, 3)
        }
      }
    },
    enterpriseCountyChange (data) {
      if (data) {
        if (data.value) {
          this.enterpriseResetArea(3)
          this.enterpriseCounty.id = data.value
          this.enterpriseCounty.name = data.label
          // this.form.buyer_county = data.label
          this.enterpriseFetchCity(data.value, 4)
        }
      }
    },
    enterpriseTownChange (data) {
      if (data.value) {
        this.enterpriseTown.id = data.value
        this.enterpriseTown.name = data.label
        // this.form.buyer_township = data.label
      }
    },
    // 提交
    submit (ruleName) {
      let distributorStatus = this.$store.state.event.user.distributor_status
      const self = this
      if (distributorStatus !== '2') {
        this.$refs[ruleName].validate((valid) => {
          if (valid) {
            // enterpriseProvince,enterpriseCity,enterpriseCounty
            if (!self.enterpriseProvince.id || !self.enterpriseCity.id || !self.enterpriseCounty.id) {
              self.$Message.error('请选择所在地区!')
              return false
            }
            if (!self.province.id || !self.city.id || !self.county.id) {
              self.$Message.error('请选择所在地区!')
              return false
            }
            // if (self.uploadBusinessList.length === 0) {
            //   self.$Message.error('请上传营业执照!')
            //   return false
            // }
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
              id: self.form.id,                                 // showid
              full_name: self.form.full_name,        // 企业全称
              enter_phone: self.form.enter_phone,    // 企业电话
              legal_person: self.form.legal_person,  // 法人姓名
              legal_phone: self.form.legal_phone,     // 法人手机号
              legal_number: self.form.legal_number,   // 法人身份证
              ein: self.form.ein,   // 税号
              // credit_code: self.form.enterpriseCreditCode,        // 社会信用代码
              bank_number: self.form.bank_number,   // 银行卡账号
              bank_name: self.form.bank_name,       // 开户行
              taxpayer: self.form.taxpayer,         // 纳税类型
              store_name: self.form.store_name,      // 门店名称
              name: self.form.name,     // 门店联系人姓名
              phone: self.form.phone,   // 门店联系人手机号
              position: self.form.position,    // 职位
              category_id: self.form.category_id.join(','),   // 商品分类id
              authorization_id: self.form.authorization_id.join(','), // 授权条件
              province_id: self.province.id,   // 门店省
              city_id: self.city.id,           // 门店市
              county_id: self.county.id,       // 门店区
              enter_province: self.enterpriseProvince.id,   // 企业省
              enter_city: self.enterpriseCity.id,           // 企业市
              enter_county: self.enterpriseCounty.id,       // 企业区
              // store_address: self.form.storeAddress,      // 门店详细地址
              operation_situation: self.form.operation_situation,  // 经营情况
              business_license_number: self.form.business_license_number, // 营业执照号
              // license_id: self.form.license_id,   // 营业执照id
              front_id: self.form.front_id,       // 门店正面照片id
              Inside_id: self.form.Inside_id,     // 门店内部照片id
              portrait_id: self.form.portrait_id, // 身份证正面id
              national_emblem_id: self.form.national_emblem_id,   // 身份证背面id
              random: self.random   // 随机数
            }
            self.btnLoading = true
            // let commitMessage = null
            // if (self.id) {
            //   commitMessage = api.updateMessage
            //   row.id = self.id
            // } else {
            //   commitMessage = api.addMessage
            // }
            // 保存数据
            self.$http.post(api.updateMessage, row)
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
      } else {
        self.$Message.error('您已经认证成功,请勿重复申请!')
      }
    }
  },
  computed: {
  },
  created: function () {
    let token = this.$store.state.event.token
    let self = this
    // 获取图片上传信息
    self.$http.get(api.upToken, {params: {token: token}})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (response.data.data) {
            self.uploadParam.token = response.data.data.token
            self.uploadParam.url = response.data.data.url
            self.uploadParam['x:random'] = response.data.data.random
            self.random = response.data.data.random
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
    self.$http.get(api.city)
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (response.data.data) {
            self.province.list = response.data.data
            self.enterpriseProvince.list = response.data.data
            // self.fetchCity(token, 2)
          }
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        return false
      })
  },
  mounted () {
    if (localStorage.getItem('storesInfo')) {
      this.form = JSON.parse(localStorage.getItem('storesInfo'))
      this.enterpriseProvince.id = this.form.enter_province    // 获企业取省市id
      this.enterpriseFetchCity(this.form.enter_province, 2)    // 调用企业城市id
      this.enterpriseCity.id = this.form.enter_city        // 获取企业城市id
      this.enterpriseFetchCity(this.form.enter_city, 3)        // 调用企业城市id
      this.enterpriseCounty.id = this.form.enter_county     // 获取企业区县
      // ----------------/
      this.province.id = this.form.province_id // 获取门店省市id
      this.fetchCity(this.form.province_id, 2)    // 调用门店城市id
      this.city.id = this.form.city_id  // 获取门店市id
      this.fetchCity(this.form.city_id, 3)    // 调用门店城市id
      this.county.id = this.form.county_id    // 获取门店区id

      if (this.form.category_id === '') {
        this.form.category_id = this.form.category_id.split(',')
      } else {
        this.form.category_id = this.form.category_id
      }
      if (this.form.authorization_id === '') {
        this.form.authorization_id = this.form.authorization_id.split(',')
      } else {
        this.AuthorizationList = this.form.authorization_id
      }
    }
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
  /*企业信息row*/
  .order-content .padd-none .ivu-row {
    padding: 0;
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

  .product-total p span {
    font-weight: 600;
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
    line-height: 1;
    border: 1px dashed #dddee1;
    background: #fff;
    color: #495060;
  }

  .heigin-none .ivu-upload .ivu-btn {
    width: 150px;
    height: 33px;
  }

</style>
