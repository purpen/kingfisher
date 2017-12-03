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
      <FormItem>
        <Button type="primary" @click="handleSubmit('formInline')" class="regbtn">{{register}}
        </Button>
      </FormItem>
    </Form>
    <p class="exist">
      <router-link class="register" to="register">注册</router-link>
      <router-link to="login">普通登录</router-link>
    </p>
  </div>
</template>
<script>
  import logo from '@/components/page/auth/logo'
  import api from '@/api/api'
  //  import auth from '@/helper/auth'
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
        register: '短信登录',
        code: '',
        time: 60,
        isclick: true,
        formInline: {
          user: '',
          code: ''
        },
        ruleInline: {
          user: [
            {type: 'string', min: 11, message: '请输入正确的手机号', trigger: 'blur'},
            {validator: validateUser, trigger: 'blur'}
          ],
          code: [
            {validator: validateCode, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
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
    margin-right: 6px;
    padding-right: 10px;
    border-right: 1px solid #999;
  }

  .exist a:last-child {
    border-right: none;
    margin: 0;
    padding: 0;
  }

  .exist .register {
    color: #BE8914;
  }

  @media screen and (min-width: 500px) {
    .getcode {
      width: 25%;
    }
  }

</style>
