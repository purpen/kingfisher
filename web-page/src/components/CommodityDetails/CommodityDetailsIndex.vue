<template>
  <div class="CommodityDetailsIndex_center">
    <Row :gutter="20" type="flex" justify="center">
      <Spin fix v-if="particulars_loading" class="posi_fix"></Spin>
      <Col span="24">
        <div class="LibraryOfGoodsIndex_search_box">
          <Input v-model="searchBoxValue" placeholder="搜索商品名称" class="search_box_search" />
          <Button type="primary" :loading="search_box_loading" class="search_box" @click="searchBox_Value">搜索</Button>
        </div>
      </Col>
      <Col span="24">
        <div class="LibraryOfGoodsIndex_center">
          <div class="LibraryOfGoodsIndex_center_title">
            <p>{{titles}}</p>
          </div>
          <div class="LibraryOfGoodsIndex_center_content">
            <div class="LibraryOfGoodsIndex_center_content_carousel">
                <div class="LibraryOfGoodsIndex_center_content_carousel_ceter">
                  <div class="LibraryOfGoodsIndex_center_content_bigimg" v-if="data.min">
                    <!--<img-Zoom :previewImg="data.min" :zoomImg="data.max"></img-Zoom>-->
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
                      @mouseover="page_index_change(index,data_smalls.min,data_smalls.max)"
                      v-if="data_smalls.min"
                    >
                      <img :src="data_smalls.min" alt="">
                    </li>
                    <li v-else @mouseover="page_index_change(index,'','')">
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
            <div class="LibraryOfGoodsIndex_center_content_merchandise_selection">
              <Spin fix v-if="particulars_loading" class="posi_fix"></Spin>
              <div class="LibraryOfGoodsIndex_center_content_merchandise_selectionnone" v-if="product_information.length<=0">
                暂无数据
              </div>
              <div v-else class="LibraryOfGoodsIndex_center_content_merchandise_selectioncenter" v-for="(product_informations, index) in product_information" :key="index">
                <div class="LibraryOfGoodsIndex_center_content_merchandise_selectiontitle">
                  产品规格: &nbsp;{{product_informations.specification}}
                </div>
                <div class="LibraryOfGoodsIndex_center_content_merchandise_leftwholesale">
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice">
                    <ul>
                      <li class="wholesale_li">起&nbsp;批&nbsp;价:</li>
                      <li v-for="(prices, indexs) in product_informations.price" :key="indexs">&#165;&nbsp;{{prices.concrete_price}}</li>
                    </ul>
                  </div>
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_Thebatch">
                    <ul>
                      <li class="Thebatch_li">起&nbsp;批&nbsp;量:</li>
                      <li v-for="(numberser, indexs) in product_informations.numbers" :key="indexs">
                        {{numberser.concrete_number_min}}-{{numberser.concrete_number_max}}个
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory">
                  <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory_maxquantity">
                    {{product_informations.max_inventory_data}}个可售
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
      </Col>
      <Col span="24">
        <div class="LibraryOfGoodsIndex_center_The_introduction">
          <div class="LibraryOfGoodsIndex_The_introduction_title">
            <p>商品介绍</p>
          </div>
          <div class="LibraryOfGoodsIndex_The_introduction_center">
            <div class="LibraryOfGoodsIndex_The_introduction_center_none" v-if="LibraryOfGoodsIndex_The_introduction.length<=0">
              暂无数据
            </div>
            <div class="LibraryOfGoodsIndex_The_introduction_center_content" v-else>

            </div>
          </div>
        </div>
      </Col>
    </Row>
  </div>
</template>

<script>
    import imgZoom from '@/components/CommodityDetails/CommodityDetailsIndexBigimg'
    export default {
      name: 'CommodityDetailsIndex',
      data () {
        return {
          Bus: this.$BusFactory(this),
          titles: '夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气1', // 商品标题
          ShoopingId: '', // 商品id
          search_box_loading: false, // 搜素防止误触发
          searchBoxValue: '', // 搜索框数据
          like_Value_Show: false, // 关注商品
          like_Value_Show_length: 10, // 关注商品人数
          Pay_attention_this_text: '关注商品', // 关注商品文字
          data: { // 图片放大镜查看大的是小的两倍
            min: '',
            max: ''
          },
          data_small: [], // 小图标
          page_index: 0, // 小图标切换大图标
          particulars_loading: true, // 页面lodaing
          product_information: [ // 产品选择信息
            {
              specification: '蓝色',
              price: [
                {concrete_price: 69000},
                {concrete_price: 10800},
                {concrete_price: 9000}
              ],
              numbers: [
                {concrete_number_min: 1, concrete_number_max: 10},
                {concrete_number_min: 10, concrete_number_max: 100},
                {concrete_number_min: 100, concrete_number_max: 1000}
              ],
              max_inventory_data: 10000,
              add_number: 0,
              product_ids: '225001213'
            },
            {
              specification: '黄色',
              price: [
                {concrete_price: 6900},
                {concrete_price: 1080},
                {concrete_price: 900}
              ],
              numbers: [
                {concrete_number_min: 1, concrete_number_max: 10},
                {concrete_number_min: 10, concrete_number_max: 100},
                {concrete_number_min: 100, concrete_number_max: 1000}
              ],
              max_inventory_data: 1000,
              add_number: 0,
              product_ids: '323eq'
            },
            {
              specification: '黑色',
              price: [
                {concrete_price: 6000},
                {concrete_price: 1800},
                {concrete_price: 90}
              ],
              numbers: [
                {concrete_number_min: 1, concrete_number_max: 10},
                {concrete_number_min: 10, concrete_number_max: 100},
                {concrete_number_min: 100, concrete_number_max: 1000}
              ],
              max_inventory_data: 100000,
              add_number: 0,
              product_ids: '535d'
            },
            {
              specification: '灰色',
              price: [
                {concrete_price: 600},
                {concrete_price: 100},
                {concrete_price: 90}
              ],
              numbers: [
                {concrete_number_min: 1, concrete_number_max: 10},
                {concrete_number_min: 10, concrete_number_max: 100},
                {concrete_number_min: 100, concrete_number_max: 1000}
              ],
              max_inventory_data: 100,
              add_number: 0,
              product_ids: '2ddd13'
            }
          ], // 货品
          Button_left_loding: false, // 进货单等待
          Button_left_disabled: false, // 进货单禁用
          Button_right_loding: false, // 立即购买等待
          Button_right_disabled: false, // 立即购买禁用
          LibraryOfGoodsIndex_The_introduction: [] // 商品介绍
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
          if (this.like_Value_Show === true) {
            this.$Message.success('取消关注成功')
            this.like_Value_Show = false
            this.Pay_attention_this_text = '关注商品'
            if (this.like_Value_Show_length === 0) {
              this.like_Value_Show_length = 0
            } else {
              this.like_Value_Show_length--
            }
          } else {
            this.$Message.success('关注成功')
            this.like_Value_Show = true
            this.Pay_attention_this_text = '已关注商品'
            this.like_Value_Show_length++
          }
        },
        page_index_change (index, smallImg, bigImg) {
          this.page_index = index
          this.data.min = smallImg
          this.data.max = bigImg
        },
        pushs () { // 模拟请求
          this.data_small.push(
            {
              min: 'https://img.alicdn.com/imgextra/i3/2857774462/TB21fgcwwNlpuFjy0FfXXX3CpXa_!!2857774462.jpg'
            },
            {
              min: 'https://gd4.alicdn.com/imgextra/i4/1642570643/TB25JlBk5CYBuNkSnaVXXcMsVXa_!!1642570643.jpg_400x400.jpg_.webp'
            },
            {
              min: 'https://gd2.alicdn.com/imgextra/i2/1642570643/TB2bew.kRyWBuNkSmFPXXXguVXa_!!1642570643.jpg_400x400.jpg_.webp'
            },
            {
              min: 'https://img.alicdn.com/imgextra/i3/2857774462/TB21fgcwwNlpuFjy0FfXXX3CpXa_!!2857774462.jpg_430x430q90.jpg'
            },
            {
              min: 'https://gd4.alicdn.com/imgextra/i4/1642570643/TB25JlBk5CYBuNkSnaVXXcMsVXa_!!1642570643.jpg_400x400.jpg_.webp'
            },
            {
              min: '',
              max: ''
            }
          )
          this.data.min = this.data_small[0].min
          this.data.max = this.data_small[0].max
          let _this = this
          setTimeout(function () {
            _this.particulars_loading = false
          }, 2000)
        },
        amount_change (e) { // 输入框规则
          this.product_information[e].add_number = this.product_information[e].add_number.replace(/^[0]+[0-9]*$/gi, '')
          this.product_information[e].add_number = this.product_information[e].add_number.replace(/[^\d]/g, '')
          if (this.product_information[e].add_number === '' || this.product_information[e].add_number === null || this.product_information[e].add_number === undefined) {
            this.product_information[e].add_number = 0
          } else if (this.product_information[e].add_number >= this.product_information[e].max_inventory_data) {
            this.product_information[e].add_number = this.product_information[e].max_inventory_data
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
          if (this.product_information[e].add_number >= this.product_information[e].max_inventory_data) {
            this.product_information[e].add_number = this.product_information[e].max_inventory_data
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
              let Replenish = {add_number: this.product_information[i].add_number, product_ids: this.product_information[i].product_ids}
              Arrays.push(Replenish)
              this.product_information[i].add_number = 0
            }
          }
          let _this = this
          if (Arrays.length === 0) {
            this.$Message.warning('请先添加购买的商品,再加入进货单')
          } else {
            this.Button_left_loding = true
            this.Button_right_disabled = true
            setTimeout(function () {
              _this.Button_left_loding = false
              _this.Button_right_disabled = false
              _this.$Message.success('加入进货单成功')
              _this.$store.commit('THE_SHOPPING_CART_LENGTH_THEBACKGROUND', Arrays.length)
            }, 2000)
          }
        },
        Buy_now () {
          let Arrays = []
          for (let i = 0; i < this.product_information.length; i++) {
            if (this.product_information[i].add_number === 0) {
              this.product_information[i].add_number = 0
            } else {
              let Replenish = {add_number: this.product_information[i].add_number, product_ids: this.product_information[i].product_ids}
              Arrays.push(Replenish)
              this.product_information[i].add_number = 0
            }
          }
          let _this = this
          if (Arrays.length === 0) {
            this.$Message.warning('请先添加购买的商品,再进行购买操作')
          } else {
            this.Button_right_loding = true
            this.Button_left_disabled = true
            setTimeout(function () {
              _this.Button_right_loding = false
              _this.Button_left_disabled = false
              _this.$Message.success('订单发送成功')
              _this.$store.commit('THE_ORDER_SHOPPING_CART_IDS_GLOBAL', '121313')
            }, 2000)
          }
        }
      },
      created: function () {
        const self = this
        const id = this.$route.params.id
        self.ShoopingId = id
        this.pushs()
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
    width: 1070px;
    min-width: 1070px;
    max-width: 1070px;
    position: relative;
  }
  .LibraryOfGoodsIndex_search_box{
    margin-top: 38px;
    height: 37px;
    width: 489px;
    border: 1px solid rgba(102,102,102,1);
    border-radius:10px;
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
    width: 385px;
  }
  .LibraryOfGoodsIndex_center{
    width: 1070px;
    margin-top: 30px;
    clear: both;
  }
  .LibraryOfGoodsIndex_center_title{
    width: 1068px;
    padding: 10px 20px;
    background:rgba(240,240,240,1);
  }
  .LibraryOfGoodsIndex_center_title p{
    font-size: 20px;
    line-height: 26px;
    text-align: left;
  }
  .LibraryOfGoodsIndex_center_content{
    width: 1020px;
    margin: 25px 24px 10px 24px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_carousel{
    width: 380px;
    float: left;
    margin-right: 10px;
    position: relative;
  }
  .LibraryOfGoodsIndex_center_content_carousel_ceter{
    width: 380px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_like{
    max-width: 380px;
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
    width: 380px;
    height: 380px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_bigimg_none{
    width: 380px;
    height: 380px;
    background: #ccc;
  }
  .LibraryOfGoodsIndex_center_content_bigimg_none img{
    width: 380px;
    height: 380px;
  }
  .LibraryOfGoodsIndex_center_content_bigimg img{
    width: 380px;
    height: 380px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_samll{
    margin-top: 20px;
    float: left;
    width: 380px;
    min-height: 76px;
    margin-bottom: 27px;
  }
  .LibraryOfGoodsIndex_center_content_samll ul{
    width: 380px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_samll ul li{
    width: 64px;
    height: 64px;
    margin-right: 10px;
    margin-bottom: 10px;
    float: left;
    border: 1px solid #fff;
  }
  .LibraryOfGoodsIndex_center_content_samll ul li.actives{
    border: 1px solid #ED3A4A;
  }
  .LibraryOfGoodsIndex_center_content_samll ul li img{
    width: 62px;
    height: 62px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selection{
    width: 630px;
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
    width: 620px;
    height: 503px;
    font-size: 18px;
    text-align: center;
    line-height: 503px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectioncenter{
    width: 618px;
    border: 1px solid rgba(240,240,240,1);
    height: 145px;
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    clear: both;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectiontitle{
    width: 618px;
    height: 25px;
    line-height: 25px;
    background: rgba(240,240,240,1);
    padding: 0 15px;
    font-size: 14px;
    text-align: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_leftwholesale{
    width: 369px;
    height: 120px;
    float: left;
    border-right: 1px solid rgba(240,240,240,1);
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice{
    width: 369px;
    height: 59px;
    border-bottom: 1px solid rgba(240,240,240,1);
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice ul{
    width: 369px;
    height: 59px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice ul li{
    width: 96px;
    float: left;
    font-size: 18px;
    height: 59px;
    color: #ED3A4A;
    text-align: center;
    line-height: 59px;
    font-weight: 500;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_wholesaleprice ul li.wholesale_li{
    width: 80px;
    font-size: 14px;
    text-align: left;
    padding-left: 15px;
    font-weight: 400;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch{
    width: 369px;
    height: 60px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch ul{
    width: 369px;
    height: 60px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch ul li{
    width: 96px;
    float: left;
    font-size: 14px;
    height: 59px;
    text-align: center;
    line-height: 59px;
    font-weight: 500;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_Thebatch ul li.Thebatch_li{
    width: 80px;
    font-size: 14px;
    text-align: left;
    padding-left: 15px;
    font-weight: 400;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory{
    width: 246px;
    height: 120px;
    padding-right: 15px;
    float: right;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_maxquantity{
    width: 115px;
    height: 120px;
    text-align: center;
    line-height: 120px;
    float: left;
    font-size: 14px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping{
    width: 115px;
    height: 120px;
    float: right;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul{
    width: 105px;
    height: 30px;
    margin: 45px 5px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li{
    width: 105px;
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
    width: 47px;
    height: 28px;
    border: 1px solid rgba(240,240,240,1);
    float: left;
    border-radius: 0;
    padding: 4px 3px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li input:focus{
    border: 1px solid rgba(240,240,240,1);
    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li div{
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_ok{
    margin: 15px 115px 0 524px;
    width: 405px;
    height: 40px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_ok .Button{
    width: 190px;
    height: 40px;
  }
  .LibraryOfGoodsIndex_center_content_ok .Button_left{
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_ok .Button_right{
    float: right;
  }
  .LibraryOfGoodsIndex_center_The_introduction{
    width: 1070px;
    margin-top: 60px;
    clear: both;
  }
  .LibraryOfGoodsIndex_The_introduction_title{
    width: 1068px;
    padding: 10px 20px;
    background:rgba(240,240,240,1);
  }
  .LibraryOfGoodsIndex_The_introduction_title p{
    font-size: 16px;
    line-height: 26px;
    text-align: left;
  }
  .LibraryOfGoodsIndex_The_introduction_center{
    width: 1020px;
    margin: 25px 24px 10px 24px;
    float: left;
  }
  .LibraryOfGoodsIndex_The_introduction_center_none{
    height: 100px;
    line-height: 100px;
    width: 1020px;
    float: left;
    font-size: 18px;
    text-align: center;
  }
  .LibraryOfGoodsIndex_The_introduction_center_content{
    min-height: 100px;
    width: 1020px;
    float: left;
  }
</style>
