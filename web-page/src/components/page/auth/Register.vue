<template>
  <div class="container">
    <div class="register-box">
      <div class="regisiter-title">
        <h2>注册账户</h2>
      </div>

      <div class="register-content">

        <Form ref="form" :model="form" :rules="ruleForm" label-position="top">
            <Form-item label="手机号" prop="account">
                <Input type="text" v-model="form.account"></Input>
            </Form-item>
            <Form-item label="验证码" prop="smsCode">
                <Input v-model="form.smsCode" placeholder="验证码">
                  <span slot="append"><Button type="primary" class="code-btn" @click="fetchCode" :disabled="time > 0">{{ codeMsg }}</Button></span>
                </Input>
            </Form-item>
            <Form-item label="密码" prop="password">
                <Input type="password" v-model="form.password"></Input>
            </Form-item>
            <Form-item label="确认密码" prop="checkPassword">
                <Input type="password" v-model="form.checkPassword" placeholder="确认密码"></Input>
            </Form-item>

            <Form-item>
                <Button class="register-btn" :loading="isLoadingBtn" type="primary" @click="submit('form')">注册</Button>
            </Form-item>
        </Form>

        <div class="reg">
          <p>已经有账号，您可以直接登录 <router-link :to="{name: 'login'}" >立即登录</router-link></p>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import api from '@/api/api'
import auth from '@/helper/auth'

export default {
  name: 'register',
  props: {
    second: {
      type: Number,
      default: 60
    }
  },
  data () {
    // const safePassword = (rule, value, callback) => {
    //   if (value) {
    //     var reg = /^(?=.*?[0-9])(?=.*?[A-Z])(?=.*?[a-z])[0-9A-Za-z!-)]{6,16}$/
    //     if (!reg.test(value)) {
    //       callback(new Error('密码格式不正确：密码必须包含字母大小写及数字,不能含有特殊字符,且不能以数字开头!'))
    //     } else {
    //       callback()
    //     }
    //   } else {
    //     callback(new Error('请输入密码!'))
    //   }
    // }
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
      isLoadingBtn: false,
      uActive: true,
      cActive: false,
      time: 0,
      labelPosition: 'top',
      form: {
        type: 1,
        account: '',
        smsCode: '',
        password: '',
        checkPassword: ''

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
          // { validator: safePassword, trigger: 'blur' }
        ],
        checkPassword: [
          { validator: checkPassword, trigger: 'blur' }
        ]
      }

    }
  },
  methods: {
    selectUser () {
      this.form.type = 1
      this.uActive = true
      this.cActive = false
    },
    selectComputer () {
      this.form.type = 2
      this.cActive = true
      this.uActive = ''
    },
    submit (formName) {
      const that = this
      that.$refs[formName].validate((valid) => {
        if (valid) {
          var account = this.form.account
          var password = this.form.password
          var smsCode = this.form.smsCode

          that.isLoadingBtn = true
          // 验证通过，注册
          that.$http.post(api.register, {account: account, password: password, code: smsCode})
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

                  that.$router.push('/home')
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
    fetchCode () {
      var account = this.form.account
      if (account === '') {
        this.$Message.error('请输入手机号码')
        return
      }

      if (account.length !== 11 || !/^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(account)) {
        this.$Message.error('手机号格式不正确!')
        return
      }

      var url = api.check_account1
      console.log(url)
      // 检测手机号是否存在
      const that = this
      that.$http.get(url, {params: {phone: account}})
      .then(function (response) {
        if (response.data.meta.status_code === 200) {
          // 获取验证码
          that.$http.post(api.getRegisterCode, {account: account})
          .then(function (response) {
            if (response.data.meta.status_code === 200) {
              that.time = that.second
              that.timer()
              that.$emit('send')
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
  mounted: function () {
    const self = this
    window.addEventListener('keydown', function (e) {
      if (e.keyCode === 13) {
        self.submit('ruleForm')
      }
    })
  },
  created: function () {
    if (this.$store.state.event.token) {
      this.$Message.error('已经登录!')
      this.$router.replace({name: 'home'})
    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .register-box{
    border: 1px solid #aaa;
    width: 800px;
    height: 600px;
    text-align:center;
    margin: 30px auto 30px auto;
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
  .reg {
    margin-top: 40px;
  }
  .reg p {
    color: #666;
  }
  .reg p a {
    color: #FF5A5F;
  }

</style>
