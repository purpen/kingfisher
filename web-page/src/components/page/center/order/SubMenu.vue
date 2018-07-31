<template>
  <div>
    <div class="tools">
      <!--<Button type="ghost" @click="importBtn"><i class="fa fa-cloud-upload" aria-hidden="true"></i> 导入订单</Button>-->
      <Button type="ghost" @click="createBtn"><i class="fa fa-plus-square-o fa-1x" aria-hidden="true"></i> 创建订单</Button>
      <!--<Button type="ghost" @click="importRecordBtn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> 导入记录</Button>-->
      <!--<a class="down-mode" href="https://kg.erp.taihuoniao.com/order/thn_order_mode.csv"><i class="fa fa-download" aria-hidden="true"></i> 下载太火鸟订单格式文件</a>-->
    </div>

    <Modal v-model="importModal" width="360" class="no-footer">
        <p slot="header" style="text-align:center">
            <span>导入订单</span>
        </p>
        <div class="import-box">
          <Upload
            :action="uploadUrl"
            name="file"
            :data="{excel_type: fileType, token: currentToken}"
            :format="['csv','excel', 'xlsx']"
            :max-size="2048"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :on-preview="handlePreview"
            :on-success="handleSuccess"
            :on-error="handleError"
            :show-upload-list="false"
            :before-upload="handleBefore"
            :on-progress="handleProgress"
            >
            <Button type="primary">上传文件</Button>
          </Upload>
          <p class="up-des">{{ uploadMsg }}</p>
          <p v-if="importSuccessShow">点击查看：<a @click="orderListBtn">订单列表</a>、 <a @click="importRecordBtn">导入记录</a></p>
          <p class="order-type"><span>——————&nbsp;&nbsp;</span>请选择订单格式类型<span>&nbsp;&nbsp;——————</span></p>

          <Radio-group v-model="fileType">
              <Radio label="1">太火鸟</Radio>
              <Radio label="2">京东</Radio>
              <Radio label="3">淘宝</Radio>
          </Radio-group>
        </div>
    </Modal>
  </div>
</template>

<script>
import api from '@/api/api'
import '@/assets/js/date_format'
export default {
  name: 'center_order_sub_menu',
  data () {
    return {
      isLoading: false,
      importModal: false,
      importSuccessShow: false,
      fileType: 1,
      uploadUrl: process.env.API_ROOT + api.orderExcel,
      currentToken: this.$store.state.event.token,
      uploadMsg: '只限上传exel csv格式文件',
      msg: ''
    }
  },
  methods: {
    // 创建订单
    createBtn () {
      this.$router.push({name: 'centerOrderSubmit'})
    },
    // 导入记录
    importRecordBtn () {
      if (this.$route.name === 'centerOrderImportRecord') {
      }
      this.$router.push({name: 'centerOrderImportRecord'})
    },
    // 订单列表
    orderListBtn () {
      this.$router.push({name: 'centerOrder'})
    },
    // 打开导入对话框
    importBtn () {
      this.uploadMsg = '只限上传exel csv格式文件'
      this.importSuccessShow = false
      this.importModal = true
    },
    // 上传之前钩子
    handleBefore (file) {
    },
    // 导入文件格式钩子
    handleFormatError (file, fileList) {
      this.$Message.error('文件格式不正确!')
      return false
    },
    // 文件大小钩子
    handleMaxSize (file, fileList) {
      this.$Message.error('文件大小不能超过2M!')
      return false
    },
    // 文件上传钩子
    handlePreview (file) {
    },
    // 上传成功构子
    handleSuccess (response, file, fileList) {
      console.log(response)
      this.uploadMsg = '只限上传exel csv格式文件'
      if (response.meta.status_code === 200) {
        this.importSuccessShow = true
        this.uploadMsg = '上传成功!'
        // this.importModal = false
        // this.$router.push({name: this.$route.name})
        // this.$Message.success('导入成功!')
      } else {
        this.$Message.error(response.meta.message)
        return false
      }
    },
    // 上传进行中钩子
    handleProgress (event, file, fileList) {
      this.uploadMsg = '上传中...'
    },
    // 上传失败钩子
    handleError (error, file, fileList) {
      this.$Message.error(error)
      this.uploadMsg = '只限上传exel csv格式文件'
      return false
    }
  },
  created: function () {
  },
  watch: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .tools {
    margin: 10px 0;
  }
  .tools button {
    margin-right: 10px;
  }
  a.down-mode {
    color: #C18D1D;
  }
  .import-box {
    text-align: center;
    padding-bottom: 20px;
  }
  .import-box p {
    font-size: 1.2rem;
    line-height: 2.5;
  }
  .import-box .up-des {
    color: #777;
  }
  .import-box .order-type span {
    color: #ccc;
  }

</style>
