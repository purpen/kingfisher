<template>
  <div class="register">
    <div class="container margin-b-105" style="padding-left: 120px;width: 960px">
      <Steps :current="current">
        <Step title="验证手机号"></Step>
        <Step title="填写账号信息"></Step>
        <Step title="填写门店信息"></Step>
      </Steps>
    </div>
    <!--form-->
    <div class="container isphone">
      <!--<div class="padd-172">-->
      <!-------------------->
      <Form v-show="current === 0" ref="isPhone" :model="form" :rules="isPhoneForm"  class="wid-360 prepend-75">
        <FormItem prop="phone">
          <Input type="text" v-model="form.phone" placeholder="请填写常用手机号">
            <span slot="prepend" class="background-fff border-r-fff">中国 +86</span>
          </Input>
        </FormItem>
        <FormItem prop="smsCode" class="appendColor">
          <Input v-model="form.smsCode" placeholder="输入验证码">
            <span slot="prepend" class="background-fff border-r-fff">手机验证码</span>
            <span slot="append"><Button type="primary" class="code-btn" @click.native="fetchCode" :disabled="time > 0">{{ codeMsg }}</Button></span>
          </Input>
        </FormItem>
        <div class="display-flex-algin" v-if="sendSms">
          <img class="wid-16" src="../../../assets/images/icon/icon-gt.png" alt="">
          <span class="margin-l-10 color_ed3a">验证码已发送，60秒内输入有效</span>
        </div>
        <Checkbox class="margin-t-10" v-model="single">我已阅读并同意<router-link to="login">《铟立方平台协议和隐私条款》</router-link></Checkbox>
        <div class="register-button">
          <Button size="large" class="wid_100 margin-t-20 margin-b-40" @click="isPhone('isPhone')">下一步</Button>
        </div>
      </Form>
      <!-------------------->
      <Form v-show="current === 1" ref="form" :model="form" :rules="ruleForm" class="wid-360 prepend-63">
        <FormItem label="" prop="userName">
          <Input v-model="form.userName" placeholder="您的账户名和登录名">
            <span slot="prepend">用户名</span>
          </Input>
        </FormItem>
        <FormItem label="" prop="password">
          <Input type="password" v-model="form.password" placeholder="输入密码">
            <span slot="prepend">设置密码</span>
          </Input>
        </FormItem>
        <FormItem label="" prop="checkPassword">
          <Input type="password" v-model="form.checkPassword" placeholder="确认密码">
           <span slot="prepend">确认密码</span>
          </Input>
        </FormItem>
        <div class="register-button">
          <Button class="wid_100 margin-t-40" size="large" @click="nextStep('form')">下一步</Button>
        </div>
      </Form>
      <!--</div>-->
      <Form v-show="current === 2" ref="company" :model="form" :rules="companyForm" :label-width="85" class="wid-850">
        <FormItem label="门店联系人" prop="name">
          <Input class="wid-290" v-model="form.name"/>
        </FormItem>
        <FormItem label="门店名称" prop="store_name">
          <Input v-model="form.store_name"/>
        </FormItem>
        <FormItem label="门店地址" prop="provinceValue">
          <Row :gutter="10" class="content">
            <Col :span="4" style="padding-left: 0">
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
        <FormItem label="详细地址">
          <Input placeholder="请输入详细地址" v-model="form.store_address"/>
        </FormItem>
        <!--<FormItem label="主要情况" prop="condition">-->
          <!--<Input type="textarea" v-model="form.main" :autosize="{minRows: 4,maxRows: 10}" placeholder="请输入您的门店主要经营类目、月营业额等进行介绍"/>-->
        <!--</FormItem>-->
        <FormItem label="上传照片">
          <div class="upload">
            <Row :gutter="40">
              <Col :span="4" class="display-f">
                <div class="demo-upload-list" v-for="item in uploadList_MZ">
                  <template>
                    <img :src="item.url">
                    <div class="demo-upload-list-cover">
                      <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                      <Icon type="ios-trash-outline" @click.native="handleRemove_MZ(item)"></Icon>
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
                  :on-success="handleSuccess_MZ"
                  :format="['jpg','jpeg','png']"
                  :max-size="5120"
                  :on-format-error="handleFormatError"
                  :on-exceeded-size="handleMaxSize"
                  :before-upload="handleBeforeUpload_MZ"
                  :data="uploadParam"
                  v-if="!uploadList_MZ.length != 0"
                >
                  <div style="padding: 20px 0;cursor: pointer">
                    <Icon type="ios-add" size="52" style="color: #c2c2c2"></Icon>
                  </div>
                </Upload>
                <p class="text-center color_49 font-12">门店正面照片</p>
              </Col>
              <Col :span="4" class="display-f">
                <div class="demo-upload-list" v-for="item in uploadList_MN">
                  <template>
                    <img :src="item.url">
                    <div class="demo-upload-list-cover">
                      <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                      <Icon type="ios-trash-outline" @click.native="handleRemove_MN(item)"></Icon>
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
                  :on-success="handleSuccess_MN"
                  :format="['jpg','jpeg','png']"
                  :max-size="5120"
                  :on-format-error="handleFormatError"
                  :on-exceeded-size="handleMaxSize"
                  :before-upload="handleBeforeUpload_MN"
                  :data="uploadParam"
                  v-if="!uploadList_MN.length != 0"
                >
                  <div style="padding: 20px 0;cursor: pointer">
                    <Icon type="ios-add" size="52" style="color: #c2c2c2"></Icon>
                  </div>
                </Upload>
                <p class="text-center color_49 font-12">门店内部照片</p>
              </Col>
              <Col :span="4" class="display-f">
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
                  v-if="!uploadBusinessList.length != 0"
                >
                  <div style="padding: 20px 0;cursor: pointer">
                    <Icon type="ios-add" size="52" style="color: #c2c2c2"></Icon>
                  </div>
                </Upload>
                <p class="text-center color_49 font-12">营业执照</p>
              </Col>
              <Col :span="4" class="display-f">
                <div class="demo-upload-list" v-for="item in uploadList_SFZZ">
                  <template>
                    <img :src="item.url">
                    <div class="demo-upload-list-cover">
                      <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                      <Icon type="ios-trash-outline" @click.native="handleRemove_SFZZ(item)"></Icon>
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
                  :on-success="handleSuccess_SFZZ"
                  :format="['jpg','jpeg','png']"
                  :max-size="5120"
                  :on-format-error="handleFormatError"
                  :on-exceeded-size="handleMaxSize"
                  :before-upload="handleBeforeUpload_SFZZ"
                  :data="uploadParam"
                  v-if="!uploadList_SFZZ.length != 0"
                >
                  <div style="padding: 20px 0;cursor: pointer">
                    <Icon type="ios-add" size="52" style="color: #c2c2c2"></Icon>
                  </div>
                </Upload>
                <p class="text-center color_49 font-12">身份证人像面</p>
              </Col>
              <Col :span="4" class="display-f">
                <div class="demo-upload-list" v-for="item in uploadList_SFZF">
                  <template>
                    <img :src="item.url">
                    <div class="demo-upload-list-cover">
                      <Icon type="ios-eye-outline" @click.native="handleView(item.url)"></Icon>
                      <Icon type="ios-trash-outline" @click.native="handleRemove_SFZF(item)"></Icon>
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
                  :on-success="handleSuccess_SFZF"
                  :format="['jpg','jpeg','png']"
                  :max-size="5120"
                  :on-format-error="handleFormatError"
                  :on-exceeded-size="handleMaxSize"
                  :before-upload="handleBeforeUpload_SFZF"
                  :data="uploadParam"
                  v-if="!uploadList_SFZF.length != 0"
                >
                  <div style="padding: 20px 0;cursor: pointer">
                    <Icon type="ios-add" size="52" style="color: #c2c2c2"></Icon>
                  </div>
                </Upload>
                <p class="text-center color_49 font-12">身份证国徽面</p>
              </Col>
            </Row>
          </div>
          <Modal title="查看" v-model="visible" class="viseble_none">
            <img :src="imgName" v-if="visible" style="width: 100%">
          </Modal>
        </FormItem>
        <p class="padd-85 font-12 color-49 margin-b-15"><span class="color-ed3b">*</span>为必填选项图片仅支持上传一张2MB以内的照片，建议将最清晰的展示照片上传</p>
        <!--<Checkbox class="padd-85 margin-b-80" v-model="single2">我已阅读并同意</Checkbox><span class="margin-l-10">登录即同意《铟立方平台协议》。</span>-->
        <div class="margin-auto text-center wid-500 newreg">
          <Button size="large" @click="submit('company')">注册</Button>
        </div>
      </Form>
    </div>
    <!--<div v-if="current === 3" class="text-center">-->
      <!--<div>-->
        <!--<img src="../../../assets/images/home/icons/icon-ok.png" alt="">-->
      <!--</div>-->
      <!--<div class="margin-t-20 margin-b-80">-->
        <!--<p class="font-22 color_333 font-wei">注册成功!</p>-->
      <!--</div>-->
      <!--<div class="margon-b-130 clickLogin">-->
        <!--<p class="font-16">5s后系统将自动跳转，如未跳转请点击 <router-link to="login">立即登录</router-link></p>-->
        <!--<p class="font-16">后续将有客服人员与您电话联系。</p>-->
      <!--</div>-->
    <!--</div>-->
  </div>
</template>

<script>
  import api from '@/api/api'
  import auth from '@/helper/auth'
  export default {
    props: {
      second: {
        type: Number,
        default: 60
      }
    },
    data () {
      const validPassword = (rule, value, callback) => {
        let reg = /^[a-z0-9]+$/i
        if (value) {
          if (!reg.test(value)) {
            callback(new Error('密码格式不正确,且不能包含特殊字符'))
          } else {
            callback()
          }
        } else {
          callback(new Error('请输入密码'))
        }
      }
      const checkPassword = (rule, value, callback) => {
        if (value === '') {
          callback(new Error('请再次输入密码'))
        } else if (value !== this.form.password) {
          callback(new Error('两次输入密码不一致!'))
        } else {
          callback()
        }
      }
      return {
        current: 0,          // 步骤条
        isLoadingBtn: false, // loading
        time: 0,             // 验证码时间
        sendSms: false,      // 验证码发送成功后提示
        single: false,       // 协议
        single2: false,      // 铟立方协议
        imgName: '',               // 预览
        visible: false,      // 显示框
        uploadList_MZ: [],   // 门店正面照
        uploadList_MN: [],   // 门店内部照
        uploadList_SFZZ: [],        // 身份证正面
        uploadList_SFZF: [],        // 身份证反面
        uploadBusinessList: [],     // 营业执照
        timeOut: null,              // 倒计时
        random: '',
        form: {
          type: 1,
          phone: '',          // 手机号
          smsCode: '',        // 短信验证码
          password: '',       // 密码
          checkPassword: '',  // 重复密码
          userName: '',       // 用户名
          // ----------
          name: '',             // 姓名
          store_name: '',       // 门店名称
          buyer_province: '',   // 省
          buyer_city: '',       // 市
          buyer_county: '',     // 区
          buyer_township: '',   // 镇
          enter_province: '',  // 企业省
          enter_city: '',     // 企业市
          enter_county: '',   // 企业区
          ein: '',           // 税号
          enter_phone: '',           // 企业电话
          store_address: ''    // 门店详细地址
          // main: ''              // 主要情况
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
        uploadParam: {          // 传值后台
          'url': '',
          'token': '',
          'x:random': '',
          'x:user_id': this.$store.state.event.user.id,
          'x:target_id': this.$route.query.id,
          'x:type': 0
        },
        // 1
        isPhoneForm: {
          phone: [
            { required: true, message: '请输入手机号码', trigger: 'blur' },
            { min: 11, max: 11, message: '手机号码位数不正确！', trigger: 'blur' }
          ],
          smsCode: [
            { required: true, message: '请输入验证码', trigger: 'blur' },
            { min: 6, max: 6, message: '验证码格式不正确！', trigger: 'blur' }
          ]
        },
        // 2
        ruleForm: {
          userName: [
            {required: true, message: '请输入用户名', trigger: 'blur'},
            { min: 2, max: 16, message: '用户名长度在2-16字符之间！', trigger: 'blur' }
          ],
          password: [
            { required: true, message: '请输入密码', trigger: 'change' },
            { min: 6, max: 18, message: '密码长度在6-18字符之间！', trigger: 'blur' },
            { validator: validPassword, trigger: 'blur' }
          ],
          checkPassword: [
            { required: true, validator: checkPassword, trigger: 'blur' }
          ]
        },
        companyForm: {
          name: [
            { required: true, message: '请输入门店联系人', trigger: 'blur' },
            { min: 2, max: 16, message: '姓名长度在2-6字符之间', trigger: 'blur' }
          ],
          store_name: [
            { required: true, message: '请输入门店名称', trigger: 'blur' },
            { type: 'string', min: 4, max: 20, message: '名称范围在4-20字符之间', trigger: 'blur' }
          ],
          store_address: [
            { required: true, message: '请输入门店详细地址', trigger: 'blur' },
            { type: 'string', min: 2, max: 20, message: '名称范围在2-20字符之间', trigger: 'blur' }
          ]
          // ,
          // condition: [
          //   { required: false, message: '请输入主要情况', trigger: 'blur' },
          //   { type: 'string', min: 4, max: 50, message: '范围在4-50字符之间', trigger: 'blur' }
          // ]
        }
      }
    },
    methods: {
      isPhone (formName) {
        let self = this
        let message = {
          phone: self.form.phone,
          code: self.form.smsCode
        }
        self.$http.post(api.verify, message)
          .then(function (res) {
            if (res.data.meta.status_code === 200) {
              self.isPhoneValid(formName)
            } else {
              self.$Message.error(res.data.meta.message)
            }
          })
          .catch(function (error) {
            self.$Message.error(error)
          })
      },
      isPhoneValid (formName) {
        let self = this
        self.$refs[formName].validate(valid => {
          if (valid) {
            self.current ++
            if (self.single) {
              self.current ++
            } else {
              self.$Message.error('如已阅读,请勾选平台协议!')
            }
          } else {
            self.$Message.error('请填写信息!')
          }
        })
      },
      nextStep (formName) {
        this.$refs[formName].validate(valid => {
          if (valid) {
            this.current ++
          } else {
            // this.$Message.error('请填写信息!')
          }
        })
      },
      submit (formName) {
        const that = this
        that.$refs[formName].validate((valid) => {
          if (valid) {
            if (that.uploadList_MZ.length === 0) {
              that.$Message.error('请上传门店正面照!')
              return false
            }
            if (that.uploadList_MN.length === 0) {
              that.$Message.error('请上传门店内部照!')
              return false
            }
            if (that.uploadList_SFZZ.length === 0) {
              that.$Message.error('请上传身份证人像面面!')
              return false
            }
            if (that.uploadList_SFZF.length === 0) {
              that.$Message.error('请上传身份证国徽面!')
              return false
            }
            if (that.uploadBusinessList.length === 0) {
              that.$Message.error('请上传营业执照!')
              return false
            }
            if (!that.form.buyer_province || !that.form.buyer_city || !that.form.buyer_county) {
              that.$Message.error('请选择所在地区!')
              return false
            }
            if (!that.form.store_address) {
              that.$Message.error('请输入详细地址!')
              return false
            }
            if (!that.single2) {
              that.$Message.error('如已阅读,请勾选平台协议!')
              return false
            }
            let row = {
              phone: this.form.phone,                 // 手机号
              code: this.form.smsCode,                // 短信验证码
              password: this.form.password,           // 密码
              account: this.form.userName,            // 用户名
              name: this.form.name,                   // 姓名
              store_name: this.form.name,             // 门店名称
              province_id: this.form.buyer_province,   // 省
              city_id: this.form.buyer_city,       // 市
              county_id: this.form.buyer_county,   // 区
              enter_province: this.form.enter_province,   // 企业省
              enter_city: this.form.enter_city,       // 企业市
              enter_county: this.form.enter_county,   // 企业区
              ein: this.form.ein,                     // 税号
              enter_phone: this.form.enter_phone,     // 企业电话
              random: this.random,                      // 随机数
              operation_situation: '',                  // 主要情况
              position: '',                             // 职位
              full_name: '',        // 企业全称
              legal_person: '',     // 法人姓名
              legal_phone: '',      // 法人手机号
              legal_number: ''     // 法人身份证
            }
            that.isLoadingBtn = true
            // 验证通过，注册
            that.$http.post(api.register, row)
              .then(function (response) {
                that.isLoadingBtn = false
                if (response.data.meta.status_code === 200) {
                  var token = response.data.data.token
                  // 写入localStorage
                  auth.write_token(token)
                  // ajax拉取用户信息
                  that.$http.get(api.user, {})
                    .then(function (response) {
                      if (response.data.meta.status_code === 200) {
                        auth.write_user(response.data.data)
                        that.$Message.success('注册成功')
                        that.$router.replace({name: 'home'})
                        that.current = 0
                      } else {
                        auth.logout()
                        that.$Message.error(response.data.meta.message)
                      }
                    })
                    .catch(function (error) {
                      auth.logout()
                      that.$Message.error(error.message)
                    })
                } else {
                  that.$Message.error(response.data.meta.message)
                }
              })
              .catch(function (error) {
                that.$Message.error(error.message)
                that.isLoadingBtn = false
                return false
              })
          } else {
          }
        })
      },
      // 验证码
      fetchCode () {
        var phone = this.form.phone
        if (phone === '') {
          this.$Message.error('请输入手机号码')
          return
        }

        if (phone.length !== 11 || !/^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(phone)) {
          this.$Message.error('手机号格式不正确!')
          return
        }

        var url = api.check_account1
        // 检测手机号是否存在
        const that = this
        that.$http.get(url, {params: {phone: phone}})
          .then(function (response) {
            if (response.data.meta.status_code === 200) {
              // 获取验证码
              that.$http.post(api.getRegisterCode, {phone: phone})
                .then(function (response) {
                  if (response.data.meta.status_code === 200) {
                    that.time = that.second
                    that.timer()
                    that.$emit('send')
                    that.sendSms = true
                  } else {
                    that.$Message.error(response.data.meta.message)
                  }
                })
                .catch(function (error) {
                  that.$Message.error(error.message)
                  return false
                })
            } else {
              that.$Message.error(response.data.meta.message)
            }
          })
          .catch(function (error) {
            that.$Message.error(error.message)
          })
      },
      // 验证码倒计时
      timer () {
        if (this.time > 0) {
          this.time = this.time - 1
          setTimeout(this.timer, 1000)
        } else {
          this.sendSms = false
        }
      },
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
      },
      // 上传 预览
      handleView (name) {
        this.imgName = name
        this.visible = true
      },
      // -----------------------门店正面照-------------------------
      // 门店正面照删除
      handleRemove_MZ (file) {
        const fileList = this.uploadList_MZ
        this.uploadList_MZ.splice(fileList.indexOf(file), 1)
      },
      // 门店正面照执行之前
      handleBeforeUpload_MZ () {
        this.uploadParam['x:type'] = 17
      },
      // 门店正面照上传成功
      handleSuccess_MZ (res, file, fileList) {
        this.form.license_id = res.asset_id
        var add = fileList[fileList.length - 1]
        var itemt = {
          name: add.response.fileName,
          url: add.response.name,
          response: {
            asset_id: add.response.asset_id
          }
        }
        this.uploadList_MZ.push(itemt)
      },
      // -----------------------门店内部照-------------------------
      // 门店内部照删除
      handleRemove_MN (file) {
        const fileList = this.uploadList_MN
        this.uploadList_MN.splice(fileList.indexOf(file), 1)
      },
      // 门店内部照执行之前
      handleBeforeUpload_MN () {
        this.uploadParam['x:type'] = 18
      },
      // 门店内部照上传成功
      handleSuccess_MN (res, file, fileList) {
        this.form.license_id = res.asset_id
        var add = fileList[fileList.length - 1]
        var itemt = {
          name: add.response.fileName,
          url: add.response.name,
          response: {
            asset_id: add.response.asset_id
          }
        }
        this.uploadList_MN.push(itemt)
      },
      // -----------------------营业执照-------------------------
      // 营业执照删除
      handleBusinessRemove (file) {
        const fileList = this.uploadBusinessList
        this.uploadBusinessList.splice(fileList.indexOf(file), 1)
      },
      // 营业执照执行之前
      handleBusinessBeforeUpload () {
        this.uploadParam['x:type'] = 19
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
      // -----------------------身份证正面-------------------------
      handleRemove_SFZZ (file) {
        const fileList = this.uploadList_SFZZ
        this.uploadList_SFZZ.splice(fileList.indexOf(file), 1)
      },
      // 身份证正面执行之前
      handleBeforeUpload_SFZZ () {
        this.uploadParam['x:type'] = 20
      },
      // 身份证正面上传成功
      handleSuccess_SFZZ (res, file, fileList) {
        this.form.license_id = res.asset_id
        var add = fileList[fileList.length - 1]
        var itemt = {
          name: add.response.fileName,
          url: add.response.name,
          response: {
            asset_id: add.response.asset_id
          }
        }
        this.uploadList_SFZZ.push(itemt)
      },
      // -----------------------身份证反面-------------------------
      handleRemove_SFZF (file) {
        const fileList = this.uploadList_SFZF
        this.uploadList_SFZF.splice(fileList.indexOf(file), 1)
      },
      // 身份证正面执行之前
      handleBeforeUpload_SFZF () {
        this.uploadParam['x:type'] = 21
      },
      // 身份证正面上传成功
      handleSuccess_SFZF (res, file, fileList) {
        this.form.license_id = res.asset_id
        var add = fileList[fileList.length - 1]
        var itemt = {
          name: add.response.fileName,
          url: add.response.name,
          response: {
            asset_id: add.response.asset_id
          }
        }
        this.uploadList_SFZF.push(itemt)
      },
      // 上传
      handleFormatError (file) {
        this.$Message.warning('图片格式不正确')
      },
      handleMaxSize (file) {
        this.$Message.warning('图片大小最大为5M')
      }
    },
    created () {
      let self = this
      // 获取图片上传信息
      self.$http.get(api.upToken)
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
    mounted () {
      const self = this
      window.addEventListener('keydown', function (e) {
        if (e.keyCode === 13) {
          self.submit('ruleForm')
        }
      })
    },
    computed: {
      codeMsg () {
        return this.time > 0 ? '重新发送' + this.time + 's' : '获取验证码'
      }
    },
    beforeRouteLeave (to, from, next) {
      // 导航离开该组件的对应路由时调用) {
      if (to.name === 'login') {
        this.current = 0
      }
      next()
    }
  }
</script>

<style scoped>
  .register {
    margin-top: 80px;
  }

  .line-hei span{
    line-height: 47px;
  }

  .wid-72 img {
    width: 100%;
    height: 100%;
  }

  .color_ed3a {
    color: #ED3A4A;
  }

  .margin-b-105 {
    margin-bottom: 105px;
  }

  .wid-360 {
    width: 360px;
    margin: 0 auto;
  }


  .register-button .ivu-btn {
    color: #ffffff;
    background-color: #EC3A4A;
    border-color: #EC3A4A;
    margin-bottom: 90px;
  }

  .wid-290 {
    width: 290px;
  }

  .wid-850 {
    width: 850px;
    margin: 0 auto;
  }

  .upload {
    border: 1px dotted rgba(153,153,153,1);
    padding: 33px 36px;
    border-radius: 4px;
  }

  .color_49 {
    color: #49505f;
  }

  .demo-upload-list{
    display: inline-block;
    width: 100%;
    height: 120px;
    text-align: center;
    line-height: 120px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    margin-right: 4px;
  }
  .demo-upload-list img{
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    margin: auto;
    width: 100%;
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

  .color-ed3b {
    color: #ED3B4A;
    /*margin-right: 17px;*/
  }

  .color-49 {
    color: #49505F;
  }

  .margin-b-80 {
    margin-bottom: 80px;
  }

  .newreg .ivu-btn {
    width: 100%;
    color: #ffffff;
    background-color: #EC3A4A;
    border-color: #EC3A4A;
    margin-bottom: 100px;
  }

  .footer {
    background: #000000;
    height: 155px;
    padding: 64px 0 61px 0;
  }

  .padd-85 {
    padding-left: 85px;
  }

  .clickLogin a {
    color: #DC3838;
  }

  .wid-16 {
    width: 16px;
  }

  .display-f {
    height: 164px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
</style>
