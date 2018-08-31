<template>
    <div class="container">
      <div class="personalcenter">
        <div class="userImage text-center">
          <img src="../../../assets/images/home/item_32_1.png" alt="">
          <p class="margin-t-15 margin-b-15 color_666">张三</p>
          <div class="margin-b-25">
            <div class="demo-upload-list" v-for="item in uploadList">
              <template v-if="item.status === 'finished'">
                <img :src="item.url">
                <div class="demo-upload-list-cover">
                  <Icon type="ios-eye-outline" @click.native="handleView(item.name)"></Icon>
                  <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                </div>
              </template>
              <template v-else>
                <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
              </template>
            </div>
            <Upload
              ref="upload"
              :show-upload-list="false"
              :on-success="handleSuccess"
              :format="['jpg','jpeg','png']"
              :max-size="2048"
              :on-format-error="handleFormatError"
              :on-exceeded-size="handleMaxSize"
              :before-upload="handleBeforeUpload"
              :action="uploadParam.url"
              style="display: inline-block;width:100px;">
              <div style="width: 100px;height:28px;line-height: 30px;">
                <Icon type="ios-cloud-upload-outline" size="20">123</Icon>
                <span>选择图片</span>
              </div>
            </Upload>
            <Modal title="View Image" v-model="visible">
              <img :src="'https://o5wwk8baw.qnssl.com/' + imgName + '/large'" v-if="visible" style="width: 100%">
            </Modal>
          </div>
          <p class="color_666 font-14">设置一个尺寸大于400px*400px、小于3M的JPG头像。</p>
        </div>
        <div class="personalInfo">
          <p class="color_333 font-16 margin-b-25">个人资料设置：</p>
          <Form ref="personal" :model="personalform" :rules="formValidate">
            <Row :gutter="40">
              <Col :span="12">
                <FormItem label="账号:" :label-width="50">
                  <Input v-model="personalform.defaultaccount" disabled/>
                </FormItem>
              </Col>
              <Col :span="12">
                <FormItem label="手机号:" :label-width="58" prop="phone">
                  <Input v-model="personalform.phone"/>
                </FormItem>
              </Col>
              <Col :span="12">
                <FormItem label="姓名:" :label-width="50" prop="userName">
                  <Input v-model="personalform.userName"/>
                </FormItem>
              </Col>
              <Col :span="12">
                <FormItem label="邮箱:" :label-width="58" prop="email">
                  <Input v-model="personalform.email"/>
                </FormItem>
              </Col>
              <Col :span="12">
                <FormItem label="性别:" :label-width="50" prop="sex">
                  <RadioGroup v-model="personalform.sex">
                    <Radio label="1">男</Radio>
                    <Radio label="2">女</Radio>
                  </RadioGroup>
                </FormItem>
              </Col>
            </Row>
          </Form>
        </div>
        <div class="submit">
          <Button class="wid_100 margin-t-40 margin-b-40" @click="submit('personal')">确认修改</Button>
        </div>
      </div>
    </div>
</template>

<script>
  import api from '@/api/api'
  // import auth from '@/helper/auth'
  export default {
    name: 'personalcenter',
    data () {
      const validPhone = (rule, value, callback) => {
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
      const validName = (rule, value, callback) => {
        if (value) {
          if (value.length > 5) {
            callback(new Error('长度最大为5'))
          } else {
            callback()
          }
        } else {
          callback(new Error('请输入姓名'))
        }
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
      return {
        personalform: {
          defaultaccount: 123456, // 账号
          phone: '',   // 手机号
          userName: '',   // 姓名
          email: '',      // 邮箱
          sex: ''         // 性别
        },
        uploadList: [],   // 上传
        visible: false,       // 显示框
        imgName: '',
        uploadParam: {   // 传值后台
          'url': '',
          'token': '',
          'x:random': '',
          'x:user_id': this.$store.state.event.user.id,
          'x:target_id': this.$route.query.id,
          'x:type': 0
        },
        formValidate: {
          phone: [
            {validator: validPhone, trigger: 'blur'}
          ],
          userName: [
            { validator: validName, trigger: 'blur' }
          ],
          email: [
            { validator: validEmail, trigger: 'blur' }
          ]
        }
      }
    },
    methods: {
      submit () {
        if (!this.personalform.sex) {
          this.$Message.error('请填写信息')
          return false
        }
        this.$refs['personal'].validate(valid => {
          if (valid) {
            this.router.push('home')
          } else {
            this.$Message.error('请填写信息')
            return false
          }
        })
      },
      handleView (name) {
        this.imgName = name
        this.visible = true
      },
      handleSuccess (res, file, f) {
        console.log(res)
        console.log(file.url)
        console.log(f)
      },
      handleBeforeUpload () {
      },
      handleFormatError (file) {
        this.$Message.warning('图片格式不正确')
      },
      handleMaxSize (file) {
        this.$Message.warning('图片大小最大为5M')
      }
    },
    created () {
      let self = this
      let token = this.$store.state.event.token
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
    },
    mounted () {
      // this.uploadList = this.$refs.upload.fileList
    },
    components: {}
  }
</script>

<style scoped>
  .personalcenter {
    margin-top: 108px;
  }

  .userImage img {
    width: 118px;
  }

  .personalInfo {
    margin-top: 80px;
    padding: 0 230px;
  }

  .submit {
    width: 150px;
    margin: 0 auto;
    padding-bottom: 90px;
  }
</style>
