<template>
  <div class="CommodityDetailsIndex_center">
    <Row :gutter="20" type="flex" justify="center">
      <Spin fix v-if="particulars_loading" class="posi_fix"></Spin>
      <Col span="24">
        <div class="LibraryOfGoodsIndex_center">
          <div class="LibraryOfGoodsIndex_center_headers">
            <div class="LibraryOfGoodsIndex_center_title">
              <p>{{titles}}</p>
            </div>
            <div class="LibraryOfGoodsIndex_search_box">
              <Input v-model="searchBoxValue" placeholder="商品名称/商品编号/订单号" class="search_box_search">
              <Icon type="ios-search" slot="suffix" :loading="search_box_loading" @click.active="searchBox_Value" />
              </Input>
            </div>
          </div>
          <div class="LibraryOfGoodsIndex_center_content">
            <div class="LibraryOfGoodsIndex_center_content_carousel">
                <div class="LibraryOfGoodsIndex_center_content_carousel_ceter">
                  <div class="LibraryOfGoodsIndex_center_content_bigimg" v-if="data.min">
                    <!--<img-Zoom :previewImg="data.min" :zoomImg="data.max"></img-Zoom>-->
                    <img :src="data.min" alt="">
                  </div>
                  <div class="LibraryOfGoodsIndex_center_content_bigimg_none" v-else>
                    <img src="../../assets/images/product_500.png" alt="">
                  </div>
                </div>
                <div class="LibraryOfGoodsIndex_center_content_samll">
                  <ul>
                    <li
                      v-for="(data_smalls, index) in data_small"
                      :key="index"
                      :class="{actives : index == page_index}"
                      @mouseover="page_index_change(index,data_smalls.images)"
                      v-if="data_smalls.images"
                    >
                      <img :src="data_smalls.images" alt="">
                    </li>
                    <li v-else @mouseover="page_index_change(index,'')">
                      <img src="../../assets/images/product_500.png" alt="">
                    </li>
                  </ul>
                </div>
                <div class="LibraryOfGoodsIndex_center_content_like" @click="like_this_shooping()">
                  <img src="../../assets/images/libraryOfGoods/icon-redxin.png"  v-if="like_Value_Show" alt="">
                  <img src="../../assets/images/libraryOfGoods/icon-xingz.png" v-else alt="">
                  <i>{{Pay_attention_this_text}}</i>
                  <span>({{like_Value_Show_length}})</span>
                </div>
            </div>
            <div class="LibraryOfGoodsIndex_center_content_merchandise_centers">
              <div class="LibraryOfGoodsIndex_center_content_merchandise_selection">
              <Spin fix v-if="particulars_loading" class="posi_fix"></Spin>
              <div class="LibraryOfGoodsIndex_center_content_merchandise_selectionnone" v-if="product_information.length<=0">
                暂无数据
              </div>
              <div v-else class="LibraryOfGoodsIndex_center_content_merchandise_selectioncenter" v-for="(product_informations, index) in product_information" :key="index">
                <div class="LibraryOfGoodsIndex_center_content_merchandise_selectiontitle">
                  产品规格: &nbsp;{{product_informations.mode}}
                </div>
                <div class="LibraryOfGoodsIndex_center_content_merchandise_leftwholesale">
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice">
                    <ul>
                      <li class="wholesale_li">起&nbsp;批&nbsp;价:</li>
                      <li v-for="(prices, indexs) in product_informations.sku_region" :key="indexs">&#165;&nbsp;{{Math.floor(prices.sell_price)}}</li>
                    </ul>
                  </div>
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_Thebatch">
                    <ul>
                      <li class="Thebatch_li">起&nbsp;批&nbsp;量:</li>
                      <li v-for="(numberser, indexs) in product_informations.sku_region" :key="indexs">
                        {{numberser.min}}-{{numberser.max}}个
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory">
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory_maxquantity">
                    {{product_informations.inventory}}个可售
                  </div>
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping">
                    <ul>
                      <li>
                        <span class="left_span" @click="remove_number(index)"><img src="../../assets/images/details/icon-jian.png" alt=""></span>
                        <input
                          type="text"
                          v-model="product_informations.add_number"
                          @change="amount_change(index)"
                        >
                        <span class="right_span" @click="adds_number(index)"><img src="../../assets/images/details/icon-ad.png" alt=""></span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
              <div class="LibraryOfGoodsIndex_center_content_ok">
                <!--Button-->
                <Button
                  @click.active="Add_to_cart"
                  type="primary"
                  ghost icon="ios-paper-outline"
                  class="Button Button_left"
                  :loading="Button_left_loding"
                  :disabled="Button_left_disabled"
                >加入进货单</Button>
                <Button
                  type="default"
                  ghost class="Button Button_right"
                  :loading="Button_right_loding"
                  :disabled="Button_right_disabled"
                  @click.active="Buy_now"
                >立即购买</Button>
              </div>
            </div>
          </div>
        </div>
      </Col>
    </Row>
    <Row :gutter="20" type="flex" justify="center">
      <Col span="24">
      <div class="LibraryOfGoodsIndex_center_The_introduction">
        <div class="LibraryOfGoodsIndex_The_introduction_title">
          <p>商品介绍</p>
        </div>
        <div class="LibraryOfGoodsIndex_The_introduction_center">
          <div class="LibraryOfGoodsIndex_The_introduction_center_none" v-if="LibraryOfGoodsIndex_The_introduction === ''">
            暂无数据
          </div>
          <div class="LibraryOfGoodsIndex_The_introduction_center_content" v-else v-html="LibraryOfGoodsIndex_The_introduction"></div>
        </div>
      </div>
      </Col>
    </Row>
  </div>
</template>

<script>
    import imgZoom from '@/components/commodityDetails/CommodityDetailsIndexBigimg'
    import api from '@/api/api'
    export default {
      name: 'commodityDetailsIndex',
      data () {
        return {
          all_price: 0,
          Bus: this.$BusFactory(this),
          titles: '', // 商品标题
          ShoopingId: '', // 商品id
          search_box_loading: false, // 搜素防止误触发
          searchBoxValue: '', // 搜索框数据
          like_Value_Show: false, // 关注商品
          like_Value_Show_length: 0, // 关注商品人数
          Pay_attention_this_text: '关注商品', // 关注商品文字
          data: { // 图片放大镜查看大的是小的两倍
            min: ''
          },
          data_small: [], // 小图标
          page_index: 0, // 小图标切换大图标
          particulars_loading: false, // 页面lodaing
          product_information: [ // 产品选择信息

          ], // 货品
          Button_left_loding: false, // 进货单等待
          Button_left_disabled: false, // 进货单禁用
          Button_right_loding: false, // 立即购买等待
          Button_right_disabled: false, // 立即购买禁用
          LibraryOfGoodsIndex_The_introduction: '', // 商品介绍
          this_follow: false // 关注防止误点击
        }
      },
      components: {
        imgZoom
      },
      methods: {
        searchBox_Value () { // 请求搜索数据
          this.searchBoxValue = this.searchBoxValue.replace(/(^\s*)|(\s*$)/g, '')
          if (this.searchBoxValue === '' || this.searchBoxValue === undefined || this.searchBoxValue === null || this.searchBoxValue === 'undefined') {
            this.$Message.warning('搜索输入不能为空')
          } else {
            this.$store.commit('GLOBAL_SEARCH_LIBRARY_OF_GOODS', this.searchBoxValue)
            this.searchBoxValue = ''
            this.$router.push({name: 'libraryOfGoodsIndex'})
          }
          // 详情页面搜素点击搜素之后跳回
        },
        like_this_shooping () {
          if (this.this_follow === false) {
            if (this.like_Value_Show === true) {
              this.this_follow = true
              this.$http({
                method: 'post',
                url: api.LibraryOfGoodsIndexnotFollow,
                data: {
                  user_id: this.$store.state.event.token,
                  product_id: this.ShoopingId
                }
              })
              .then((res) => {
                let metas = res.data.meta
                if (metas.status_code === 200) {
                  this.$Message.success('取消关注成功')
                  this.like_Value_Show = false
                  this.Pay_attention_this_text = '关注商品'
                  if (this.like_Value_Show_length === 0) {
                    this.like_Value_Show_length = 0
                  } else {
                    this.like_Value_Show_length--
                  }
                } else {
                  this.$Message.error(metas.message)
                }
                this.this_follow = false
              })
              .catch((res) => {
                this.$Message.error(res.message)
                this.this_follow = false
              })
            } else {
              this.this_follow = true
              this.$http({
                method: 'post',
                url: api.LibraryOfGoodsIndexfollow,
                data: {
                  product_id: this.ShoopingId
                }
              })
              .then((res) => {
                let metas = res.data.meta
                if (metas.status_code === 200) {
                  this.$Message.success('关注成功')
                  this.like_Value_Show = true
                  this.Pay_attention_this_text = '已关注商品'
                  this.like_Value_Show_length++
                } else {
                  this.$Message.error(metas.message)
                }
                this.this_follow = false
              })
              .catch((res) => {
                this.$Message.error(res.message)
                this.this_follow = false
              })
            }
          } else if (this.this_follow === true) {
            if (this.like_Value_Show === false) {
              this.$Message.warning('清等待收藏成功之后再取消收藏')
            } else if (this.like_Value_Show === true) {
              this.$Message.warning('清等待取消收藏成功之后再点击收藏')
            }
          }
        },
        page_index_change (index, smallImg) {
          this.page_index = index
          this.data.min = smallImg
        },
        pushs () { // 模拟请求
          this.data.min = this.data_small[0]
        },
        amount_change (e) { // 输入框规则
          this.product_information[e].add_number = this.product_information[e].add_number.replace(/^[0]+[0-9]*$/gi, '')
          this.product_information[e].add_number = this.product_information[e].add_number.replace(/[^\d]/g, '')
          if (this.product_information[e].add_number === '' || this.product_information[e].add_number === null || this.product_information[e].add_number === undefined) {
            this.product_information[e].add_number = 0
          } else if (this.product_information[e].add_number >= this.product_information[e].inventory) {
            this.product_information[e].add_number = this.product_information[e].inventory
          }
        },
        remove_number (e) { // 减数量
          if (this.product_information[e].add_number <= 0) {
            this.product_information[e].add_number = '0'
          } else {
            this.product_information[e].add_number--
          }
        },
        adds_number (e) { // 加数量
          if (this.product_information[e].add_number >= this.product_information[e].inventory) {
            this.product_information[e].add_number = this.product_information[e].inventory
          } else {
            this.product_information[e].add_number++
          }
        },
        Add_to_cart () {
          let Arrays = []
          for (let i = 0; i < this.product_information.length; i++) {
            if (this.product_information[i].add_number === 0) {
              this.product_information[i].add_number = 0
            } else {
              let Replenish = {number: this.product_information[i].add_number, sku_id: this.product_information[i].sku_id, product_id: this.ShoopingId}
              Arrays.push(Replenish)
              this.product_information[i].add_number = 0
            }
          }
          if (Arrays.length === 0) {
            this.$Message.warning('请先添加购买的商品,再加入进货单')
          } else {
            this.Button_left_loding = true
            this.Button_right_disabled = true
            this.$http({
              method: 'post',
              url: api.LibraryOfGoodsIndexnotadd,
              data: {
                all: Arrays
              }
            })
            .then((res) => {
              let metas = res.data.meta
              if (metas.status_code === 200) {
                this.$Message.success('加入进货单成功')
                this.Bus.$emit('The_shopping_cart_length_Thebackground', 'changes')
              } else {
                this.$Message.error(metas.message)
              }
              this.Button_left_loding = false
              this.Button_right_disabled = false
            })
            .catch((res) => {
              this.$Message.error(res.message)
              this.Button_left_loding = false
              this.Button_right_disabled = false
            })
          }
        },
        Buy_now () {
          let Arrays = []
          for (let i = 0; i < this.product_information.length; i++) {
            if (this.product_information[i].add_number === 0) {
              this.product_information[i].add_number = 0
            } else {
              let Replenish = {number: this.product_information[i].add_number, sku_id: this.product_information[i].sku_id, product_id: this.ShoopingId}
              Arrays.push(Replenish)
              this.product_information[i].add_number = 0
            }
          }
          if (Arrays.length === 0) {
            this.$Message.warning('请先添加购买的商品,再进行购买操作')
          } else {
            this.Button_right_loding = true
            this.Button_left_disabled = true
            this.$http({
              method: 'post',
              url: api.LibraryOfGoodsIndexbuy,
              data: {
                all: Arrays
              }
            })
            .then((res) => {
              let metas = res.data.meta
              if (metas.status_code === 200) {
                this.$Message.success('加入进货单成功')
                this.Bus.$emit('The_shopping_cart_length_Thebackground', 'changes')
              } else {
                this.$Message.error(metas.message)
              }
              this.Button_right_loding = false
              this.Button_left_disabled = false
            })
            .catch((res) => {
              this.$Message.error(res.message)
              this.Button_right_loding = false
              this.Button_left_disabled = false
            })
          }
        },
        Add_the_initial () {
          for (let c = 0; c < this.demo.length; c++) {
            let goodser = this.demo[c].goods
            for (let d = 0; d < goodser.length; d++) {
              if (this.demo[c].number >= goodser[d].min && this.demo[c].number <= goodser[d].max) {

              }
            }
          }
          this.particulars_loading = true
          this.$http({
            method: 'get',
            url: api.LibraryOfGoodsIndexnotinfo,
            params: {
              product_id: this.ShoopingId,
              token: this.$store.state.event.token
            }
          })
          .then((res) => {
            let datas = res.data.data
            let metas = res.data.meta
            if (metas.status_code === 200) {
              let images = datas.image
              let skuse = datas.skus
              console.log(datas, skuse)
              if (Array.isArray(images)) { // 图片处理
                for (let i = 0; i < images.length; i++) {
                  this.data_small.push({images: images[i]})
                }
                this.data.min = this.data_small[0].images
              } else {
                this.data_small.push({images})
                this.data.min = this.data_small[0].images
              }
              this.product_information = skuse
              for (let a = 0; a < this.product_information.length; a++) { // 产品种类
                this.$set(this.product_information[a], 'add_number', 0)
              }
              let productDetailse = datas.product_details
              if (Array.isArray(productDetailse)) { // 商品介绍
                let Html = ''
                for (let s = 0; s < productDetailse.length; s++) {
                  if (productDetailse[s].p800 !== '' || productDetailse[s].p800 !== undefined || productDetailse[s].p800 !== null) {
                    Html += '<img src=" ' + productDetailse[s].p800 + ' " alt>'
                  } else if (productDetailse[s].p500 !== '' || productDetailse[s].p500 !== undefined || productDetailse[s].p500 !== null) {
                    Html += '<img src=" ' + productDetailse[s].p500 + ' " alt>'
                  } else {
                    Html += '<img src=" ' + productDetailse.srcfile + ' " alt>'
                  }
                }
                this.LibraryOfGoodsIndex_The_introduction = Html
              } else {
                if (productDetailse.p800 === '' || productDetailse.p800 === undefined || productDetailse.p800 === null) {
                  this.LibraryOfGoodsIndex_The_introduction = '<img src=" ' + productDetailse.srcfile + ' " alt>'
                } else if (productDetailse.p500 === '' || productDetailse.p500 === undefined || productDetailse.p500 === null) {
                  this.LibraryOfGoodsIndex_The_introduction = '<img src=" ' + productDetailse.p800 + ' " alt>'
                } else if (productDetailse.srcfile === '' || productDetailse.srcfile === undefined || productDetailse.srcfile === null) {
                  this.LibraryOfGoodsIndex_The_introduction = '<img src=" ' + productDetailse.p500 + ' " alt>'
                } else {
                  this.LibraryOfGoodsIndex_The_introduction = '<img src=" ' + productDetailse + ' " alt>'
                }
              }
              if (datas.follow === 0) {
                this.like_Value_Show = false
                this.Pay_attention_this_text = '关注商品'
              } else if (datas.follow === 1) {
                this.like_Value_Show = true
                this.Pay_attention_this_text = '已关注商品'
              }
              this.like_Value_Show_length = datas.follows
              this.titles = datas.name
            } else {
              this.$Message.error(metas.message)
            }
            this.particulars_loading = false
          })
          .catch((res) => {
            this.$Message.error(res.message)
            this.particulars_loading = false
          })
        }
      },
      created: function () {
        const self = this
        const id = this.$route.params.id
        self.ShoopingId = id
        this.pushs()
        this.Add_the_initial()
      },
      mounted () {

      },
      watch: {}
    }
</script>

<style scoped>
  .CommodityDetailsIndex_center{
    margin: 0 auto;
    clear: both;
    width: 1180px;
    min-width: 1180px;
    max-width: 1180px;
    position: relative;
  }
  .LibraryOfGoodsIndex_search_box{
    margin: 5px 0 5px 0;
    height: 37px;
    width: 216px;
    overflow: hidden;
    float: right;
  }
  .LibraryOfGoodsIndex_search_box div.search_box{
    width: 100px;
    height: 38px;
    float: right;
    background: #ED3A4A;
    color: #fff;
    line-height: 38px;
    font-size: 16px;
    text-align: center;
  }
  .LibraryOfGoodsIndex_search_box div.search_box_search{
    float: left;
    width: 214px;
  }
  .LibraryOfGoodsIndex_search_box div.search_box_search input{
    border: 0;
  }
  .LibraryOfGoodsIndex_center{
    width: 1180px;
    margin-top: 32px;
    clear: both;
  }
  .LibraryOfGoodsIndex_center_headers{
    width: 1180px;
    height: 46px;
    clear: both;
  }
  .LibraryOfGoodsIndex_center_title{
    width: 960px;
    padding: 10px 20px;
    padding-left: 0;
    float: left;
  }
  .LibraryOfGoodsIndex_center_title p{
    font-size: 20px;
    line-height: 26px;
    text-align: left;
  }
  .LibraryOfGoodsIndex_center_content{
    width: 1180px;
    margin: 22px 0 10px 0;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_carousel{
    width: 420px;
    float: left;
    margin-right: 25px;
    position: relative;
  }
  .LibraryOfGoodsIndex_center_content_carousel_ceter{
    width: 420px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_like{
    max-width: 420px;
    min-width: 50px;
    height: 30px;
    line-height: 30px;
    float: left;
    vertical-align:middle;
    position: absolute;
    left: 50%;
    bottom: -15px;
    transform: translate(-50%,-50%);
  }
  .LibraryOfGoodsIndex_center_content_like img{
    width: 19px;
    height: 17px;
    margin: 7px 5px 6px 0;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_like i{
    margin-right: 5px;
  }
  .LibraryOfGoodsIndex_center_content_like i,.LibraryOfGoodsIndex_center_content_like span{
    font-size: 15px;
    display: inline-block;
    line-height: 32px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_bigimg{
    width: 420px;
    height: 420px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_bigimg_none{
    width: 420px;
    height: 420px;
    background: #ccc;
  }
  .LibraryOfGoodsIndex_center_content_bigimg_none img{
    width: 420px;
    height: 420px;
  }
  .LibraryOfGoodsIndex_center_content_bigimg img{
    width: 420px;
    height: 420px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_samll{
    margin-top: 25px;
    float: left;
    width: 420px;
    min-height: 76px;
    margin-bottom: 27px;
  }
  .LibraryOfGoodsIndex_center_content_samll ul{
    width: 420px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_samll ul li{
    width: 69px;
    height: 69px;
    margin-right: 15px;
    margin-bottom: 15px;
    float: left;
    border: 1px solid #fff;
  }
  .LibraryOfGoodsIndex_center_content_samll ul li.actives{
    border: 1px solid #ED3A4A;
  }
  .LibraryOfGoodsIndex_center_content_samll ul li img{
    width: 67px;
    height: 67px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_centers{
    width: 735px;
    float: right;
    min-height: 598px;
    max-height: 665px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selection{
    width: 735px;
    min-height: 503px;
    max-height: 570px;
    overflow-y: auto;
    overflow-x: hidden;
    float: right;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selection::-webkit-scrollbar {
    width: 4px;
    height: 4px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selection::-webkit-scrollbar-thumb {
    border-radius: 5px;
    -webkit-box-shadow: inset 0 0 5px rgba(0,0,0,0.15);
    background: rgba(0,0,0,0.15);
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selection::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 5px #cccccc;
    border-radius: 0;
    background: #c8c8c8;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectionnone{
    width: 735px;
    height: 503px;
    font-size: 18px;
    text-align: center;
    line-height: 503px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectioncenter{
    width: 726px;
    height: 152px;
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    clear: both;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectiontitle{
    width: 726px;
    height: 30px;
    line-height: 30px;
    font-size: 14px;
    text-align: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_leftwholesale{
    width: 435px;
    height: 120px;
    float: left;
    border: 1px solid rgba(240,240,240,1);
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice{
    width: 434px;
    height: 59px;
    border-bottom: 1px solid rgba(240,240,240,1);
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice ul{
    width: 434px;
    height: 59px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice ul li{
    width: 115px;
    float: left;
    font-size: 18px;
    height: 59px;
    color: #ED3A4A;
    text-align: center;
    line-height: 59px;
    font-weight: 500;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice ul li.wholesale_li{
    width: 87px;
    font-size: 14px;
    text-align: left;
    padding-left: 22px;
    font-weight: 400;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch{
    width: 434px;
    height: 60px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch ul{
    width: 434px;
    height: 60px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch ul li{
    width: 115px;
    float: left;
    font-size: 14px;
    height: 59px;
    text-align: center;
    line-height: 59px;
    font-weight: 500;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch ul li.Thebatch_li{
    width: 87px;
    font-size: 14px;
    text-align: left;
    padding-left: 22px;
    font-weight: 400;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory{
    width: 291px;
    height: 120px;
    padding-right: 22px;
    border: 1px solid rgba(240,240,240,1);
    border-left: 0;
    float: right;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_maxquantity{
    width: 134px;
    height: 120px;
    text-align: center;
    line-height: 120px;
    float: left;
    font-size: 14px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping{
    width: 134px;
    height: 120px;
    float: right;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul{
    width: 110px;
    height: 30px;
    margin: 45px 23px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li{
    width: 110px;
    height: 30px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li span{
    width: 29px;
    height: 28px;
    display: inline-block;
    font-size: 26px;
    border: 1px solid rgba(240,240,240,1);
    text-align: center;
    line-height: 28px;
    float: left;
    color: #999;
    cursor:pointer;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li span img{
    width: 22px;
    height: 22px;
    vertical-align:middle;
    margin: 4px 4px 4px 3px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li span.left_span{
    border-right: 0;
    line-height: 22px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li span.left_span img{
    width: 18px;
    height: 10px;
    vertical-align: middle;
    margin: 8px 4px 8px 5px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li span.right_span{
    border-left: 0;
    line-height: 26px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li span.right_span img{
    width: 16px;
    height: 16px;
    vertical-align: middle;
    margin: 5px 6px 5px 6px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li input{
    width: 52px;
    height: 28px;
    border: 1px solid rgba(240,240,240,1);
    float: left;
    border-radius: 0;
    padding: 4px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li input:focus{
    border: 1px solid rgba(240,240,240,1);
    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li div{
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_ok{
    margin: 54px 196px 0 196px;
    width: 345px;
    height: 36px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_ok .Button{
    width: 150px;
    height: 36px;
    font-size: 14px;
  }
  .LibraryOfGoodsIndex_center_content_ok .Button_left{
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_ok .Button_right{
    float: right;
  }
  .LibraryOfGoodsIndex_center_The_introduction{
    width: 1180px;
    margin-top: 46px;
    clear: both;
  }
  .LibraryOfGoodsIndex_The_introduction_title{
    width: 1180px;
    padding: 10px 20px;
    background:rgba(240,240,240,1);
  }
  .LibraryOfGoodsIndex_The_introduction_title p{
    font-size: 16px;
    line-height: 26px;
    text-align: left;
  }
  .LibraryOfGoodsIndex_The_introduction_center{
    width: 1180px;
    border: 1px solid rgba(240,240,240,1);
    border-top: 0;
    margin-bottom: 46px;
  }
  .LibraryOfGoodsIndex_The_introduction_center_none{
    height: 100px;
    line-height: 100px;
    width: 1178px;
    font-size: 18px;
    text-align: center;
  }
  .LibraryOfGoodsIndex_The_introduction_center_content{
    min-height: 100px;
    width: 1178px;
  }
  .LibraryOfGoodsIndex_The_introduction_center_content >>> img{
    max-width: 1178px;
    margin: 0 auto;
    position: relative;
    left: 50%;
    transform: translate(-50%);
  }
</style>
