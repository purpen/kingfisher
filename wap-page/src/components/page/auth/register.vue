<template>
  <div class="register">
    <logo></logo>
    <Form ref="formInline" :model="formInline" :rules="ruleInline">
      <FormItem prop="user" class="username">
        <i class="icon userIcon"></i>
        <Input type="text" v-model="formInline.user" ref="user" placeholder="手机号">
        </Input>
      </FormItem>

      <FormItem prop="code" class="securityCode">
        <Row>
          <Col span="16" class="fl">
          <Input type="text" v-model="formInline.code" placeholder="验证码">
          </Input>
          </Col>
          <Col span="6" class="fr getcode">
          <Button ref="getCode" @click.native="fetchCode" :disabled="!isclick">获取验证码</Button>
          </Col>
        </Row>
      </FormItem>

      <FormItem prop="password" class="password">
        <i class="icon passwdIcon"></i>
        <Input type="password" v-model="formInline.password" placeholder="密码">
        </Input>
      </FormItem>

      <FormItem prop="Confirm" class="password">
        <i class="icon passwdIcon"></i>
        <Input type="password" v-model="formInline.Confirm" placeholder="确认密码">
        </Input>
      </FormItem>
      <FormItem>
        <Button type="primary" @click="handleSubmit('formInline')" :disabled="!isclick1" class="regbtn">{{register}}
        </Button>
      </FormItem>
    </Form>
    <p class="exist">已有账号？
      <router-link to="login">立即登录</router-link>
    </p>
  </div>
</template>
<script>
  import logo from '@/components/page/auth/logo'
  import api from '@/api/api'
  import auth from '@/helper/auth'
  export default {
    name: '',
    data () {
      const validateUser = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('手机号不能为空'))
        }
        if (!/^\d+$/.test(value)) {
          callback(new Error('手机号必须为数字'))
        } else if (!/^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(value)) {
          callback(new Error('手机号格式不正确'))
        } else {
          callback()
        }
      }
      const validatePasswd = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('密码不能为空'))
        }
        if (!/[A-Z]+?/.test(value)) {
          callback(new Error('密码必须有一个大写字母'))
        } else if (!/\d+?/.test(value)) {
          callback(new Error('密码必须有一个数字'))
        } else if (!/[a-z]+?/.test(value)) {
          callback(new Error('密码必须有一个小写字母'))
        } else {
          callback()
        }
      }
      const validateConfirmPasswd = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('再次输入密码'))
        }
        if (value !== this.formInline.password) {
          return callback(new Error('两次密码输入不一致'))
        } else {
          callback()
        }
      }
      const validateCode = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('验证码不能为空'))
        }
        if (value !== this.code) {
          callback(new Error('验证码错误'))
        } else {
          callback()
        }
      }
      return {
        register: '注册',
        code: '',
        time: 60,
        isclick: true,
        isclick1: true,
        formInline: {
          user: '',
          password: '',
          Confirm: '',
          code: ''
        },
        ruleInline: {
          user: [
            {type: 'string', min: 11, message: '请输入正确的手机号', trigger: 'blur'},
            {validator: validateUser, trigger: 'blur'}
          ],
          password: [
            {type: 'string', min: 6, message: '密码最少为6位', trigger: 'blur'},
            {validator: validatePasswd, trigger: 'blur'}
          ],
          Confirm: [
            {validator: validateConfirmPasswd, trigger: 'blur'}
          ],
          code: [
            {validator: validateCode, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleSubmit (name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.register = '注册中...'
            this.isclick1 = false
            let register = api.register
            const that = this
            that.$http.post(register, {
              account: that.formInline.user, password: that.formInline.password, code: that.formInline.code
            })
              .then(function (response) {
                if (response.data.meta.status_code === 200) {
                  let token = response.data.data.token
                  auth.write_token(token)
                  that.$Message.success('注册成功')
                  that.$router.push({name: 'home'})
                  that.register = '注册'
                  that.isclick1 = true
                } else {
                  that.register = '注册'
                  that.isclick1 = true
                  that.$Message.error(response.data.meta.message)
                }
                return true
              })
              .catch(function (error) {
                that.register = '注册'
                that.isclick1 = true
                that.$message(error)
                console.log(error)
                return false
              })
            return false
          } else {
            this.$Message.error('Fail!')
            return false
          }
        })
      },
      fetchCode (e) {
        let user = this.formInline.user
        if (user === '') {
          this.$Message.error('请输入手机号码！')
          return
        }
        if (user.length !== 11) {
          return
        }
        const that = this
        that.isclick = false
        that.$http.get(api.check_account, {params: {phone: user}})
          .then(function (response) {
            if (response.data.meta.status_code === 200) {
              that.$http.post(api.fetch_msm_code, {account: user})
                .then(function (response) {
                  that.timer(e)
                  console.log(response.data.data.code) // 验证码
                  that.code = response.data.data.code
                })
                .catch(function (error) {
                  console.log(error)
                  that.$Message.error(error)
                  if (error.status_code === 422) {
                    that.$Message.error('此手机号尚未激活')
                  }
                })
            } else {
              that.$Message.error(response.data.meta.message)
            }
          })
          .catch(function (error) {
            that.$Message.error(error)
          })
      },
      timer (e) {
        const that = this
        let ti = setInterval(() => {
          that.time--
          that.fetchCode = null
          if (that.time < 0) {
            that.isclick = true
            e.target.innerText = '获取验证码'
            that.time = 60
            clearInterval(ti)
            return
          }
          e.target.innerText = that.time + 's'
        }, 1000)
      }
    },
    components: {
      logo
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    created () {
      if (this.isLogin) {
        this.$Message.error('Fail:已登录!')
        this.$router.push({name: 'home'})
      }
    }
  }
</script>
<style scoped>
  .username, .password, .regbtn, .securityCode {
    position: relative;
    width: 90%;
    margin: 0 0.53rem 0.64rem;
  }

  .regbtn {
    background: #BE8914;
    border-color: #BE8914;
  }

  .icon {
    position: absolute;
    width: 0.4rem;
    height: 0.53rem;
    z-index: 1;
    top: 0.3rem;
    left: 0.53rem;
  }

  .icon.passwdIcon {
    background: url("../../../assets/images/loginIcon/Password@2x.png") no-repeat;
    background-size: contain;
  }

  .icon.userIcon {
    background: url("../../../assets/images/loginIcon/account@2x.png") no-repeat;
    background-size: contain;
  }

  .getcode {
    width: auto;
  }

  .exist {
    text-align: center;
    font-size: 14px;
    color: #999;
  }

  .exist a {
    color: #BE8914;
  }

  @media screen and (min-width: 500px) {
    .getcode {
      width: 25%;
    }
  }

</style>
