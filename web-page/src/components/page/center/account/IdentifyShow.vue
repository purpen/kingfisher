<template>
  <div class="container min-height350">
    <div class="blank20"></div>

    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="identify_show"></v-menu>
      </Col>
      <Col :span="21">
        <div class="right-content margin-b-55">
          <div class="content-box">
            <div class="form-title">
              <span>企业信息</span>
            </div>

            <div class="company-show">
              <div class="item">
                <p class="p-key">企业全称:</p>
                <p class="p-val">{{ item.full_name }}</p>
              </div>
              <div class="item">
                <p class="p-key">企业地址:</p>
                <p class="p-val">{{ enterpriseCity }}</p>
              </div>
              <div class="item">
                <p class="p-key">企业电话:</p>
                <p class="p-val">{{ item.enter_phone }}</p>
              </div>

              <div class="item">
                <p class="p-key">营业执照号:</p>
                <p class="p-val">{{ item.business_license_number }}</p>
              </div>

              <div class="item">
                <p class="p-key">税号:</p>
                <p class="p-val">{{ item.ein }}</p>
              </div>

              <div class="item">
                <p class="p-key">纳税类型:</p>
                <p class="p-val">{{ item.taxpayer }}</p>
              </div>

              <div class="item">
                <p class="p-key">开户行:</p>
                <p class="p-val">{{ item.bank_name }}</p>
              </div>

              <div class="item">
                <p class="p-key">银行卡账号:</p>
                <p class="p-val">{{ item.bank_number }}</p>
              </div>

              <!--legal_person: self.form.enterpriseContact,  // 法人姓名-->
              <!--legal_phone: self.form.enterprisePhone,     // 法人手机号-->
              <!--legal_number: self.form.enterpriseIdCard,   // 法人身份证-->
              <!--credit_code: self.form.enterpriseCreditCode,        // 社会信用代码-->
              <div class="item">
                <p class="p-key">法人姓名:</p>
                <p class="p-val">{{ item.legal_person }}</p>
              </div>

              <div class="item">
                <p class="p-key">法人手机号:</p>
                <p class="p-val">{{ item.legal_phone }}</p>
              </div>

              <!--<div class="item">-->
                <!--<p class="p-key">法人身份证:</p>-->
                <!--<p class="p-val">{{ item.legal_number }}</p>-->
              <!--</div>-->

              <!--<div class="item">-->
                <!--<p class="p-key">社会信用代码:</p>-->
                <!--<p class="p-val">{{ item.credit_code }}</p>-->
              <!--</div>-->

              <div class="item">
                <p class="p-key">法人身份证人像面照片:</p>
                <div class="show-img">
                  <img @click="showImg(portrait_id)" :src="portrait_id" alt="" class="cursor">
                </div>
              </div>
              <div class="item">
                <p class="p-key">法人身份证国徽面照片:</p>
                <div class="show-img">
                  <img @click="showImg(national_emblem_id)" :src="national_emblem_id" alt="" class="cursor">
                </div>
              </div>

              <div class="form-title margin-t-35">
                <span>门店信息</span>
              </div>

              <div class="item">
                <p class="p-key">门店名称:</p>
                <p class="p-val">{{ item.store_name }}</p>
              </div>

              <div class="item">
                <p class="p-key">门店地址:</p>
                <p class="p-val">{{ storesCity }}</p>
              </div>

              <div class="item">
                <p class="p-key">商品分类:</p>
                <p class="p-val">{{ item.category }}</p>
              </div>

              <div class="item">
                <p class="p-key">授权条件:</p>
                <p class="p-val">{{ item.authorization }}</p>
              </div>
              <div class="item">
                <p class="p-key">门店联系人姓名:</p>
                <p class="p-val">{{ item.name }}</p>
              </div>

              <div class="item">
                <p class="p-key">职位:</p>
                <p class="p-val">{{ item.position }}</p>
              </div>

              <div class="item">
                <p class="p-key">门店联系人手机号:</p>
                <p class="p-val">{{ item.phone }}</p>
              </div>

              <!--<div class="item">-->
                <!--<p class="p-key">经营情况:</p>-->
                <!--<p class="p-val">{{ item.operation_situation }}</p>-->
              <!--</div>-->

              <!--<div class="item">-->
                <!--<p class="p-key">营业执照图片:</p>-->
                <!--<div class="show-img">-->
                  <!--<img @click="showImg(license_id)" :src="license_id" alt="" class="cursor">-->
                <!--</div>-->
              <!--</div>-->
              <div class="item">
                <p class="p-key">门店正面照片:</p>
                <div class="show-img">
                  <img @click="showImg(front_id)" :src="front_id" alt="" class="cursor">
                </div>
              </div>
              <div class="item">
                <p class="p-key">门店内部照片:</p>
                <div class="show-img">
                  <img @click="showImg(Inside_id)" :src="Inside_id" alt="" class="cursor">
                </div>
              </div>
            </div>
            <div class="rz-box">
              <div class="rz-title success" v-if="item.status === 2">
                <p>审核通过</p>
              </div>
              <div class="rz-title wait" v-else-if="item.status === 0">
                <p>等待认证</p>
              </div>
              <div class="rz-title wait" v-else-if="item.status === 1">
                <p>待审核</p>
              </div>
              <div class="rz-title rejust" v-else-if="item.status === 3">
                <p>审核未通过</p>
              </div>
              <div class="rz-title rejust" v-else-if="item.status === 4">
                <p>正在重新审核</p>
              </div>
              <div class="rz-stat" v-if="item.length === 0 || item.status === 0 || item.status === undefined">
                <router-link :to="{name: 'centerIdentifySubmit'}" class="item">
                  <Button class="is-custom" type="primary">填写信息</Button>
                </router-link>
              </div>
              <div class="rz-stat" v-else-if="item.status !== 0 || item.status !== 2">
                <router-link :to="{name: 'centerIdentifySubmit'}" class="item">
                  <Button class="is-custom" type="primary">修改信息</Button>
                </router-link>
              </div>
            </div>

            <div class="clear"></div>
          </div>
        </div>

      </Col>
    </Row>
    <Modal
      v-model="modal1"
      title="图片详情"
      class="testImg"
    >
      <img :src="showImages" alt="">
    </Modal>
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/Menu'

export default {
  name: 'center_account_identify_show',
  components: {
    vMenu
  },
  data () {
    return {
      item: '',
      msg: '',
      modal1: false,
      showImages: '',
      portrait_id: '',        // 身份证正面
      national_emblem_id: '', // 身份证背面
      license_id: '',         // 营业执照
      front_id: '',           // 门店正面
      Inside_id: '',          // 门店正面
      id: null,               // id
      enterpriseCity: '',     // 企业地址拼接
      storesCity: ''          // 门店地址拼接
    }
  },
  methods: {
    showImg (img) {
      this.modal1 = true
      this.showImages = img
    },
    testVux () {
      const self = this
      self.$http.get(api.showMessage, {token: self.$store.state.event.token})
        .then(function (response) {
          if (response.status === 200) {
            if (response.data.meta.status_code === 200) {
              response.data.data.forEach((item) => {
                localStorage.setItem('storesInfo', JSON.stringify(item))
                self.item = item
                self.front_id = item.front
                self.Inside_id = item.Inside
                self.portrait_id = item.portrait
                self.national_emblem_id = item.national_emblem
                self.license_id = item.license
                if (self.item.taxpayer === 1) {
                  self.item.taxpayer = '一般纳税人'
                } else {
                  self.item.taxpayer = '小额纳税人'
                }
                self.id = self.item.id ? self.item.id : ''
                // 门店
                if (item.province) {
                  self.storesCity = item.province + '/' + item.city + '/' + item.county
                } else {
                  self.storesCity = '暂无地址'
                }
                // 企业
                if (item.e_province) {
                  self.enterpriseCity = item.e_province + '/' + item.e_city + '/' + item.e_county
                } else {
                  self.enterpriseCity = '暂无地址'
                }
              })
              if (self.item.authorization) {
                self.item.authorization = self.item.authorization.split(',').join('/').substring(0, self.item.authorization.length - 1)
              }
              if (self.item.category) {
                self.item.category = self.item.category.split(',').join('/').substring(0, self.item.category.length - 1)
              }
            }
          } else {
            self.$Message.error(response.data.meta.message)
          }
        })
        .catch(function (error) {
          self.$Message.error(error.message)
        })
    }
  },
  created: function () {
    this.testVux()
  },
  watch: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .rz-box {
    margin-top: 50px;
  }
  .rz-title {
    float: left;
  }
  .rz-title p{
    font-size: 1.8rem;
  }
  .success p {
    color: #008000;
  }
  .wait p {
    color: #FF4500;
  }
  .rejust p {
    color: #FF4500;
  }
  .rz-stat {
    float: right;
  }

  .company-show {

  }

  .company-show .item {
    clear: both;
    height: 40px;
    border-bottom: 1px solid #ccc;
    margin: 10px 0;
  }

  .item p {
    line-height: 3;
  }

  .item p.p-key {
    float: left;
    width: 160px;
    color: #666;
    margin-right: 100px;
  }

  .item p.p-val {
    width: 300px;
    float: left;
    font-size: 1.5rem;
  }
  .show-img {
    position: relative;
    width: 35px;
    height: 35px;
    float: left;
  }
  .show-img img {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    margin: auto;
  }
</style>
