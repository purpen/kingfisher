<template>
  <div class="container min-height350">
    <div class="blank20"></div>

    <Row :gutter="20">
      <Col :span="3" class="left-menu">
        <v-menu currentName="identify_show"></v-menu>
      </Col>
      <Col :span="21">
        <div class="right-content">
          <div class="content-box">
            <div class="form-title">
              <span>个人信息</span>
            </div>

            <div class="company-show">
              <div class="item">
                <p class="p-key">姓名</p>
                <p class="p-val">{{ item.name }}</p>
              </div>

              <div class="item">
                <p class="p-key">电话</p>
                <p class="p-val">{{ item.phone }}</p>
              </div>

              <div class="item">
                <p class="p-key">银行卡账号</p>
                <p class="p-val">{{ item.bank_number }}</p>
              </div>

              <div class="item">
                <p class="p-key">开户行</p>
                <p class="p-val">{{ item.bank_name }}</p>
              </div>

              <div class="item">
                <p class="p-key">纳税类型</p>
                <p class="p-val">{{ item.taxpayer }}</p>
              </div>
              <div class="item">
                <p class="p-key">身份证人像面照片</p>
                <div class="show-img">
                  <img @click="showImg(f)" :src="f" alt="" class="cursor">
                </div>
                <p class="p-val">{{ item.document_type_value }}</p>
              </div>
              <div class="item">
                <p class="p-key">身份证国徽面照片</p>
                <div class="show-img">
                  <img @click="showImg(r)" :src="r" alt="" class="cursor">
                </div>
                <p class="p-val">{{ item.document_type_value }}</p>
              </div>
              <div class="form-title">
                <span>门店信息</span>
              </div>
              <div class="item">
                <p class="p-key">门店名称</p>
                <p class="p-val">{{ item.store_name }}</p>
              </div>

              <div class="item">
                <p class="p-key">门店地址</p>
                <p class="p-val">{{ item.province_id }}</p>
              </div>

              <div class="item">
                <p class="p-key">授权条件</p>
                <p class="p-val">{{ item.authorization_id }}</p>
              </div>

              <div class="item">
                <p class="p-key">商品分类</p>
                <p class="p-val">{{ item.category_id }}</p>
              </div>

              <div class="item">
                <p class="p-key">经营情况</p>
                <p class="p-val">{{ item.operation_situation }}</p>
              </div>

              <div class="item">
                <p class="p-key">营业执照号</p>
                <p class="p-val">{{ item.business_license_number }}</p>
              </div>

              <div class="item">
                <p class="p-key">营业执照图片</p>
                <p class="p-val">{{ item.email }}</p>
              </div>
              <div class="item">
                <p class="p-key">门店正面照片</p>
                <p class="p-val">{{ item.email }}</p>
              </div>
              <div class="item">
                <p class="p-key">门店内部照片</p>
                <p class="p-val">{{ item.email }}</p>
              </div>
            </div>
            <div class="rz-box">
              <div class="rz-title success" v-if="item.status === '3'">
                <p>认证通过</p>
              </div>
              <div class="rz-title wait" v-else-if="item.status === '0'">
                <p>等待认证</p>
              </div>
              <div class="rz-title wait" v-else-if="item.status === '1'">
                <p>审核中</p>
              </div>
              <div class="rz-title rejust" v-else-if="item.status === '2'">
                <p>认证未通过</p>
              </div>
              <div class="rz-title rejust" v-else-if="item === ''">
                <p>系统错误</p>
              </div>
              <div class="rz-stat" v-if="item.status === '0' || item.status === '2'">
                <router-link :to="{name: 'centerIdentifySubmit1', query: {type: 1 }}" class="item">
                  <Button class="is-custom" type="primary">提交认证</Button>
                </router-link>
              </div>

              <div class="rz-stat" v-if="item.status === '1'">
                <router-link :to="{name: 'centerIdentifySubmit1', query: {type: 2 }}" class="item">
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
      f: require('assets/images/fiu_logo.png'),
      r: require('assets/images/product_500.png')
    }
  },
  methods: {
    showImg (img) {
      this.modal1 = true
      this.showImages = img
    }
  },
  created: function () {
    const self = this
    self.$http.get(api.showMessage, {token: self.$store.state.event.token})
    .then(function (response) {
      console.log(response.data.meta.status_code)
      if (response.data.meta.status_code === 200) {
        if (response.data.data) {
          response.data.data.forEach((item) => {
            self.item = item
            console.log(item)
            if (self.item.taxpayer === 1) {
              self.item.taxpayer = '一般纳税人'
            } else {
              self.item.taxpayer = '小额纳税人'
            }
          })
          if (self.item.authorization_id) {
            self.item.authorization_id = self.item.authorization_id.split(',').join('/').substring(0, self.item.authorization_id.length - 1)
          }
        }
      } else {
        self.$Message.error(response.data.meta.message)
      }
    })
    .catch(function (error) {
      self.$Message.error('11' + error.message)
    })
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
  }

  .item p {
    line-height: 3;
  }

  .item p.p-key {
    float: left;
    width: 150px;
    color: #666;
  }

  .item p.p-val {
    width: 300px;
    float: left;
    font-size: 1.5rem;
  }

  .show-img img {
    width: 35px;
    height: 35px;
  }
</style>
