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
                  企业信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="12">
                    <FormItem label="企业名称" prop="company">
                      <Input v-model="form.company" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="8">
                    <FormItem label="证件类型" prop="company_type">
                      <Select v-model="form.company_type" number>
                          <Option :value="d.value" v-for="(d, index) in certificateTypeOptions" :key="index">{{ d.label }}</Option>
                      </Select>
                    </FormItem>
                  </Col>
                  <Col :span="8">
                    <FormItem label="统一社会信用代码" prop="registration_number">
                      <Input v-model="form.registration_number" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="12">
                    <FormItem label="公司营业执照">
                      <Upload
                        :action="uploadParam.url"
                        :format="['pdf','jpg', 'jpeg']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :on-preview="handlePreview"
                        :default-file-list="fileList"
                        :data="uploadParam"
                        :before-upload="beforeUpload"
                        :on-remove="handleRemove"
                        :on-success="uploadSuccess"
                      >
                          <Button type="ghost" icon="ios-cloud-upload-outline">上传文件</Button>
                          <div slot="tip" class="">只能上传jpg/pdf文件，且不超过5M</div>
                      </Upload>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="22">
                    <FormItem label="公司简介" prop="introduction">
                      <Input v-model="form.introduction" type="textarea" :rows="3" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <p class="banner">
                  法人信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="5">
                    <FormItem label="法人姓名" prop="legal_person">
                      <Input v-model="form.legal_person" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content" prop="buyer_phone">
                  <Col :span="5">
                    <FormItem label="证件类型" prop="document_type">
                      <Select v-model="form.document_type" number>
                          <Option :value="d.value" v-for="(d, index) in documentTypeOptions" :key="index">{{ d.label }}</Option>
                      </Select>
                    </FormItem>
                  </Col>
                  <Col :span="8">
                    <FormItem label="证件号码" prop="document_number">
                      <Input v-model="form.document_number" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
                <Row :gutter="10" class="content">
                  <Col :span="12">
                    <FormItem label="法人证件">
                      <Upload
                        :action="uploadParam.url"
                        :format="['pdf','jpg', 'jpeg']"
                        :max-size="5120"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        :on-preview="handlePreview"
                        :default-file-list="filePersonList"
                        :data="uploadParam"
                        :before-upload="beforeUploadPerson"
                        :on-remove="handlePersonRemove"
                        :on-success="uploadSuccessPerson"
                      >
                          <Button type="ghost" icon="ios-cloud-upload-outline">上传文件</Button>
                          <div slot="tip" class="">只能上传jpg/pdf文件，且不超过5M</div>
                      </Upload>
                    </FormItem>
                  </Col>
                </Row>

                <p class="banner">
                  联系人信息
                </p>
                <Row :gutter="10" class="content">
                  <Col :span="5">
                    <FormItem label="姓名" prop="contact_name">
                      <Input v-model="form.contact_name" placeholder=""></Input>
                    </FormItem>
                  </Col>
                  <Col :span="5">
                    <FormItem label="职位" prop="position">
                      <Input v-model="form.position" placeholder=""></Input>
                    </FormItem>
                  </Col>
                  <Col :span="5">
                    <FormItem label="手机" prop="contact_phone">
                      <Input v-model="form.contact_phone" placeholder=""></Input>
                    </FormItem>
                  </Col>
                  <Col :span="5">
                    <FormItem label="邮箱" prop="email">
                      <Input v-model="form.email" placeholder=""></Input>
                    </FormItem>
                  </Col>
                </Row>
              </div>
              <div class="form-btn">
                <FormItem>
                  <Button type="ghost" style="margin-left: 8px">取消</Button>
                  <Button type="primary" :loading="btnLoading" @click="submit('form')">提交</Button>
                </FormItem>
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
import typeData from '@/config'
export default {
  name: 'center_order_submit',
  components: {
    vMenu
  },
  data () {
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
    const checkNumber = (rule, value, callback) => {
      if (!value) {
        return callback(new Error('请添写公司注册号!'))
      }
      var len = value.toString().length
      if (len === 15 || len === 18) {
        callback()
      } else {
        callback(new Error('注册号长度应为15或18位'))
      }
    }
    return {
      btnLoading: false,
      fileList: [],
      filePersonList: [],
      form: {
        company: '',
        company_type: '',
        registration_number: '',
        introduction: '',
        legal_person: '',
        document_type: '',
        document_number: '',
        contact_name: '',
        position: '',
        contact_phone: '',
        email: '',

        test: ''
      },
      uploadParam: {
        'url': '',
        'token': '',
        'x:random': '',
        'x:user_id': this.$store.state.event.user.id,
        'x:target_id': this.$store.state.event.user.id,
        'x:type': 0
      },
      formValidate: {
        company: [
          { required: true, message: '企业名称不能为空', trigger: 'blur' },
          { type: 'string', min: 4, max: 20, message: '名称范围在4-20字符之间', trigger: 'blur' }
        ],
        company_type: [
          { type: 'number', required: true, message: '请选择证件类型', trigger: 'change' }
        ],
        registration_number: [
          { required: true, message: '请添写企业证件号', trigger: 'blur' },
          { validator: checkNumber, trigger: 'blur' }
        ],
        introduction: [
          { required: true, message: '公司简介不能为空', trigger: 'blur' },
          { type: 'string', min: 10, max: 500, message: '名称范围在10-500字符之间', trigger: 'blur' }
        ],
        legal_person: [
          { required: true, message: '法人姓名不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 20, message: '范围在2-20字符之间', trigger: 'blur' }
        ],
        document_type: [
          { type: 'number', required: true, message: '请选择证件类型', trigger: 'change' }
        ],
        document_number: [
          { required: true, message: '证件号不能为空', trigger: 'blur' },
          { type: 'string', min: 5, max: 30, message: '范围在5-30字符之间', trigger: 'blur' }
        ],
        contact_name: [
          { required: true, message: '联系人不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 20, message: '范围在2-20字符之间', trigger: 'blur' }
        ],
        contact_phone: [
          { required: true, message: '手机号不能为空', trigger: 'blur' },
          { validator: validatePhone, trigger: 'blur' }
        ],
        email: [
          { required: true, message: '请添写联系人邮箱', trigger: 'blur' },
          { type: 'email', message: '请输入正确的邮箱格式', trigger: 'blur' }
        ],
        position: [
          { required: true, message: '联系人职位不能为空', trigger: 'blur' },
          { type: 'string', min: 2, max: 20, message: '范围在4-20字符之间', trigger: 'blur' }
        ]
      },
      msg: ''
    }
  },
  methods: {
    // 提交
    submit (ruleName) {
      const self = this
      this.$refs[ruleName].validate((valid) => {
        if (valid) {
          if (self.fileList.length === 0) {
            self.$Message.error('请上传公司营业执照!')
            return false
          }
          if (self.filePersonList.length === 0) {
            self.$Message.error('请上传法人证件!')
            return false
          }
          var row = {
            company: self.form.company,
            company_type: self.form.company_type,
            registration_number: self.form.registration_number,
            introduction: self.form.introduction,
            legal_person: self.form.legal_person,
            document_type: self.form.document_type,
            document_number: self.form.document_number,
            contact_name: self.form.contact_name,
            position: self.form.position,
            contact_phone: self.form.contact_phone,
            email: self.form.email,
            test: ''
          }

          self.btnLoading = true
          // 保存数据
          self.$http.put(api.updateUser, row)
          .then(function (response) {
            self.btnLoading = false
            if (response.data.meta.status_code === 200) {
              self.$Message.success('操作成功！')
              self.$router.push({name: 'centerIdentifyShow'})
              // console.log(response.data.data)
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
    // 删除附件
    handleRemove (file, fileList) {
      if (file === null) {
        return false
      }
      var assetId = file.response.asset_id
      this.removeAsset(assetId, fileList, 1)
    },
    // 删除附件
    handlePersonRemove (file, fileList) {
      if (file === null) {
        return false
      }
      var assetId = file.response.asset_id
      this.removeAsset(assetId, fileList, 2)
    },
    // 删除附件
    removeAsset (id, fileList, type) {
      const self = this
      self.$http.post(api.deleteAsset, {id: id})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          if (type === 1) {
            self.fileList = fileList
          } else {
            self.filePersonList = fileList
          }
        } else {
          self.$Message.error(response.data.meta.message)
          return false
        }
      })
      .catch(function (error) {
        self.$Message.error(error.message)
        console.log(error.message)
        return false
      })
    },
    // 文件格式钩子
    handleFormatError (file, fileList) {
      this.$Message.error('文件格式不正确!')
      return false
    },
    // 文件大小钩子
    handleMaxSize (file, fileList) {
      this.$Message.error('文件大小不能超过2M!')
      return false
    },
    // 文件上传钩子
    handlePreview (file) {
    },
    uploadError (err, file, fileList) {
      this.$Message.error(err + '附件上传失败!')
    },
    uploadSuccess (response, file, fileList) {
      var add = fileList[fileList.length - 1]
      var item = {
        name: add.name,
        url: add.url,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.fileList.push(item)
    },
    uploadSuccessPerson (response, file, fileList) {
      var add = fileList[fileList.length - 1]
      var item = {
        name: add.name,
        url: add.url,
        response: {
          asset_id: add.response.asset_id
        }
      }
      this.filePersonList.push(item)
    },
    beforeUpload (file) {
      const arr = ['image/jpeg', 'image/gif', 'image/png', 'application/pdf']
      const isLt5M = file.size / 1024 / 1024 < 5
      this.uploadParam['x:type'] = 6

      console.log(file)
      if (arr.indexOf(file.type) === -1) {
        this.$Message.error('上传文件格式不正确!')
        return false
      }
      if (!isLt5M) {
        this.$Message.error('上传文件大小不能超过 5MB!')
        return false
      }
    },
    beforeUploadPerson (file) {
      const arr = ['image/jpeg', 'image/gif', 'image/png']
      const isLt5M = file.size / 1024 / 1024 < 5

      this.uploadParam['x:type'] = 7

      console.log(file)
      if (arr.indexOf(file.type) === -1) {
        this.$Message.error('上传文件格式不正确!')
        return false
      }
      if (!isLt5M) {
        this.$Message.error('上传文件大小不能超过 5MB!')
        return false
      }
    }
  },
  computed: {
    // 法人证件类型
    documentTypeOptions () {
      var items = []
      for (var i = 0; i < typeData.DOCUMENT_TYPE.length; i++) {
        var item = {
          value: typeData.DOCUMENT_TYPE[i]['id'],
          label: typeData.DOCUMENT_TYPE[i]['name']
        }
        items.push(item)
      }
      return items
    },
    // 企业证件类型
    certificateTypeOptions () {
      var items = []
      for (var i = 0; i < typeData.COMPANY_CERTIFICATE_TYPE.length; i++) {
        var item = {
          value: typeData.COMPANY_CERTIFICATE_TYPE[i]['id'],
          label: typeData.COMPANY_CERTIFICATE_TYPE[i]['name']
        }
        items.push(item)
      }
      return items
    }
  },
  created: function () {
    const self = this
    self.$http.get(api.user, {})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        var item = response.data.data
        item.verify_status = parseInt(item.verify_status)
        item.document_type = parseInt(item.document_type) === 0 ? '' : parseInt(item.document_type)
        item.company_type = parseInt(item.company_type) === 0 ? '' : parseInt(item.company_type)
        console.log(item)
        // 法人营业执照
        if (item.license_image) {
          var files = []
          for (var i = 0; i < item.license_image.length; i++) {
            if (i > 5) {
              break
            }
            var obj = item.license_image[i]
            var img1 = {}
            img1['response'] = {}
            img1['name'] = obj['name']
            img1['url'] = obj['small']
            img1['response']['asset_id'] = obj['id']
            files.push(img1)
          }
          self.fileList = files
        }
        // 法人证件
        if (item.document_image) {
          var personFiles = []
          for (var j = 0; j < item.document_image.length; j++) {
            if (j > 5) {
              break
            }
            var pObj = item.document_image[j]
            var img2 = {}
            img2['response'] = {}
            img2['name'] = pObj['name']
            img2['url'] = pObj['small']
            img2['response']['asset_id'] = pObj['id']
            personFiles.push(img2)
          }
          self.filePersonList = personFiles
        }

        self.form = item
        console.log(response.data.data)
      } else {
        self.$Message.error(response.data.meta.message)
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
    })

    // 获取图片上传信息
    self.$http.get(api.upToken, {})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        if (response.data.data) {
          self.uploadParam.token = response.data.data.token
          self.uploadParam.url = response.data.data.url
        }
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
      return false
    })
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


</style>
