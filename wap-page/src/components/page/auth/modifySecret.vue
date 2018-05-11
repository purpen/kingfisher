<template>
  <div class="login">
    <h2>
      <router-link :to="{name:'systemSetting'}" class="backIcon">
      </router-link>{{title}}</h2>
    <Form ref="formInline" :model="formInline" :rules="ruleInline">
      <FormItem prop="password" class="password">
        <i class="icon passwdIcon"></i>
        <Input type="password" v-model="formInline.password" placeholder="原密码">
        </Input>
      </FormItem>

      <FormItem prop="newPassword" class="password">
        <i class="icon passwdIcon"></i>
        <i :class="['icon', 'eyeIcon', {'show': isShow}]" @click="isShow = !isShow"></i>
        <Input :type="isShow ? 'text' : 'password'" v-model="formInline.newPassword" placeholder="新密码">
        </Input>
      </FormItem>

      <FormItem>
        <Button type="primary" @click.native="handleSubmit('formInline')" :disabled="disable" class="loginbtn" :loading="disable">{{login}}</Button>
      </FormItem>
    </Form>
  </div>
</template>

<script>
  import api from '@/api/api'
  import auth from '@/helper/auth'

  export default {
    data () {
      const validatePasswd = (rule, value, callback) => {
        if (!value) {
          return callback(new Error('密码不能为空'))
        }
        callback()
      }

      const validateNewPasswd = (rule, value, callback) => {
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
      return {
        title: '',
        login: '提交',
        isShow: false, // 显示/隐藏密码
        disable: false,
        formInline: {
          password: '',
          newPassword: ''
        },
        ruleInline: {
          password: [
            {type: 'string', min: 6, message: '密码最少为6位', trigger: 'blur'},
            {validator: validatePasswd, trigger: 'blur'}
          ],
          newPassword: [
            {type: 'string', min: 6, message: '密码最少为6位', trigger: 'blur'},
            {validator: validateNewPasswd, trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleSubmit (name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            this.disable = true
            this.$http.post(api.changePassword, {
              old_password: this.formInline.password,
              password: this.formInline.newPassword,
              token: this.isLogin
            })
            .then((res) => {
              if (res.data.meta.status_code === 200) {
                let token = res.data.data.token
                auth.write_token(token)
                this.disable = false
                this.$Message.success('密码修改成功!')
                this.$router.push({name: 'home'})
              } else {
                this.$Message.error(res.data.meta.message)
              }
            })
            .catch((err) => {
              console.error(err)
            })
          } else {
            this.$Message.error('Fail!')
          }
        })
      }
    },
    components: {
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
      this.title = this.$route.meta.title
    }
  }
</script>


<style scoped>
 h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
    margin-bottom: 10px;
  }

  .username, .password, .loginbtn {
    position: relative;
    width: 90%;
    margin: 0 0.53rem 0.64rem;
  }

  .loginbtn {
    background: #BE8914;
    border-color: #BE8914;
  }

  .loginbtn[disabled] {
    background-color: #f7f7f7;
    border-color: #dddee1;
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
    background: url("../../../assets/images/loginIcon/Password@2x.png") no-repeat left;
    background-size: contain;
  }

  .icon.eyeIcon {
    position: absolute;
    width: 0.6rem;
    height: 0.6rem;
    z-index: 1;
    top: 50%;
    left: auto;
    right: 0.2rem;
    transform: translateY(-0.26rem);
    background: url("../../../assets/images/loginIcon/noeye@2x.png") no-repeat left;
    background-size: contain;
  }
  .icon.show {
    background: url("../../../assets/images/loginIcon/eye@2x.png") no-repeat left;
    background-size: contain;
  }
</style>
