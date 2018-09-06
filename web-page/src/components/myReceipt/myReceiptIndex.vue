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
              :indeterminate="indeterminate"
              :value="checkAll"
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
      <Col span="24" v-if="commodity_list_my.length <= 0">
      <div class="LibraryOfGoodsList_notList">
        <img src="../../assets/images/empty-data.png" alt="">
      </div>
      </Col>
      <Col span="24" v-else>
        <Spin v-show="myReceiptIndexcenter_list_center_loading" fix></Spin>
        <div class="myReceiptIndexcenter_list_center">
          <div class="myReceiptIndexcenter_list_centerNumber"
             v-for="(commodity_list_mys, index) in commodity_list_my"
             :key="index"
             :class="commodity_list_mys.status ? 'list_centerNumber' : ''"
          >
            <div class="check_all_div check_all_div_Checkbox">
              <CheckboxGroup v-model="fruitIds" @on-change="checkAllGroupChange">
                <Checkbox
                  :label="commodity_list_mys.id"
                  @click.native="addClasse(index)"
                ></Checkbox>
                <!--v-model="commodity_list_mys.status"-->
                  <!--@click.native="Checkbox_click(index)"-->
              </CheckboxGroup>
            </div>
            <div class="commodity_div" @click="entrance_particulars(commodity_list_mys.product_id)">
              <img :src="commodity_list_mys.cover_url" alt="">
              <p>{{commodity_list_mys.product_name}}</p>
              <p class="specification_p">{{commodity_list_mys.mode}}</p>
            </div>
            <div class="price_div">
              &#165;&nbsp;{{Number(commodity_list_mys.price).toFixed(2)}}
            </div>
            <div class="munber_div">
              <div class="LibraryOfGoodsIndex_center_content_merchandise_inventory_overlapping">
                <ul>
                  <li>
                    <span class="left_span" @click="remove_number(index)"><img src="../../assets/images/details/icon-jian.png" alt=""></span>
                    <input
                      type="text"
                      v-model="commodity_list_mys.number"
                      @change="amount_change(index)"
                    >
                    <span class="right_span" @click="adds_number(index)"><img src="../../assets/images/details/icon-ad.png" alt=""></span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="subtotal_div">
              &#165;&nbsp;{{Number(commodity_list_mys.price_once).toFixed(2)}}
            </div>
            <div class="operation_div">
              <ul>
                <li>
                  <span @click="delete_single(index)">删除</span>
                </li>
                <li>
                  <span v-if="commodity_list_mys.focus===0" @click="focus_onclick_this(index)">加入到我的关注</span>
                  <span v-else-if="commodity_list_mys.focus===1">已关注</span>
                  <span v-else>已关注</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="myReceiptIndexcenter_list_close_footer">
          <div class="check_all_div_footer check_all_handleCheckAll">
            <Checkbox
              :indeterminate="indeterminate"
              :value="checkAll"
              @click.prevent.native="handleCheckAll">全选</Checkbox>
          </div>
          <div class="clear_my_purchase_list">
            <span @click="ckear_checkall_shopping()">删除选中的商品</span>
          </div>
          <div class="empty_purchase_list">
            <span @click="empty_purchase_order">清空进货单</span>
          </div>
          <div class="close_an_account">
            <Button type="primary" :loading="close_an_account_loading">去结算</Button>
          </div>
          <div class="total_prices">
            总价&nbsp;:&nbsp;&nbsp;<span>&#165;&nbsp;{{Number(total_prices).toFixed(2)}}</span>
          </div>
          <div class="quantity_of_commodity">
            已选<span>{{select_commodity}}</span>件商品
          </div>
        </div>
      </Col>
      <Col span="24">
        <div class="LibraryOfGoodsList_relative_pages LibraryOfGoodsList_relative_pages_change">
          <Spin v-show="relative_pages_loding" class="LibraryOfGoodsIndex_center_relative_pages_Loding"></Spin>
          <Page prev-text="< 上一页" next-text="下一页 >" :total="query.count" :current="query.page" :page-size="query.size" @on-change="LibraryOfGoodsList_handleCurrentChange" />
          <!--show-elevator show-total-->
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
          close_an_account_loading: false, // 去结算loading
          select_commodity: 0, // 已选几件商品
          total_prices: 0.00, // 进货单总价
          relative_pages_loding: false, // 分页误点击遮罩
          query: { // 分页初始,每页条数总条数
            page: 1,
            size: 20,
            count: 0,
            sort: 1,
            test: null
          },
          commodity_list_my: [], // 商品列表
          fruitIds: [], // 判断是否全选择
          fruitIdsAll: [], // 全选准备
          indeterminate: false, // 全选之前的显示
          myReceiptIndexcenter_list_center_loading: false, // 商品列表加载
          checkAll: false // 全选
        }
      },
      components: {},
      methods: {
        searchBox_Value () { // 请求搜索本页面数据(搜索数据的时候也提前请求一下接口看看有没有值要穿的)
          this.searchBoxValue = this.searchBoxValue.replace(/(^\s*)|(\s*$)/g, '')
          if (this.searchBoxValue === '' || this.searchBoxValue === undefined || this.searchBoxValue === null || this.searchBoxValue === 'undefined') {
//            this.$Message.warning('搜索输入不能为空')
            this.quantity_statistics()
            let shopping = [
              {
                id: 123456, // 品类id结算的时候用
                product_name: '摄影服务上海淘宝产品静物拍照拍摄商品食品化妆品围巾网拍设计', // 商品名称
                inventory: 10000, // 商品库存
                product_id: 1, // 商品id收藏的时候用
                price: 0, // 单个品类初始价格
                number: 110, // 已选择购买数量
                cover_url: '//gd2.alicdn.com/imgextra/i2/1794454245/TB2h5ODiBDH8KJjy1zeXXXjepXa_!!1794454245.jpg_50x50.jpg_.webp', // 图片
                mode: '黑色/64G', // 品种型号
                status: false, // 是否是立即购买传值
                sku_region: [
                  {
                    min: 1, // 最小批发数字
                    max: 10, // 最大批发数字
                    sell_price: 10000.00 // 批发阶段价格
                  },
                  {
                    min: 11, // 最小批发数字
                    max: 100, // 最大批发数字
                    sell_price: 8550.05 // 批发阶段价格
                  },
                  {
                    min: 101, // 最小批发数字
                    max: 1000, // 最大批发数字
                    sell_price: 5000.05 // 批发阶段价格
                  },
                  {
                    min: 1001, // 最小批发数字
                    max: 10000, // 最大批发数字
                    sell_price: 2500.05 // 批发阶段价格
                  }
                ],
                focus: 0 // 是否关注
              }
            ]
            this.this_change_goods(shopping)
          } else {
            let shopping = [
              {
                id: 12346, // 品类id结算的时候用
                product_name: '摄影服务上海淘宝产品静物拍照拍摄商品食品化妆品围巾网拍设计', // 商品名称
                inventory: 10000, // 商品库存
                product_id: 1, // 商品id收藏的时候用
                price: 0, // 单个品类初始价格
                number: 110, // 已选择购买数量
                cover_url: '//gd2.alicdn.com/imgextra/i2/1794454245/TB2h5ODiBDH8KJjy1zeXXXjepXa_!!1794454245.jpg_50x50.jpg_.webp', // 图片
                mode: '黑色/64G', // 品种型号
                status: false, // 是否是立即购买传值
                sku_region: [
                  {
                    min: 1, // 最小批发数字
                    max: 10, // 最大批发数字
                    sell_price: 10000.00 // 批发阶段价格
                  },
                  {
                    min: 11, // 最小批发数字
                    max: 100, // 最大批发数字
                    sell_price: 8550.05 // 批发阶段价格
                  },
                  {
                    min: 101, // 最小批发数字
                    max: 1000, // 最大批发数字
                    sell_price: 5000.05 // 批发阶段价格
                  },
                  {
                    min: 1001, // 最小批发数字
                    max: 10000, // 最大批发数字
                    sell_price: 2500.05 // 批发阶段价格
                  }
                ],
                focus: 0 // 是否关注
              },
              {
                id: 123546, // 品类id结算的时候用
                product_name: '摄影服务上海淘宝产品静物拍照拍摄商品食品化妆品围巾网拍设计', // 商品名称
                inventory: 10000, // 商品库存
                product_id: 1, // 商品id收藏的时候用
                price: 0, // 单个品类初始价格
                number: 10, // 已选择购买数量
                cover_url: '//gd2.alicdn.com/imgextra/i2/1794454245/TB2h5ODiBDH8KJjy1zeXXXjepXa_!!1794454245.jpg_50x50.jpg_.webp', // 图片
                mode: '黑色/64G', // 品种型号
                status: false, // 是否是立即购买传值
                sku_region: [
                  {
                    min: 1, // 最小批发数字
                    max: 10, // 最大批发数字
                    sell_price: 10000.00 // 批发阶段价格
                  },
                  {
                    min: 11, // 最小批发数字
                    max: 100, // 最大批发数字
                    sell_price: 8550.05 // 批发阶段价格
                  },
                  {
                    min: 101, // 最小批发数字
                    max: 1000, // 最大批发数字
                    sell_price: 5000.05 // 批发阶段价格
                  },
                  {
                    min: 1001, // 最小批发数字
                    max: 10000, // 最大批发数字
                    sell_price: 2500.05 // 批发阶段价格
                  }
                ],
                focus: 0 // 是否关注
              }
            ]
            this.this_change_goods(shopping)
          }
          // 我的订单页面返回商品库界面搜索
        },
        handleCheckAll () { // 全选与取消
          if (this.indeterminate) {
            this.checkAll = false
          } else {
            this.checkAll = !this.checkAll
          }
          this.indeterminate = false

          if (this.checkAll) {
            this.fruitIds = this.fruitIdsAll
            for (let i = 0; i < this.commodity_list_my.length; i++) {
              this.commodity_list_my[i].status = true
            }
          } else {
            this.fruitIds = []
            for (let i = 0; i < this.commodity_list_my.length; i++) {
              this.commodity_list_my[i].status = false
            }
          }
          this.select_commodity = this.fruitIds.length
          this.total_priceser()
        },
        checkAllGroupChange (data) { // 单个选择
          if (data.length === this.commodity_list_my.length) {
            this.indeterminate = false
            this.checkAll = true
          } else if (data.length > 0) {
            this.indeterminate = true
            this.checkAll = false
          } else {
            this.indeterminate = false
            this.checkAll = false
          }
          this.select_commodity = data.length
          this.total_priceser()
        },
        addClasse (index) {
          if (this.commodity_list_my[index].status === false) {
            this.commodity_list_my[index].status = true
          } else {
            this.commodity_list_my[index].status = false
          }
        },
        remove_number (e) { // 计算减法
          if (this.commodity_list_my[e].number <= 1) {
            this.commodity_list_my[e].number = 1
          } else {
            this.commodity_list_my[e].number--
          }
          this.change_unit_price(e)
          this.total_priceser()
          this.Record_the_number()
        },
        adds_number (e) { // 计算加法
          if (this.commodity_list_my[e].number >= this.commodity_list_my[e].inventory) {
            this.commodity_list_my[e].number = this.commodity_list_my[e].inventory
          } else {
            this.commodity_list_my[e].number++
          }
          this.change_unit_price(e)
          this.total_priceser()
          this.Record_the_number()
        },
        amount_change (e) { // 改变数值输入框
          this.commodity_list_my[e].number = this.commodity_list_my[e].number.replace(/^[0]+[0-9]*$/gi, '')
          this.commodity_list_my[e].number = this.commodity_list_my[e].number.replace(/[^\d]/g, '')
          if (this.commodity_list_my[e].number === '' || this.commodity_list_my[e].number === null || this.commodity_list_my[e].number === undefined) {
            this.commodity_list_my[e].number = 1
          } else if (this.commodity_list_my[e].number >= this.commodity_list_my[e].inventory) {
            this.commodity_list_my[e].number = this.commodity_list_my[e].inventory
          }
          this.change_unit_price(e)
          this.total_priceser()
          this.Record_the_number()
        },
        entrance_particulars (ids) { // 通过id进入详情页
          this.$router.push({name: 'commodityDetailsIndex', params: {id: ids}})
        },
        Record_the_number () { // 记录加减的数据
          let shoping = []
          for (let i = 0; i < this.commodity_list_my.length; i++) {
            shoping.push({product_id: this.commodity_list_my[i].product_id, number: this.commodity_list_my[i].number})
          }
          this.$store.commit('THE_ORDER_SHOPPING_NUMBER', shoping)
        },
        ckear_checkall_shopping () { // 删除选中的商品
          if (this.fruitIds.length <= 0) {
            this.$Message.warning('请选中一个商品再进行删除')
          } else {
            let shoping = []
            for (let i = 0; i < this.commodity_list_my.length; i++) {
              if (this.commodity_list_my[i].status === true) {
                shoping.push({id: this.commodity_list_my[i].id})
              }
            }
            console.log(shoping)
            this.readay_shopping()
            this.$Message.success('删除成功')
          }
        },
        empty_purchase_order () { // 清空进货单
          this.$Message.success('清空进货单成功')
        },
        delete_single (e) { // 删除单个商品分类
          let thisIds = []
          thisIds.push({id: this.commodity_list_my[e].id})
          this.$Message.success('删除成功')
        },
        focus_onclick_this (e) { // 关注商品
          let productId = this.commodity_list_my[e].product_id
          this.searchBoxValue = ''
          this.commodity_list_my[e].focus = 1
          this.$Message.success('关注成功')
          console.log(productId)
          // 调用关注商品接口之后回调整个商品接口
        },
        change_unit_price (e) { // 价格根据数量改变
          let skus = this.commodity_list_my[e].sku_region
          for (let i = 0; i < skus.length; i++) {
            if (this.commodity_list_my[e].number >= skus[i].min && this.commodity_list_my[e].number <= skus[i].max) {
              this.commodity_list_my[e].price = skus[i].sell_price
            } else if (this.commodity_list_my[e].number > skus[i].max) {
              this.commodity_list_my[e].price = skus[i].sell_price
            }
          }
          this.unit_price(e) // 单个价格计算
        },
        LibraryOfGoodsList_handleCurrentChange (currentPage) { // page分页点击的结果
          this.query.page = currentPage
          if (this.relative_pages_loding === false) {

          } else {
            this.$Message.warning('请等待数据返回之后再进行翻页操作')
          }
        },
        readay_shopping () {
          let shopping = [
            {
              id: 123456, // 品类id结算的时候用
              product_name: '摄影服务上海淘宝产品静物拍照拍摄商品食品化妆品围巾网拍设计', // 商品名称
              inventory: 10000, // 商品库存
              product_id: 1, // 商品id收藏的时候用
              price: 0, // 单个品类初始价格
              number: 11, // 已选择购买数量
              cover_url: '//gd2.alicdn.com/imgextra/i2/1794454245/TB2h5ODiBDH8KJjy1zeXXXjepXa_!!1794454245.jpg_50x50.jpg_.webp', // 图片
              mode: '黑色/64G', // 品种型号
              status: true, // 是否是立即购买传值
              sku_region: [
                {
                  min: 1, // 最小批发数字
                  max: 10, // 最大批发数字
                  sell_price: 1000.00 // 批发阶段价格
                },
                {
                  min: 11, // 最小批发数字
                  max: 100, // 最大批发数字
                  sell_price: 855.05 // 批发阶段价格
                },
                {
                  min: 101, // 最小批发数字
                  max: 1000, // 最大批发数字
                  sell_price: 500.05 // 批发阶段价格
                },
                {
                  min: 1001, // 最小批发数字
                  max: 10000, // 最大批发数字
                  sell_price: 250.05 // 批发阶段价格
                }
              ],
              focus: 0 // 是否关注
            },
            {
              id: 654321, // 品类id结算的时候用
              product_name: '摄影服务上海淘宝产品静物拍照拍摄商品食品化妆品围巾网拍设计1', // 商品名称
              inventory: 1000, // 商品库存
              product_id: 2, // 商品id收藏的时候用
              price: 0, // 单个品类初始价格
              number: 101, // 已选择购买数量
              cover_url: '//gd2.alicdn.com/imgextra/i2/1794454245/TB2h5ODiBDH8KJjy1zeXXXjepXa_!!1794454245.jpg_50x50.jpg_.webp', // 图片
              mode: '黑色/64G', // 品种型号
              status: false, // 是否是立即购买传值
              sku_region: [
                {
                  min: 1, // 最小批发数字
                  max: 10, // 最大批发数字
                  sell_price: 100.00 // 批发阶段价格
                },
                {
                  min: 11, // 最小批发数字
                  max: 100, // 最大批发数字
                  sell_price: 85.50 // 批发阶段价格
                },
                {
                  min: 101, // 最小批发数字
                  max: 1000, // 最大批发数字
                  sell_price: 50.50 // 批发阶段价格
                }
              ],
              focus: 1 // 是否关注
            },
            {
              id: 1234, // 品类id结算的时候用
              product_name: '摄影服务上海淘宝产品静物拍照拍摄商品食品化妆品围巾网拍设计1', // 商品名称
              inventory: 100, // 商品库存
              product_id: 2, // 商品id收藏的时候用
              price: 0, // 单个品类初始价格
              number: 9, // 已选择购买数量
              cover_url: '//gd2.alicdn.com/imgextra/i2/1794454245/TB2h5ODiBDH8KJjy1zeXXXjepXa_!!1794454245.jpg_50x50.jpg_.webp', // 图片
              mode: '黑色/64G', // 品种型号
              status: false, // 是否是立即购买传值
              sku_region: [
                {
                  min: 1, // 最小批发数字
                  max: 10, // 最大批发数字
                  sell_price: 100.00 // 批发阶段价格
                },
                {
                  min: 11, // 最小批发数字
                  max: 100, // 最大批发数字
                  sell_price: 85.50 // 批发阶段价格
                },
                {
                  min: 101, // 最小批发数字
                  max: 1000, // 最大批发数字
                  sell_price: 50.50 // 批发阶段价格
                }
              ],
              focus: 1 // 是否关注
            }
          ]
          this.this_change_goods(shopping)
          this.quantity_statistics() // 数量统计
        },
        quantity_statistics () { // 数量做统计
          let Number = this.$store.state.event.The_order_shopping_Number
          if (Number.length <= 0) {
            this.$store.commit('THE_ORDER_SHOPPING_NUMBER_CLEAR')
          } else { // Number有值就请求一下没有就不请求了(防止用户刷新页面的操作)
            this.$store.commit('THE_ORDER_SHOPPING_NUMBER_CLEAR')
          }
        },
        this_change_goods (shopping) { // 处理主逻辑
          this.fruitIds = []
          this.fruitIdsAll = []
          this.commodity_list_my = []
          this.checkAll = false
          this.indeterminate = false
          for (let i = 0; i < shopping.length; i++) { // 价格显示
            this.$set(shopping[i], 'price_once', 0)
            if (shopping[i].status === true) {
              this.fruitIds.push(shopping[i].id)
              this.checkAllGroupChange(shopping[i].id)
            }
            this.fruitIdsAll.push(shopping[i].id)
            let skuRegion = shopping[i].sku_region
            for (let a = 0; a < skuRegion.length; a++) {
              if (shopping[i].number >= skuRegion[a].min && shopping[i].number <= skuRegion[a].max) {
                shopping[i].price = skuRegion[a].sell_price
              } else if (shopping[i].number > skuRegion[a].max) {
                shopping[i].price = skuRegion[a].sell_price
              }
            }
          }
          if (this.fruitIds.length > 0) {
            this.indeterminate = true
          } else {
            this.indeterminate = false
          }
          this.commodity_list_my = shopping
          this.select_commodity = this.fruitIds.length
          this.myReceiptIndexId = 0
          this.unit_price_readay() // 计算初始化单个总价
          this.total_priceser() // 计算总价
        },
        total_priceser () { // 总价计算
          let totalPrice = 0
          this.commodity_list_my.forEach(function (val, index) {
            if (val.status === true) {
              totalPrice += (val.price * 100) * val.number / 100
            }
          })
          this.total_prices = parseFloat(totalPrice)
        },
        unit_price_readay () { // 初始化单价计算
          let unitPrice = 0
          for (let i = 0; i < this.commodity_list_my.length; i++) {
            unitPrice += (this.commodity_list_my[i].price * 100) * this.commodity_list_my[i].number / 100
            this.commodity_list_my[i].price_once = parseFloat(unitPrice)
            unitPrice = 0 // 初始化价格
          }
        },
        unit_price (e) {
          let unitPrice = 0
          let prices = this.commodity_list_my[e]
          unitPrice += (prices.price * 100) * prices.number / 100
          prices.price_once = parseFloat(unitPrice)
        }
      },
      created: function () {
        const self = this
        const id = this.$route.params.id
        self.myReceiptIndexId = id
        this.readay_shopping()
      },
      mounted () {
        this.total_priceser()
      },
      watch: {
      }
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
    border-bottom: 1px solid #C8C8C8;
    float: left;
  }
  .myReceiptIndexcenter_list_centerNumber:last-child{
    border-bottom: 1px solid #fff;
  }
  .myReceiptIndexcenter_list_centerNumber.list_centerNumber{
    border: 1px solid #ED3A4A;
    /*border-top: 0;*/
  }
  .myReceiptIndexcenter_list_centerNumber.list_centerNumber:first-child{
    border-top: 1px solid #ED3A4A;
    /*border-bottom: 0;*/
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
  .myReceiptIndexcenter_list_centerNumber .operation_div ul{
    width: 100px;
    height: 56px;
    margin: 50px 0;
    float: left;
  }
  .myReceiptIndexcenter_list_centerNumber .operation_div ul li{
    width: 100px;
    height: 20px;
    line-height: 20px;
    float: left;
    text-align: center;
    font-size: 14px;
  }
  .myReceiptIndexcenter_list_centerNumber .operation_div ul li span{
    cursor:pointer;
  }
  .myReceiptIndexcenter_list_close_footer{
    width: 1180px;
    height: 76px;
    border-top: 1px solid #C8C8C8;
    border-bottom: 1px solid #C8C8C8;
    float: left;
  }
  .myReceiptIndexcenter_list_close_footer .check_all_div_footer{
    width: 76px;
    height: 76px;
    line-height: 76px;
    padding: 0 10px;
    float: left;
  }
  .myReceiptIndexcenter_list_close_footer .clear_my_purchase_list{
    width: 110px;
    height: 76px;
    margin-left: 4px;
    line-height: 76px;
    font-size: 14px;
    text-align: center;
    float: left;
    margin-right: 24px;
  }
  .myReceiptIndexcenter_list_close_footer .clear_my_purchase_list span{
    cursor:pointer;
  }
  .myReceiptIndexcenter_list_close_footer .empty_purchase_list{
    width: 80px;
    height: 76px;
    float: left;
    text-align: center;
    font-size: 14px;
    line-height: 76px;
  }
  .myReceiptIndexcenter_list_close_footer .empty_purchase_list span{
    cursor:pointer;
  }
  .myReceiptIndexcenter_list_close_footer .close_an_account{
    width: 150px;
    height: 76px;
    float: right;
  }
  .myReceiptIndexcenter_list_close_footer .total_prices{
    min-width: 230px;
    max-width: 660px;
    height: 76px;
    float: right;
    margin-left: 12px;
    font-size: 14px;
    line-height: 76px;
    text-align: center;
    padding: 0 10px;
  }
  .myReceiptIndexcenter_list_close_footer .total_prices span{
    font-size: 24px;
    color: #ED3A4A;
  }
  .myReceiptIndexcenter_list_close_footer .quantity_of_commodity{
    min-width: 110px;
    height: 76px;
    float: right;
    line-height: 80px;
    text-align: center;
    font-size: 16px;
  }
  .myReceiptIndexcenter_list_close_footer .quantity_of_commodity span{
    color: #ED3A4A;
    margin: 0 5px;
  }
  .LibraryOfGoodsList_relative_pages{
    margin-top: 40px;
    height: 40px;
    margin-bottom: 10px;
  }
  .LibraryOfGoodsList_notList{
    width: 100%;
    min-height: 398px;
    font-size: 18px;
    text-align: center;
  }
  .LibraryOfGoodsList_notList img{
    width: 280px;
    height: 280px;
    margin: 59px auto;
  }
  .active{
    background: #000;
  }
</style>
