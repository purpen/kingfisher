<template>
  <div class="login">
    <logo></logo>
    <Form ref="formInline" :model="formInline" :rules="ruleInline">
      <FormItem prop="user" class="username">
        <i class="icon userIcon"></i>
        <Input type="text" v-model="formInline.user" placeholder="手机号">
        </Input>
      </FormItem>

      <FormItem prop="password" class="password">
        <i class="icon passwdIcon"></i>
        <Input type="password" v-model="formInline.password" placeholder="密码">
        </Input>
      </FormItem>

      <FormItem>
        <Button type="primary" @click.native="handleSubmit('formInline')" :disabled="!isclick" class="loginbtn">{{login}}</Button>
      </FormItem>
    </Form>

    <p class="exist">
      <router-link class="register" to="register">注册</router-link>
      <router-link to="retrievePassword">忘记密码</router-link>
      <!--<router-link to="msglogin">短信登录</router-link>-->
    </p>

    <section class="thirdpart">
      <p>第三方账号登录</p>
      <div class="wwq clearfix">
        <a class="wx"></a>
        <a class="wb"></a>
        <a class="qq"></a>
      </div>
    </section>
  </div>
</template>

<script>
  import logo from '@/components/page/auth/logo'
  import api from '@/api/api'
  import auth from '@/helper/auth'

  export default {
    data () {
      const validateUser = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('手机号不能为空'))
        }
        if (!/^\d+$/.test(value)) {
          callback(new Error('手机号必须为数字'))
        } else {
          callback()
        }
      }
      const validatePasswd = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('密码不能为空'))
        }
        callback()
      }
      return {
        login: '登录',
        isclick: true,
        formInline: {
          user: '',
          password: ''
        },
        ruleInline: {
          user: [
            {type: 'string', min: 11, message: '请输入正确的手机号', trigger: 'blur'},
            {validator: validateUser, trigger: 'blur'}
          ],
          password: [
            {type: 'string', min: 6, message: '密码最少为6位', trigger: 'blur'},
            {validator: validatePasswd, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleSubmit (name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.login = '登录中..'
            this.isclick = false
            const that = this
            let user = this.formInline.user
            that.$http.get(api.check_account, {params: {phone: user}})
              .then((response) => {
                if (response.data.meta.status_code === 200) {
                  that.$Message.error('该用户不存在!')
                  that.isclick = true
                  that.login = '登录'
                  return
                } else {
                  that.$http.post(api.login, {
                    account: that.formInline.user, password: that.formInline.password
                  })
                    .then((response) => {
                      if (response) {
                        if (response.data.meta.status_code === 200) {
                          let token = response.data.data.token
                          auth.write_token(token)
                          that.login = '登录'
                          that.isclick = true
                          that.$Message.success('登陆成功!')
                          that.$router.push({name: 'home'})
                          return
                        } else {
                          that.login = '登录'
                          that.isclick = true
                          that.$Message.error(response.data.meta.message)
                          return
                        }
                      } else {
                        that.login = '登录'
                        that.isclick = true
                        that.$Message.error('密码错误')
                        return
                      }
                    })
                    .catch((error) => {
                      console.error(error)
                    })
                  return
                }
              })
              .catch((error) => {
                console.error(error)
                that.isclick = true
                return
              })
          } else {
            this.$Message.error('Fail!')
          }
        })
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
        this.$Message.error('已登录!')
        this.$router.push({name: 'home'})
      }
    }
  }
</script>


<style scoped>

  .username, .password, .loginbtn {
    position: relative;
    width: 90%;
    margin: 0 0.53rem 0.64rem;
  }

  .loginbtn {
    background: #BE8914;
    border-color: #BE8914;
  }

  .icon {
    position: absolute;
    width: 0.4rem;
    height: 0.53rem;
    z-index: 1;
    top: 50%;
    left: 0.53rem;
    transform: translateY(-0.26rem);
  }

  .icon.passwdIcon {
    background: url("../../../assets/images/loginIcon/Password@2x.png") no-repeat;
    background-size: contain;
  }

  .icon.userIcon {
    background: url("../../../assets/images/loginIcon/account@2x.png") no-repeat;
    background-size: contain;
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

  .thirdpart {
    margin-top: 2.3rem;
  }

  .thirdpart p {
    color: #999;
    font-size: 14px;
    text-align: center;
    margin-bottom: 0.7rem;
  }

  .wwq {
    display: flex;
    justify-content: center;
  }

  .wwq a {
    display: block;
    width: 1.3rem;
    height: 1.3rem;
    border-radius: 50%;
    margin: 0 5%;
    background: #FF4500;
  }

  .wwq .wx {
    background: url(../../../assets/images/loginIcon/WeChat@2x.png) no-repeat;
    background-size: contain;
  }

  .wwq .wb {
    background: url(../../../assets/images/loginIcon/weibo@2x.png) no-repeat;
    background-size: contain;
  }

  .wwq .qq {
    background: url(../../../assets/images/loginIcon/QQ@2x.png) no-repeat;
    background-size: contain;
  }
</style>
