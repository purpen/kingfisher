<template>
  <div class="myReceiptIndex_center">
    <Row :gutter="20" type="flex" justify="center">
      <Spin fix v-if="myReceiptIndex_loading" class="posi_fix"></Spin>
      <Col span="24">
        <div class="myReceiptIndexHeader_center">
          <div class="myReceiptIndexHeader_center_title">
            <p>全部商品 ({{titles_number}})</p>
          </div>
          <div class="myReceiptIndexHeader_search_box">
            <Input v-model="searchBoxValue" placeholder="商品名称" class="search_box_search" @on-keydown.13="searchBox_Value">
            <Icon type="ios-search" slot="suffix" :loading="myReceiptIndex_loading" @click.active="searchBox_Value" />
            </Input>
          </div>
        </div>
      </Col>
      <Col span="24">
      <div class="myReceiptIndexcenter_list_title">
        <ul>
          <li class="check_all_li check_all_handleCheckAll">
            <Checkbox
              v-model="checkAll"
              @click.prevent.native="handleCheckAll">全选</Checkbox>
          </li>
          <li class="commodity_li">商品</li>
          <li class="price_li">单价</li>
          <li class="munber_li">数量</li>
          <li class="subtotal_li">小计</li>
          <li class="operation_li">操作</li>
        </ul>
      </div>
      </Col>
      <Col span="24">
        <div class="myReceiptIndexcenter_list_center">
          <div class="myReceiptIndexcenter_list_centerNumber">
            <div class="check_all_div check_all_div_Checkbox">
              <Checkbox></Checkbox>
            </div>
            <div class="commodity_div">
              <img src="//goss2.vcg.com/creative/vcg/400/version23/VCG21ce2bc7a29.jpg" alt="">
              <p>商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称商品名称</p>
              <p class="specification_p">黑色</p>
            </div>
            <div class="price_div">
              &#165;&nbsp;19999
            </div>
            <div class="munber_div">
              <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping">
                <ul>
                  <li>
                    <span class="left_span" @click="remove_number(index)"><img src="../../assets/images/details/icon-jian.png" alt=""></span>
                    <input
                      type="text"
                      v-model="add_number"
                      @change="amount_change(index)"
                    >
                    <span class="right_span" @click="adds_number(index)"><img src="../../assets/images/details/icon-ad.png" alt=""></span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="subtotal_div">
              &#165;&nbsp;100000000
            </div>
          </div>
        </div>
      </Col>
      <Col span="24">
      <div v-for="(titlese,index) in titles" :key="index" :class="titlese.state ? 'active' : ''">
          <Checkbox v-model="titlese.state" @click.native="Checkbox_click(index)">
          </Checkbox>
      </div>
      </Col>
    </Row>
  </div>
</template>

<script>
    export default {
      name: 'myReceiptIndex',
      data () {
        return {
          Bus: this.$BusFactory(this),
          myReceiptIndex_loading: false, // 页面加载loding
          myReceiptIndexId: '', // 判断是否从立即购买进来0不是1是
          searchBoxValue: '', // 搜索框数据
          titles_number: 0, // 进货单商品数量
          social: [],
          titles: [
            {state: false, ids: 0, number: 1},
            {state: false, ids: 0, number: 1},
            {state: false, ids: 0, number: 1},
            {state: false, ids: 0, number: 1}
          ],
          checkAll: false,
          add_number: ''
        }
      },
      components: {},
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
          // 我的订单页面返回商品库界面搜索
        },
        handleCheckAll () {
          if (this.checkAll === false) {
            for (let i = 0; i < this.titles.length; i++) {
              this.titles[i].state = true
            }
            this.checkAll = true
          } else {
            for (let i = 0; i < this.titles.length; i++) {
              this.titles[i].state = false
            }
            this.checkAll = false
          }
        },
        Checkbox_click (index) {
          if (this.titles[index].state === false) {
            this.titles[index].state = true
          } else {
            this.titles[index].state = false
          }
          let Check = []
          for (let i = 0; i < this.titles.length; i++) {
            if (this.titles[i].state === true) {
              Check.push({state: this.titles[i].state})
            }
          }
          console.log(Check)
          if (this.titles.length === Check.length) {
            this.checkAll = true
          } else {
            this.checkAll = false
          }
        },
        remove_number (e) {

        },
        adds_number (e) {

        },
        amount_change (e) {

        }
      },
      created: function () {
        const self = this
        const id = this.$route.params.id
        self.myReceiptIndexId = id
      },
      mounted () {

      },
      watch: {}
    }
</script>

<style scoped>
  .myReceiptIndex_center{
    margin: 0 auto;
    clear: both;
    width: 1180px;
    min-width: 1180px;
    max-width: 1180px;
    position: relative;
  }
  .myReceiptIndexHeader_center{
    width: 1180px;
    margin-top: 20px;
    height: 36px;
    margin-bottom: 14px;
    clear: both;
  }
  .myReceiptIndexHeader_centerp{
    width: 1180px;
    height: 36px;
    clear: both;
  }
  .myReceiptIndexHeader_center_title{
    width: 960px;
    padding: 5px 20px;
    padding-left: 0;
    float: left;
  }
  .myReceiptIndexHeader_center_title p{
    font-size: 14px;
    line-height: 26px;
    text-align: left;
    color: rgba(237,58,74,1);
  }
  .myReceiptIndexHeader_search_box{
    margin: 5px 0 5px 0;
    height: 37px;
    width: 216px;
    overflow: hidden;
    float: right;
  }
  .myReceiptIndexHeader_search_box div.search_box{
    width: 100px;
    height: 38px;
    float: right;
    background: #ED3A4A;
    color: #fff;
    line-height: 38px;
    font-size: 16px;
    text-align: center;
  }
  .myReceiptIndexHeader_search_box div.search_box_search{
    float: left;
    width: 214px;
  }
  .myReceiptIndexHeader_search_box div.search_box_search input{
    border: 0;
  }
  .myReceiptIndexcenter_list_title{
    width: 1180px;
    height: 36px;
    background:rgba(240,240,240,1);
    clear: both;
  }
  .myReceiptIndexcenter_list_title ul{
    width: 1180px;
    height: 36px;
    float: left;
  }
  .myReceiptIndexcenter_list_title ul li{
    float: left;
    height: 36px;
    padding: 0 10px;
    font-size:14px;
    line-height: 36px;
    text-align: center;
  }
  .myReceiptIndexcenter_list_title ul li.check_all_li{
    width: 76px;
    text-align: left;
  }
  .myReceiptIndexcenter_list_title ul li.commodity_li{
    width: 484px;
  }
  .myReceiptIndexcenter_list_title ul li.price_li{
    width: 120px;
  }
  .myReceiptIndexcenter_list_title ul li.munber_li{
    width: 170px;
  }
  .myReceiptIndexcenter_list_title ul li.subtotal_li{
    width: 190px;
  }
  .myReceiptIndexcenter_list_title ul li.operation_li{
    width: 120px;
  }
  .myReceiptIndexcenter_list_center{
    width: 1080px;
    clear: both;
  }
  .myReceiptIndexcenter_list_centerNumber{
    width: 1180px;
    height: 144px;
    border: 1px solid #fff;
    border-bottom: 0;
    float: left;
  }
  .myReceiptIndexcenter_list_centerNumber:last-child{
    border-bottom: 1px solid #fff;
  }
  .myReceiptIndexcenter_list_centerNumber.list_centerNumber{
    border: 1px solid #ED3A4A;
    border-bottom: 0;
  }
  .myReceiptIndexcenter_list_centerNumber.list_centerNumber:last-child{
    border-bottom: 1px solid #ED3A4A;
  }
  .myReceiptIndexcenter_list_centerNumber .check_all_div{
    width: 76px;
    height: 144px;
    line-height: 142px;
    float: left;
    padding: 0 10px;
  }
  .myReceiptIndexcenter_list_centerNumber .commodity_div{
    width: 484px;
    height: 144px;
    float: left;
    padding: 0 10px;
  }
  .myReceiptIndexcenter_list_centerNumber .commodity_div img{
    float: left;
    width: 80px;
    height: 80px;
    margin: 32px 16px 32px 0;
  }
  .myReceiptIndexcenter_list_centerNumber .commodity_div p{
    width: 215px;
    height: 70px;
    font-size:12px;
    line-height: 16px;
    margin: 37px 0;
    float: left;
  }
  .myReceiptIndexcenter_list_centerNumber .commodity_div p.specification_p{
    width: 130px;
    margin: 62px 0 62px 22px;
    font-size:12px;
    line-height: 20px;
    height: 20px;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .myReceiptIndexcenter_list_centerNumber .price_div{
    width: 120px;
    padding: 0 10px;
    float: left;
    height: 144px;
    text-align: center;
    font-size: 14px;
    line-height: 142px;
  }
  .myReceiptIndexcenter_list_centerNumber .munber_div{
    width: 170px;
    padding: 0 10px;
    float: left;
    height: 144px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping{
    width: 150px;
    height: 120px;
    float: right;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul{
    width: 126px;
    height: 30px;
    margin: 57px 11px;
    float: left;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li{
    width: 126px;
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
    width: 67px;
    height: 28px;
    border: 1px solid rgba(240,240,240,1);
    float: left;
    border-radius: 0;
    padding: 4px;
    font-size: 14px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li input:focus{
    border: 1px solid rgba(240,240,240,1);
    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
  }
  .LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping ul li div{
    float: left;
  }
  .myReceiptIndexcenter_list_centerNumber .subtotal_div{
    width: 190px;
    padding: 0 10px;
    float: left;
    height: 144px;
    font-size: 14px;
    text-align: center;
    line-height: 144px;
  }
  .myReceiptIndexcenter_list_centerNumber .operation_div{
    width: 120px;
    padding: 0 10px;
    height: 144px;
    float: left;
  }
  .active{
    background: #000;
  }
</style>
