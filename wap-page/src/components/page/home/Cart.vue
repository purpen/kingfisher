<template>
  <div class="Mycart">
    <div class="cartheader">
      <span class="edit fr" @click="edit">编辑</span>
    </div>
    <CheckboxGroup class="goodslist" v-model="checkAllGroup">
      <Checkbox v-for="(ele, index) in goodslist" :label="ele.price * ele.n" class="item clearfix"
                @click="choose(index)"
                :key="index">
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
            <Button class="del" type="error" @click="delGoods" v-if="isedit">删除</Button>
          </div>
        </div>
        <Modal
          title="Title"
          v-model="modal"
          width="90%"
          :styles="{top: '20px'}">
          确认删除{{ele.short_title}}？
        </Modal>
      </Checkbox>
    </CheckboxGroup>
    <div class="cartFooter clearfix">
      <Checkbox class="checkAll fl" :indeterminate="indeterminate" :value="checkAll"
                @click.prevent.native="handleCheckAll">
        全选
      </Checkbox>
      <p class="pay fr">
        <Button class="btn fr" @click.native="checkout">结算({{checklength}})</Button>
        <span class="fr">合计：<i>￥{{total}}</i></span>
      </p>
    </div>
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
        modal: false
      }
    },
    created () {
      const that = this
      that.$http
        .get(api.cart, {params: {token: this.isLogin}})
        .then(res => {
          this.goodslist = res.data.data
          console.log(res.data.data)
        })
        .catch(err => {
          console.error(err)
        })
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
        if (this.checkAllGroup.length === this.goodslist.length) {
          this.checkAll = true
          this.indeterminate = false
        } else if (!this.checkAllGroup.length) {
          this.checkAll = false
          this.indeterminate = false
        } else {
          this.checkAll = false
          this.indeterminate = true
        }
        console.log(this.checkAllGroup)
        this.calcTotal()
      }
    },
    methods: {
      edit () {
        this.isedit = !this.isedit
      },
      handleCheckAll () {
        if (this.checkAllGroup.length === 0) {
          for (let i of this.goodslist) {
            this.checkAllGroup.push(i.price * i.n)
          }
        } else {
          this.checkAllGroup.splice(0, this.checkAllGroup.length)
        }
      },
      calcTotal () {
        this.total = 0
        if (this.checkAllGroup.length) {
          for (let i of this.checkAllGroup) {
            this.total = this.total + i
          }
        }
      },
      checkout () {
        console.log(this.checkAllGroup)
      },
      delGoods () {
        this.modal = true
      }
    }
  }
</script>
<style scoped>
  .Mycart {
    min-height: calc(100vh - 50px);
    background: #f2f2f2;
    position: relative;
  }

  .cartheader, .cartFooter {
    position: fixed;
    z-index: 2;
    width: 100%;
    max-width: 768px;
    left: 0;
    right: 0;
    top: 0;
    margin: auto;
    height: 50px;
    line-height: 50px;
    color: #fff;
  }

  .cartFooter {
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
    padding-left: 10px;
  }

  /*.goodslist {*/
  /*padding-top: 10px;*/
  /*}*/

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
    width: 90%;
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

  .itemright .del {
    position: absolute;
    top: 10px;
    right: 10px;
  }

  .itemright p {
    padding: 5px 0;
  }

  .itemright .itemtitle {
    color: #051b28;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    word-break: break-all;
    font-weight: 600;
  }

  .itemright .sku {
    font-size: 12px;
    color: #999;
  }

  .itemright .price {
    color: #c3a769;
    font-size: 18px;
  }

  .itemright .info {
    line-height: 18px;
  }

  .itemright .amount {
  }

  .pay span {
    font-size: 14px;
    margin-right: 10px;
  }

  .pay span i {
    color: #c3a769;
  }

  .btn {
    background: #FF0036;
    border: 1px solid #FF0036;
    border-radius: 0;
    color: #fff;
    height: 50px;
    min-width: 30%;
  }

  /*#FF0036*/
</style>
