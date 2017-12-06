<template>
  <div class="addaddr">
    <h2>{{title}}</h2>
    <div class="address_new">
      <Form class="addrfrom" ref="formInline" label-position="left" :label-width="70" :model="formInline"
            :rules="ruleInline">
        <FormItem label="收货人" prop="name">
          <Input v-model="formInline.name" ref="name" placeholder="请填写姓名"></Input>
        </FormItem>
        <FormItem label="联系电话" prop="phone">
          <Input v-model="formInline.phone" ref="phone" placeholder="请填写电话号码"></Input>
        </FormItem>
        <FormItem label="邮箱" prop="mail">
          <Input v-model="formInline.mail" ref="mail" placeholder="请填写邮箱"></Input>
        </FormItem>
        <FormItem label="邮编" prop="zipCode">
          <Input v-model="formInline.zipCode" ref="zipCode" placeholder="请填写邮编"></Input>
        </FormItem>
      </Form>
      <div class="addr clearfix">
        <p class="clearfix">
          <span class="fl">地址</span>
          <i class="fr">
            {{formInline.province.name}}
            {{formInline.city.name}}
            {{formInline.county.name}}
            {{formInline.town.name}}
          </i>
        </p>
        <select v-if="province.length" v-model="formInline.province" ref="province"
                @change="getCity(formInline.province.oid)">
          <option v-for="(ele, index) in province" :key="index" :value="ele">{{ele.name}}
          </option>
        </select>
        <select v-if="city.length" v-model="formInline.city" ref="city"
                @change="getCounty(formInline.city.oid)">
          <option v-for="(ele, index) in city" :key="index" :value="ele">
            {{ele.name}}
          </option>
        </select>
        <select v-if="county.length" v-model="formInline.county" ref="county"
                @change="getTown(formInline.county.oid)">
          <option v-for="(ele, index) in county" :key="index" :value="ele">{{ele.name}}</option>
        </select>
        <select v-if="town.length" v-model="formInline.town" ref="town">
          <option v-for="(ele, index) in town" :key="index" :value="ele">{{ele.name}}</option>
        </select>
        <Input class="comAddress" v-model="formInline.comAddress" type="textarea"
               placeholder="请填写详细地址，不得少于5个字"></Input>
      </div>
      <p class="default clearfix">
        <span class="fl">设为默认地址</span>
        <i-switch class="fr switch" v-model="default1" @on-change="change"></i-switch>
      </p>
      <!--<p>-->
      <!--<span>{{reverseMsg}}</span>-->
      <!--<input type="text" v-model="msg">-->
      <!--</p>-->
      <button class="btn" @click="handleSubmit('formInline')">保存</button>
    </div>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'addAddress',
    data () {
      const validatePhone = (rule, value, callback) => {
        if (!/^\d+$/.test(value)) {
          callback(new Error('手机号必须为数字'))
        } else if (!/^((13|14|15|17|18)[0-9]{1}\d{8})$/.test(value)) {
          callback(new Error('手机号格式不正确'))
        }
        callback()
      }
      const validateZip = (rule, value, callback) => {
        if (value) {
          if (!/^\d+$/.test(value)) {
            callback(new Error('邮编必须为数字'))
          } else if (!/^\d{6}$/.test(value)) {
            callback(new Error('邮编必须为6位'))
          }
        }
        callback()
      }
      const validatemail = (rule, value, callback) => {
        if (value) {
          if (!/^([\w-_]+(?:\.[\w-_]+)*)@((?:[a-z0-9]+(?:-[a-zA-Z0-9]+)*)+\.[a-z]{2,6})$/.test(value)) {
            callback(new Error('邮箱格式不正确'))
          }
        }
        callback()
      }
      return {
        msg: '',
        addrid: '',
        province: [],
        city: [],
        county: [],
        town: [],
        default1: false,
        switch1: 0,
        formInline: {
          title: '添加地址',
          name: '',
          phone: '',
          mail: '',
          zipCode: '',
          province: {},
          city: {},
          county: {},
          town: {},
          province_id: '',
          city_id: '',
          county_id: '',
          town_id: '',
          comAddress: ''
        },
        ruleInline: {
          name: [
            {required: true, message: '请输入收货人姓名', trigger: 'blur'}
          ],
          phone: [
            {required: true, message: '手机号不能为空', trigger: 'blur'},
            {validator: validatePhone, trigger: 'blur'}
          ],
          mail: [
            {validator: validatemail, trigger: 'blur'}
          ],
          zipCode: [
            {validator: validateZip, trigger: 'blur'}
          ]
        },
        i: {}
      }
    },
    created () {
      this.title = this.$route.meta.title
      this.addrid = this.$route.params.addrid
      this.getProvince()
      const that = this
      if (that.addrid) {
        that.$http.get(api.addr_details, {params: {id: that.addrid, token: that.isLogin}})
          .then((res) => {
            that.i = res.data.data
            that.formInline.name = that.i.name
            that.formInline.phone = that.i.phone
            that.formInline.mail = that.i.email
            that.formInline.province.name = that.i.province
            that.formInline.city.name = that.i.city
            that.formInline.county.name = that.i.county
            that.formInline.town.name = that.i.town
            that.switch1 = that.i.is_default
            that.formInline.zipCode = that.i.zip
            that.formInline.comAddress = that.i.address
          })
          .catch((err) => {
            console.error(err)
          })
      }
    },
    methods: {
      handleSubmit (name) {
        this.$refs[name].validate((valid) => {
          if (valid) {
            if (!this.formInline.comAddress) {
              this.$Message.error('地址不能为空')
            } else if (!this.formInline.province) {
              this.$Message.error('请选择省份')
            } else if (!this.formInline.city) {
              this.$Message.error('请选择城市')
            } else {
              const that = this
//              console.log(that.formInline.name,
//                that.formInline.phone,
//                that.formInline.mail,
//                that.formInline.province.oid,
//                that.formInline.city.oid,
//                that.formInline.county.oid,
//                that.formInline.town.oid,
//                that.switch1,
//                that.formInline.zipCode,
//                that.formInline.comAddress,
//                that.isLogin)
              that.$http.post(api.add_address, {
                id: that.addrid,
                name: that.formInline.name,
                phone: that.formInline.phone,
                email: that.formInline.mail,
                province_id: that.formInline.province.oid,
                city_id: that.formInline.city.oid,
                county_id: that.formInline.county.oid,
                town_id: that.formInline.town.oid,
                is_default: that.switch1,
                zip: that.formInline.zipCode,
                address: that.formInline.comAddress,
                token: that.isLogin
              })
                .then((ref) => {
                  console.log(ref)
                  if (ref.data.meta.status_code === 200) {
                    if (that.addrid) {
                      that.$Message.success('修改成功')
                    } else {
                      that.$Message.success('添加成功')
                    }
                    history.go(-1)
                  } else {
                    that.$Message.error(ref.data.meta.message)
                  }
                })
                .catch((err) => {
                  console.log(err)
                })
            }
          } else {
            this.$Message.error('Fail!')
          }
        })
      },
      getProvince () {
        const that = this
        that.$http.get(api.city, {params: {token: that.isLogin}})
          .then((res) => {
//            console.log(res.data.data)
            that.province = res.data.data
          })
          .catch((err) => {
            console.log(err)
          })
      },
      getCity (e) {
        this.clearArr()
        const that = this
        that.$http.get(api.fetchCity, {params: {oid: e, layer: 2, token: that.isLogin}})
          .then((res) => {
            that.city = res.data.data
          })
          .catch((err) => {
            console.log(err)
          })
      },
      getCounty (e) {
        this.county.length = 0
        this.town.length = 0
        this.formInline.county = ''
        this.formInline.town = ''
        const that = this
        that.$http.get(api.fetchCity, {params: {oid: e, layer: 3, token: that.isLogin}})
          .then((res) => {
//            console.log(res.data.data)
            that.county = res.data.data
          })
          .catch((err) => {
            console.log(err)
          })
      },
      getTown (e) {
        const that = this
        that.$http.get(api.fetchCity, {params: {oid: e, layer: 4, token: that.isLogin}})
          .then((res) => {
//            console.log(res.data.data)
            that.town = res.data.data
          })
          .catch((err) => {
            console.log(err)
          })
      },
      clearArr () {
        this.city.length = 0
        this.county.length = 0
        this.town.length = 0
        this.formInline.city = ''
        this.formInline.county = ''
        this.formInline.town = ''
      },
      change (status) {
        if (status) {
          this.switch1 = 1
        } else {
          this.switch1 = 0
        }
        console.log(status, this.switch1)
      }
    },
    watch: {
      switch1 () {
        if (Number(this.switch1)) {
          this.default1 = true
        } else {
          this.default1 = false
        }
      }
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    }
  }
</script>
<style scoped>
  .addaddr h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
  }

  .address_new {
    border-top: 0.5px solid rgba(204, 204, 204, 0.49);
  }

  .addrfrom {
    padding: 0 15px;
  }

  .default {
    height: 44px;
    line-height: 44px;
    border-top: 0.5px solid rgba(204, 204, 204, 0.49);
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
    padding: 0 15px;
  }

  .default .switch {
    margin: 10px 0;
  }

  .addr {
    font-size: 12px;
    color: #495060;
    padding: 0 15px;
    overflow: hidden;
  }

  .addr p {
    padding-bottom: 10px;
  }

  .addr span:before {
    content: '*';
    display: inline-block;
    margin-right: 4px;
    line-height: 1;
    font-family: SimSun;
    font-size: 12px;
    color: #ed3f14;
  }

  .addr select {
    width: 49%;
    margin: 5px 0;
  }

  .btn {
    position: fixed;
    width: 100%;
    height: 44px;
    left: 0;
    bottom: 0;
  }
</style>
