<template>
    <div class="container" style="padding-top: 20px">
      <Row>
        <Col :span="3">
          <v-menu currentName="personalcenter"></v-menu>
        </Col>
        <Col :span="21">
          <div class="personalcenter">
            <div class="userImage text-center">
              <img v-if="!uploadList.length" src="../../../assets/images/home/item_32_1.png" alt="">
              <div class="margin-b-25">
                <div class="demo-upload-list" v-for="item in uploadList">
                  <template>
                    <img style="width: 118px;height: 118px" :src="item.url">
                    <div class="demo-upload-list-cover">
                      <Icon type="ios-eye-outline" @click.native="handleView(item.name)"></Icon>
                      <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
                    </div>
                  </template>
                </div>
                <p class="margin-t-15 margin-b-15 color_666">张三</p>
                <Upload
                  ref="upload"
                  :show-upload-list="false"
                  :default-file-list="defaultuploadList"
                  :on-success="handleSuccess"
                  :format="['jpg','jpeg','png']"
                  :max-size="2048"
                  :on-format-error="handleFormatError"
                  :on-exceeded-size="handleMaxSize"
                  :before-upload="handleBeforeUpload"
                  :action="uploadParam.url"
                  :data="uploadParam"
                  style="display: inline-block;width:100px;">
                  <div style="width: 100px;height:28px;line-height: 30px;">
                    <Icon type="ios-cloud-upload-outline" size="20">123</Icon>
                    <span>选择图片</span>
                  </div>
                </Upload>
                <Modal title="查看" v-model="visible">
                  <img :src="imgName" v-if="visible" style="width: 100%">
                </Modal>
              </div>
              <p class="color_666 font-14">设置一个尺寸大于400px*400px、小于3M的JPG头像。</p>
            </div>
            <div class="personalInfo">
              <p class="color_333 font-16 margin-b-25">个人资料设置：</p>
              <Form ref="personal" :model="personalform" :rules="formValidate">
                <Row :gutter="40">
                  <Col :span="12">
                    <FormItem label="用户名:" :label-width="58">
                      <Input v-model="personalform.account" disabled/>
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
                  <!--<Col :span="12">-->
                    <!--<FormItem label="邮箱:" :label-width="58" prop="email">-->
                      <!--<Input v-model="personalform.email"/>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                  <!--<Col :span="12">-->
                    <!--<FormItem label="性别:" :label-width="50" prop="sex">-->
                      <!--<RadioGroup v-model="personalform.sex">-->
                        <!--<Radio label="1">男</Radio>-->
                        <!--<Radio label="2">女</Radio>-->
                      <!--</RadioGroup>-->
                    <!--</FormItem>-->
                  <!--</Col>-->
                </Row>
              </Form>
            </div>
            <div class="submit">
              <Button class="wid_100 margin-t-40 margin-b-40" @click="submit('personal')">确认修改</Button>
            </div>
          </div>
        </Col>
      </Row>
    </div>
</template>

<script>
  import api from '@/api/api'
  import vMenu from '@/components/page/center/Menu'
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
      // const validEmail = (rule, value, callback) => {
      //   if (value) {
      //     var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/
      //     if (!reg.test(value)) {
      //       callback(new Error('邮箱格式不正确'))
      //     } else {
      //       callback()
      //     }
      //   } else {
      //     callback(new Error('请输入邮箱'))
      //   }
      // }
      return {
        user: {},                   // 用户信息
        personalform: {
          account: 123456,   // 账号
          phone: '',                // 手机号
          userName: '',             // 姓名
          email: '',                // 邮箱
          sex: ''                   // 性别
        },
        defaultuploadList: [        // 默认上传
          {'url': require('@/assets/images/home/item_32_1.png')}
        ],
        uploadList: [],             // 上传
        visible: false,             // 显示框
        imgName: '',                // 图片
        img_id: '',             // 图片ID
        uploadParam: {              // 传值后台
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
          ]
          // ,
          // email: [
          //   { validator: validEmail, trigger: 'blur' }
          // ]
        }
      }
    },
    methods: {
      submit () {
        let self = this
        self.$refs['personal'].validate(valid => {
          if (valid) {
            let userInfo = {
              token: this.$store.state.event.token,
              id: this.user.id,
              account: this.user.account,
              phone: this.personalform.phone,
              realname: this.personalform.userName,
              cover_id: this.img_id,
              email: '',
              sex: 0
            }
            self.$http.put(api.updateUser, userInfo)
              .then(function (res) {
                console.log(res)
                self.router.push('home')
              })
          } else {
            self.$Message.error('请填写信息')
            return false
          }
        })
      },
      handleView (name) {
        this.imgName = this.uploadList[0].url
        this.visible = true
      },
      handleRemove (file) {
        const fileList = this.uploadList
        this.uploadList.splice(fileList.indexOf(file), 1)
      },
      handleSuccess (res, file, fileList) {
        this.img_id = res.asset_id
        var add = fileList[fileList.length - 1]
        var itemt = {
          name: add.response.fileName,
          url: add.response.name,
          response: {
            asset_id: add.response.asset_id
          }
        }
        this.uploadList.push(itemt)
      },
      handleBeforeUpload () {
        this.uploadParam['x:type'] = 1
        const check = this.uploadList.length < 1
        if (!check) {
          this.$Message.warning('您已上传!')
        }
        return check
      },
      handleFormatError (file) {
        this.$Message.warning('图片格式不正确')
      },
      handleMaxSize (file) {
        this.$Message.warning('图片大小最大为5M')
      }
    },
    created () {
      this.user = this.$store.state.event.user
      this.personalform.account = this.user.account
      this.personalform.phone = this.user.phone
      let self = this
      let token = this.$store.state.event.token
      // 获取图片上传信息
      self.$http.get(api.upToken, {token: token})
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
    components: {
      vMenu
    }
  }
</script>

<style scoped>
  .personalcenter {
    /*margin-top: 108px;*/
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
  .personalInfo .demo-upload-list {
    border-radius: 50%;
  }
  .demo-upload-list{
    display: inline-block;
    width: 118px;
    height: 118px;
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
    line-height: 118px;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
  }
</style>
