<template>
  <div>
    <Modal
      v-model="bounced"
      :styles="{top: '50px'}"
      width="720"
      :mask-closable="false"
      :closable="false"
      class-name="vertical-center-modal AddressManagementShippingAddress"
    >
      <div class="save_success">
        <p><Icon type="md-checkmark-circle" /></p>
        <p>设置成功</p>
      </div>
      <div class="modal-footer">
        <Button type="text" @click.native="cancel">取消</Button>
        <Button type="primary" @click.native="asyncOK">确定</Button>
      </div>
    </Modal>
  </div>
</template>

<script>
    export default {
      name: 'AddressManagementSavesuccess',
      data () {
        return {
          Bus: this.$BusFactory(this),
          bounced: false // 弹框是否显示
        }
      },
      components: {},
      methods: {
        cancel () {
          this.bounced = false
          this.Bus.$emit('AddressManagementShippingAddress_hide_okHide', 'change')
        },
        asyncOK () {
          this.bounced = false
          this.Bus.$emit('AddressManagementShippingAddress_hide_okHide', 'change')
        }
      },
      created: function () {
        this.Bus.$on('AddressManagementShippingAddress_hide_okshow', (em) => {
          // 开启成功提示
          this.bounced = true
        })
      },
      mounted () {

      },
      watch: {}
    }
</script>

<style scoped>
  .vertical-center-modal .ivu-modal{
    top: 0;
  }
  .modal-footer{
    border-top: 1px solid #e8eaec;
    padding: 12px 18px 0 18px;
    text-align: right;
    box-sizing: border-box;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  }
  .save_success p{
    width: 100%;
    height: auto;
    line-height: 30px;
    margin-top: 20px;
    text-align: center;
    font-size: 20px;
    margin-bottom: 20px;
  }
  .save_success i {
    margin: 0 auto;
    font-size: 50px;
    display: inline-block;
    color: #00ff00;
  }
</style>
