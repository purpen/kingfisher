<template>
  <div>
    <Modal
      v-model="bounced"
      width="327"
      :mask-closable="false"
      :closable="false"
      :styles="{top: '38%'}"
      class-name="vertical-center-modal AddressManagementShippingAddress"
    >
      <Icon type="md-close" class="close_this" @click.native="cancel()" />
      <div class="save_success">
        <p>是否删除此信息?</p>
      </div>
      <div class="modal-footer AddressManagementShippingAddress_odal-footer">
        <Button type="text" @click.native="cancel()" class="odal-footer_button">取消</Button>
        <Button type="primary" @click.native="asyncOK">确定</Button>
      </div>
    </Modal>
  </div>
</template>

<script>
    export default {
      name: 'AddersManagenebtCounetersign',
      data () {
        return {
          Bus: this.$BusFactory(this),
          bounced: true, // 弹框是否显示
          this_ids: ''
        }
      },
      components: {},
      methods: {
        cancel () {
          this.bounced = false
          this.this_ids = ''
          this.Bus.$emit('erp-address-management-isoks_close', 'change')
        },
        asyncOK () {
          let thisids = this.this_ids
          this.Bus.$emit('erp-address-management-isoks_okclose', thisids)
        }
      },
      created: function () { // 删除地址弹出框
        this.Bus.$on('erp-address-management-isoks', (em) => { // 开启成功
          this.bounced = true
          this.this_ids = em
        })
        this.Bus.$on('erp-address-management-isoks_is', (em) => {
          if (em === 'ok') {
            this.bounced = false
            this.this_ids = ''
            this.$Message.success('删除成功')
          } else if (em === 'no') {
            this.bounced = false
            this.this_ids = ''
            this.$Message.error('删除失败请稍后重试')
          }
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
    padding: 19px 41px 0 41px;
    text-align: right;
    /*width: 206px;*/
    box-sizing: border-box;
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  }
  .save_success p{
    width: 100%;
    height: auto;
    line-height: 30px;
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
    margin-bottom: 20px;
  }
  .save_success i {
    margin: 0 auto;
    font-size: 50px;
    display: inline-block;
    color: #00ff00;
  }
  .odal-footer_button{
    margin-right: 26px;
  }
  .close_this{
    font-size: 22px;
    position: absolute;
    color: #C8C8C8;
    right: 16px;
    top: 12px;
  }
</style>
