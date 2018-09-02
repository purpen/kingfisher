<template>
  <div class="login">
    <p class="font-24 text-center login-center color_333">账户登录中心</p>
    <div class="container">
      <div class="login-box">
        <Form ref="ruleForm" :model="form" :rules="ruleForm">
          <FormItem prop="account">
            <Input type="text" name="username" v-model="form.account">
              <img src="../../../assets/images/icon/icon-user.png" class="wid-20" alt="" slot="prepend">
            </Input>
          </FormItem>
          <FormItem prop="password">
            <Input type="password" name="password" v-model="form.password">
              <img src="../../../assets/images/icon/icon-lock.png" class="wid-20" alt="" slot="prepend">
            </Input>
          </FormItem>
          <div class="opt">
            <p class="rember"><Checkbox>记住密码</Checkbox></p>
            <p class="forget">忘记密码?<router-link :to="{name: 'forget'}" class="margin-l-10">找回我的密码</router-link></p>
          </div>
          <FormItem>
            <Button class="login-btn background-ed3a margin-t-20" :loading="isLoadingBtn" @click="loginSubmit('ruleForm')">立即登录</Button>
          </FormItem>
        </Form>

        <div class="margin-t-15 text-center">
          <p>还没有账号？<router-link :to="{name: 'newregister'}" >立即注册领取新人大礼包</router-link></p>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import api from '@/api/api'
  import auth from '@/helper/auth'

  export default {
    name: 'login',

    data () {
      return {
        isLoadingBtn: false,
        form: {
          account: '',
          password: ''
        },
        ruleForm: {
          account: [
            { required: true, message: '请输入手机号码', trigger: 'blur' },
            { min: 11, max: 11, message: '手机号码位数不正确！', trigger: 'blur' }
          ],
          password: [
            { required: true, message: '请输入密码', trigger: 'change' },
            { min: 6, max: 18, message: '密码长度在6-18字符之间！', trigger: 'blur' }
          ]
        }

      }
    },
    methods: {
      loginSubmit (formName) {
        const that = this
        that.$refs[formName].validate((valid) => {
          if (valid) {
            that.isLoadingBtn = true
            // 验证通过，登录
            that.$http.post(api.login, {account: that.form.account, password: that.form.password})
              .then(function (response) {
                if (response.data.meta.status_code === 200) {
                  var token = response.data.data.token
                  // 写入localStorage
                  auth.write_token(token)
                  // 拉取用户信息
                  that.$http.get(api.user, {params: {token: token}})
                    .then(function (response) {
                      if (response.data.meta.status_code === 200) {
                        that.$Message.success('登录成功')
                        auth.write_user(response.data.data)
                        var prevUrlName = that.$store.state.event.prevUrlName
                        if (prevUrlName) {
                          // 清空上一url
                          auth.clear_prev_url_name()
                          that.$router.replace({name: prevUrlName})
                        } else {
                          that.$router.replace({name: 'home'})
                        }
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
                  that.isLoadingBtn = false
                }
              })
              .catch(function (error) {
                that.isLoadingBtn = false
                that.$Message.error(error.message)
                return false
              })
          } else {
            console.log('表单验证失败!')
          }
        })
      }
    },
    computed: {
    },
    mounted: function () {
      const self = this
      window.addEventListener('keydown', function (e) {
        if (e.keyCode === 13) {
          e.preventDefault()
          self.loginSubmit('ruleForm')
        }
      })
    },
    created: function () {
      var prevUrlName = this.$store.state.event.prevUrlName
      if (prevUrlName) {
        this.$Message.error('请先登录！')
      }

      if (this.$store.state.event.token) {
        this.$Message.error('已经登录!')
        this.$router.replace({name: 'home'})
      }
    }

  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .login {
    margin-top: 80px;
    margin-bottom: 80px;
  }

  .line-hei span{
    line-height: 47px;
  }

  .wid-72 img {
    width: 100%;
    height: 100%;
  }

  .login-box{
    width: 400px;
    margin: 0 auto;
  }

  .wid-20 {
    width: 20px;
    height: 20px;
  }

  .login-btn {
    width: 100%;
  }
  .margin-t-15 p {
    color: #333333;
  }
  .margin-t-15 p a {
    color: #FF5A5F;
  }
  .opt {
    height: 40px;
    margin-top: -15px;
    line-height: 45px;
  }
  .forget {
    float: right;
  }
  .rember {
    float: left;
    font-size: 1.3rem;
  }

  .forget a{
    color: #ED3A4A;
  }

  .login-center {
    margin-bottom: 60px;
  }
</style>

