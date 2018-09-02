<template>
  <div class="container">
    <div class="register-box">
      <div class="regisiter-title">
        <h2>找回密码</h2>
      </div>
      <div class="register-content forgetPass">
        <Form :model="form" :rules="ruleForm" ref="ruleForm">
          <FormItem prop="account">
            <Input v-model="form.account" name="username" ref="account" placeholder="手机号"></Input>
          </FormItem>
          <FormItem>
            <Input v-model="form.captcha" :label-width="100" placeholder="图形验证码">
              <div style="height: 34px" slot="append" @click="fetchImgCaptcha()"><img style="height: 34px" :src="imgCaptchaUrl"></div>
            </Input>
          </FormItem>
          <FormItem label="" prop="smsCode">
            <Input v-model="form.smsCode" auto-complete="off" name="smsCode" ref="smsCode" placeholder="验证码">
              <span slot="append"><Button class="code-btn" @click="fetchCode" :disabled="time > 0">{{ codeMsg }}</Button></span>
            </Input>
          </FormItem>
          <FormItem label="" prop="password">
            <Input v-model="form.password" type="password" name="password" ref="password" auto-complete="off" placeholder="重置密码"></Input>
          </FormItem>
          <FormItem label="" prop="checkPassword">
            <Input v-model="form.checkPassword" type="password" name="checkPassword" ref="checkPassword" auto-complete="off" placeholder="确认密码"></Input>
          </FormItem>
          <Button :loading="isLoadingBtn" @click="submit('ruleForm')" class="register-btn is-custom background-ed3a">重置</Button>
        </Form>

      </div>
    </div>

  </div>
</template>

<script>
import api from '@/api/api'

export default {
  name: 'forget',
  props: {
    second: {
      type: Number,
      default: 60
    }
  },
  data () {
    var checkPassword = (rule, value, callback) => {
      if (value === '') {
        callback(new Error('请再次输入密码'))
      } else if (value !== this.form.password) {
        callback(new Error('两次输入密码不一致!'))
      } else {
        callback()
      }
    }
    return {
      isLoadingBtn: false,
      time: 0,
      imgCaptchaUrl: '',    // 图形验证码url
      imgCaptchaStr: '',    // 图形验证码字符串
      form: {
        account: '',        // 手机号
        captcha: '',       // 图形验证码
        smsCode: '',        // 短信验证码
        password: '',       // 密码
        checkPassword: ''   // 重复密码
      },
      ruleForm: {
        account: [
          { required: true, message: '请输入手机号码', trigger: 'blur' },
          { min: 11, max: 11, message: '手机号码位数不正确！', trigger: 'blur' }
        ],
        smsCode: [
          { required: true, message: '请输入验证码', trigger: 'blur' },
          { min: 6, max: 6, message: '验证码格式不正确！', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '请输入密码', trigger: 'change' },
          { min: 6, max: 18, message: '密码长度在6-18字符之间！', trigger: 'blur' }
        ],
        checkPassword: [
          { validator: checkPassword, trigger: 'blur' }
        ]
      }

    }
  },
  methods: {
    submit (formName) {
      console.log(2)
      const that = this
      that.$refs[formName].validate((valid) => {
        if (valid) {
          console.log(1)
          that.isLoadingBtn = true
          console.log(3)
          // 验证通过，重置
          that.$http.post(api.retrievePassword, {phone: that.form.account, password: that.form.password, code: that.form.smsCode, captcha: that.form.captcha, str: that.form.imgCaptchaStr})
            .then(function (response) {
              if (response.data.meta.status_code === 200) {
                that.$Message.success('重置密码成功!')
                that.$router.replace('/auth/login')
                return
              } else {
                that.$Message.error(response.data.meta.message)
                that.isLoadingBtn = false
              }
            })
            .catch(function (error) {
              that.$Message.error(error.message)
              that.isLoadingBtn = false
              return false
            })
          return false
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    fetchCode () {
      var account = this.$refs.account.value
      if (account === '') {
        this.$Message.error('请输入手机号')
        return
      }

      if (account.length !== 11 || !/^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(account)) {
        this.$Message.error('手机号格式不正确')
        return
      }
      var url = api.check_account1.format(account)
      console.log(url)
      // 检测手机号是否存在
      const that = this
      // that.$http.get(url, {})
      // .then(function (response) {
      //   if (response.data.meta.status_code === 200) {
          // 获取验证码
      that.$http.post(api.getRetrieveCode, {phone: account})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          that.time = that.second
          that.timer()
          that.$emit('send')
        } else {
          that.$Message.error('该手机号尚未注册')
        }
      })
      .catch(function (error) {
        that.$Message.error(error.message)
      })
      //   } else {
      //     that.$Message.error('该手机号尚未注册')
      //   }
      // })
      // .catch(function (error) {
      //   that.$Message.error(error.message)
      // })
    },
    fetchImgCaptcha () {
      this.$http.get(api.captchaUrl)
        .then((res) => {
          if (res.data.meta.status_code === 200) {
            this.imgCaptchaUrl = res.data.data.url
            this.imgCaptchaStr = res.data.data.str
            console.log(res.data.data.url)
          } else {
            console.log(res.data.meta.message)
          }
        })
    },
    timer () {
      if (this.time > 0) {
        this.time = this.time - 1
        setTimeout(this.timer, 1000)
      }
    }
  },
  computed: {
    codeMsg () {
      return this.time > 0 ? '重新发送' + this.time + 's' : '获取验证码'
    }
  },
  mounted () {
    const self = this
    window.addEventListener('keydown', function (e) {
      if (e.keyCode === 13) {
        self.submit('ruleForm')
      }
    })
  },
  created () {
    if (this.$store.state.event.token) {
      this.$Message.error('已经登录!')
      this.$router.replace({name: 'home'})
    }
    this.fetchImgCaptcha()
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .register-box{
    border: 1px solid #aaa;
    width: 800px;
    height: 450px;
    text-align:center;
    margin: 30px auto 80px auto;
  }

  .regisiter-title{
    width: 800px;
    height: 60px;
    font-size: 1.8rem;
    display: table-cell;
    vertical-align: middle;
    text-align: center;
    border-bottom: 1px solid #aaa;
  }

  .regisiter-title h2{
  }

  p.des{
    font-size: 0.7em;
  }

  form{
    width: 50%;
    text-align:left;
    margin: 0 auto;
    margin-top: 30px;
  }

  .register-btn {
    width: 100%;
  }
  .code-btn {
    cursor: pointer;
  }


</style>
