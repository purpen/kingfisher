<template>
  <div class="Mycart">
    <div class="cartheader">
      <span class="edit fr" @click="edit">{{bianji}}</span>
    </div>
    <CheckboxGroup class="goodslist" v-model="checkAllGroup">
      <Checkbox v-for="(ele, index) in goodslist" :label="index" class="item clearfix"
                :key="ele.id">
        <div class="item-detail fr">
          <div class="itemleft fl">
            <img v-if="ele.cover_url" :src="ele.cover_url" :alt="ele.cover_url">
            <img v-else :src="require('@/assets/images/default_thn.png')" alt="">
          </div>
          <div class="itemright fl">
            <p class="itemtitle">{{ele.short_title}}</p>
            <p class="sku">{{ele.sku_name}}</p>
            <p class="info clearfix">
              <span class="price fl">{{ele.price}}</span>
              <span class="amount fr">{{ele.n}}</span>
            </p>
            <!--<Button class="del" type="error" @click="delGoods(index)" v-if="isedit">删除</Button>-->
          </div>
        </div>
        <Modal
          title="确认删除"
          v-model="modal"
          width="90%"
          :styles="{top: '20px'}"
          @on-ok="ok">
          确认将这{{modalText}}个宝贝删除？
        </Modal>
      </Checkbox>
    </CheckboxGroup>
    <div class="cartFooter clearfix" v-if="!isedit">
      <Checkbox class="checkAll fl"
                :indeterminate="indeterminate"
                :value="checkAll"
                @click.prevent.native="handleCheckAll"
      >
        全选
      </Checkbox>
      <p class="pay fr">
        <Button class="btn fr" @click.native="checkout">结算({{checklength}})</Button>
        <span class="fr">合计：<i>￥{{total}}</i></span>
      </p>
    </div>
    <button class="delbtn cartFooter" @click="delGoods" v-if="isedit">删除</button>
  </div>
</template>
<script>
  import api from '@/api/api'

  export default {
    name: '',
    data () {
      return {
        goodslist: [],
        i: -1,
        checkAllGroup: [],
        checkAll: false,
        indeterminate: false,
        total: '0.00',
        checkNum: false,
        isedit: false,
        bianji: '编辑',
        modal: false, // 对话框默认不显示
        modalText: '', // 对话框内容
        delId: [] // 要删除的购物车id
      }
    },
    created () {
      this.getGoods()
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      },
      checklength () {
        return this.checkAllGroup.length
      }
    },
    watch: {
      checkAllGroup () {
        if (!this.checkAllGroup.length) {
          this.checkAll = false
          this.indeterminate = false
        } else if (this.checkAllGroup.length === this.goodslist.length) {
          this.checkAll = true
          this.indeterminate = false
        } else if (this.checkAllGroup.length > this.goodslist.length) {
          this.checkAllGroup.pop()
          this.checkAll = true
          this.indeterminate = false
        } else {
          this.checkAll = false
          this.indeterminate = true
        }

        this.delId.splice(0, this.delId.length)
        for (let i of this.checkAllGroup) {
          this.delId.push(this.goodslist[i].id)
        }
        this.calcTotal()
      }
    },
    methods: {
      getGoods () {
        const that = this
        that.$http
          .get(api.cart, {params: {token: this.isLogin}})
          .then(res => {
            if (res.data.data) {
              this.goodslist = res.data.data
              for (let i of this.goodslist) {
                i.total = i.n * i.price
              }
            } else {
              this.goodslist.splice(0, this.goodslist.length)
              this.$Message.info('购物车是空的')
            }
//            console.log(this.goodslist)
          })
          .catch(err => {
            console.error(err)
          })
      },
      edit () {
        this.isedit = !this.isedit
        if (this.isedit) {
          this.bianji = '完成'
        } else {
          this.bianji = '编辑'
        }
      },
      handleCheckAll () {
        if (this.checkAllGroup.length === 0) {
          for (let i in this.goodslist) {
            this.checkAllGroup.push(Number(i))
          }
        } else {
          this.checkAllGroup.splice(0, this.checkAllGroup.length)
        }
      },
      calcTotal () {
        this.total = 0
        if (this.checkAllGroup.length) {
          for (let i of this.checkAllGroup) {
            this.total = this.total + this.goodslist[i].total
          }
        }
      },
      checkout () {
//        console.log(this.delId)
        if (this.delId.length) {
          this.$router.push({name: 'order', params: {cartid: this.delId}})
        } else {
          this.$Message.error('请选择商品')
        }
      },
      delGoods () {
        if (this.delId.length) {
          this.modal = true
          this.modalText = this.delId.length
        } else {
          this.$Message.error('没有选择商品')
        }
      },
      ok () {
        const that = this
        let id = this.delId.join()
        that.$http.post(api.cartdel, {id: id, token: this.isLogin})
          .then((res) => {
            if (res.data.meta.status_code === 200) {
              that.getGoods()
            } else if (res.data.meta.status_code === 412) {
              that.$Message.error(res.data.meta.message)
            } else if (res.data.meta.status_code === 402) {
              that.$Message.error(res.data.meta.message)
            }
          })
          .catch((err) => {
            console.error(err)
            that.$Message.error('请求失败')
          })
      }
    }
  }
</script>
<style scoped>
  .Mycart {
    min-height: calc(100vh - 100px);
    background: #fafafa;
    position: relative;
  }

  .cartheader, .cartFooter {
    position: fixed;
    width: 100%;
    max-width: 768px;
    left: 0;
    right: 0;
    top: 0;
    margin: auto;
    line-height: 50px;
  }

  .cartheader {
    color: #666;
  }

  .cartFooter {
    height: 44px;
    line-height: 44px;
    top: auto;
    bottom: 50px;
    background: #fff;
    color: #000;
  }

  .edit {
    padding-right: 6px;
  }

  .editNum {
    float: right;
    line-height: 28px;
    height: 28px;
    vertical-align: top;
  }

  .checkAll {
    padding-left: 15px;
    font-size: 14px;
  }

  .goodslist {
    padding-top: 10px;
  }

  .goodslist .item {
    width: 100%;
    background: #fff;
    position: relative;
    margin-bottom: 10px;
  }

  .goodslist .item:last-child {
    margin-bottom: 0;
  }

  .item-detail {
    width: calc(100% - 50px);
  }

  .itemleft img {
    width: 100px;
    height: 100px;
    vertical-align: top;
  }

  .itemright {
    position: relative;
    width: calc(100% - 100px);
    padding: 10px;
    height: 100px;
  }

  .itemright p {
    padding: 5px 0;
  }

  .itemright .itemtitle {
    color: #222222;
    font-family: PingFangSC-Light, sans-serif !important;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    word-break: break-all;
    font-weight: 600;
  }

  .itemright .sku {
    font-size: 12px;
    color: #666;
  }

  .itemright .price {
    color: #BE8914;
    font-size: 18px;
  }

  .itemright .info {
    line-height: 18px;
  }

  .itemright .amount {
  }

  .pay span {
    font-size: 15px;
    margin-right: 10px;
  }

  .pay span i {
    color: #BE8914;
  }

  .btn {
    background: #BE8914;
    border: 1px solid #BE8914;
    border-radius: 0;
    color: #fff;
    height: 44px;
    min-width: 30%;
  }

  .delbtn {
    height: 36px;
    line-height: 36px;
    border: 1px solid #BE8914;
    background: #BE8914;
    color: #fff;
    font-size: 15px;
  }

  /*#BE8914*/
</style>
