<template>
  <div class="container">
    <div class="login-box">
      <div class="login-title">
        <h2>登录</h2>
      </div>

      <div class="login-content">

        <Form ref="form" :model="form" :rules="ruleForm" label-position="top">
            <Form-item label="手机号" prop="account">
                <Input type="text" v-model="form.account"></Input>
            </Form-item>
            <Form-item label="密码" prop="password">
                <Input type="password" v-model="form.password"></Input>
            </Form-item>
            <div class="opt">
              <p class="rember"><label><input type="checkbox" /> 记住密码</label></p>
              <p class="forget"><router-link :to="{name: 'home'}">忘记密码?</router-link></p>
            </div>
            <Form-item>
                <Button class="login-btn" :loading="isLoadingBtn" type="primary" @click="submit('form')">提交</Button>
            </Form-item>
        </Form>

        <div class="reg">
          <p>还没有账户？<router-link :to="{name: 'register'}" >立即注册</router-link></p>
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
    submit (formName) {
      const that = this
      that.$refs[formName].validate((valid) => {
        if (valid) {
          that.isLoadingBtn = true
          // 验证通过，登录
          that.$http.post(api.login, {account: that.form.account, password: that.form.password})
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
        self.submit('ruleForm')
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
  .login-box{
    border: 1px solid #aaa;
    width: 800px;
    height: 400px;
    text-align:center;
    margin: 30px auto 30px auto;
  }

  .login-title{
    width: 800px;
    height: 60px;
    font-size: 1.8rem;
    display: table-cell;
    vertical-align: middle;
    text-align: center;
    border-bottom: 1px solid #aaa;
  }

  p.des{
    font-size: 0.8em;
  }

  form{
    width: 50%;
    text-align:left;
    margin: 0 auto;
    margin-top: 30px;
  }

  .login-btn {
    width: 100%;
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
  .opt {
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
    font-size: 1.3rem;
    color: #666;
  }

</style>

