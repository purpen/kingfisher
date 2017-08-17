<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div>
      <Breadcrumb>
          <Breadcrumb-item href="/home">首页</Breadcrumb-item>
          <Breadcrumb-item href="/product">产品库</Breadcrumb-item>
          <Breadcrumb-item>文字素材</Breadcrumb-item>
      </Breadcrumb>
    </div>
    <div class="item-list">
      <h3><i class="fa fa-file-text-o" aria-hidden="true"></i> 文字素材 <span>({{ itemCount }})</span></h3>
      <Spin size="large" fix v-if="isLoading"></Spin>
        <Row :gutter="20">
          <Col :span="6" v-for="(d, index) in itemList" :key="index">
            <Card :padding="0" class="card-box">
              <a href="javascript:void(0);" @click="showTextBtn(d)">
              <div class="text-box">
                <p>{{ d.describe }}</p>
              </div>
              </a>
              <!--
              <div class="img-content">
                <div class="des" style="text-align: right;">
                  <p><a href="javascript:void(0);" @click="showTextBtn(d)">查看全部</a></p>
                </div>
              </div>
              -->
            </Card>
          </Col>

        </Row>
    
    </div>

    <Modal
        v-model="showTextModel"
        @on-ok="showTextModel = false"
        :closable="false"
        @on-cancel="showTextModel = false">
        <p>{{ currentText }}</p>
        <div slot="footer">
          <Button @click="showTextModel = false">关闭</Button>
        </div>
    </Modal>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'product_text_list',
  data () {
    return {
      isLoading: false,
      showTextModel: false,
      currentText: '',
      itemId: '',
      itemList: [],
      itemCount: '',
      msg: '产品文字库'
    }
  },
  methods: {
    // 查看文字详情弹层
    showTextBtn (obj) {
      this.currentText = obj.describe
      this.showTextModel = true
    }
  },
  created: function () {
    const self = this
    const productId = this.$route.params.product_id
    if (!productId) {
      this.$Message.error('缺少请求参数!')
      this.$router.replace({name: 'home'})
      return
    }
    self.itemId = productId

    // 文字列表
    self.isLoading = true
    self.$http.get(api.productTextList, {params: {product_id: productId, per_page: 40}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        var textList = response.data.data
        for (var i = 0; i < textList.length; i++) {
        } // endfor
        self.itemList = textList
        self.itemCount = response.data.meta.pagination.count
        console.log(self.itemList)
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .item-list {
    margin: 20px 0;
  }

  .item-list h3 {
    font-size: 1.8rem;
    color: #222;
    line-height: 2;
  }

  .text-box {
    height: 200px;
    padding: 15px;
  }
  .text-box p {
    height: 150px;
    line-height: 1.5;
    text-overflow: ellipsis;
    overflow: hidden;
    text-overflow: clip;
  }


</style>
