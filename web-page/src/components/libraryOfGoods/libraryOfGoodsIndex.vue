<template>
<div class="LibraryOfGoodsIndex_center">
  <Row :gutter="20" type="flex" justify="center">
    <Col span="24">
    <div class="LibraryOfGoodsIndex_search_box">
      <Input v-model="searchBoxValue" placeholder="商品名称/商品编号/订单号" class="search_box_search">
        <Icon type="ios-search" slot="suffix" :loading="search_box_loading" @click.active="searchBox_Value" />
      </Input>
    </div>
    </Col>
    <Col span="24">
    <div class="LibraryOfGoodsIndex_Switch_Options">
      <Spin v-show="Spin_loding" class="LibraryOfGoodsIndex_center_Spin_loding"></Spin>
      <Menu mode="horizontal" :theme="theme" :active-name="theme_length">
        <div class="LibraryOfGoodsIndex_Switch_Options_div">
          <MenuItem :name="0" @click.native="Switch_Options(0)">
            全部商品分类
          </MenuItem>
        </div>
        <div class="LibraryOfGoodsIndex_Switch_Options_div" v-for="(theme_navs,index) in theme_nav" :key="index">
          <MenuItem :name="index + 1" @click.native="Switch_Options(theme_navs.id)">
            {{theme_navs.title}}
          </MenuItem>
        </div>
      </Menu>
    </div>
  </Col>
  <Col span="24" class="LibraryOfGoodsList_relative">
    <library-of-goods-list :theme_Shopping="theme_Shopping"></library-of-goods-list>
  </Col>
  <Col span="24">
    <div class="LibraryOfGoodsList_relative_pages">
      <Spin v-show="relative_pages_loding" class="LibraryOfGoodsIndex_center_relative_pages_Loding"></Spin>
      <Page prev-text="< 上一页" next-text="下一页 >" :total="query.count" :current="query.page" :page-size="query.size" @on-change="LibraryOfGoodsList_handleCurrentChange"  show-elevator show-total />
    </div>
  </Col>
  </Row>
</div>
</template>

<script>
    import LibraryOfGoodsList from '@/components/LibraryOfGoods/LibraryOfGoodsList'
    import api from '@/api/api'
    export default {
      name: 'LibraryOfGoodsIndex',
      data () {
        return {
          Bus: this.$BusFactory(this),
          searchBoxValue: '', // 搜索框数据
          theme: 'light', // 导航菜单主题
          theme_length: 0, // 获取导航点击信息查询时传给后端
          search_box_loading: false, // 点击搜索防止误触发
          Spin_loding: false, // 点击导航菜单防止误触发
          theme_Shopping: [], // 商品库
          theme_nav: [], // 商品导航栏
          count: '',     // 全部商品,搜索为空时总条数
          query: { // 分页初始,每页条数总条数
            page: 1,
            size: 20,
            count: 0,
            sort: 1,
            test: null
          },
          relative_pages_loding: false, // 分页误触发
          seach_is: false // 判断搜索框是否点击
        }
      },
      components: {
        LibraryOfGoodsList
      },
      methods: {
        searchBox_Value () { // 请求搜索数据
          this.searchBoxValue = this.searchBoxValue.replace(/(^\s*)|(\s*$)/g, '')
          if (this.searchBoxValue === '' || this.searchBoxValue === undefined || this.searchBoxValue === null || this.searchBoxValue === 'undefined') {
            this.$Message.warning('搜索输入不能为空')
            this.seach_is = false
//            this.table_data() // 搜索数据为空时重新请求数据
          } else {
            this.add_state()
            this.query.page = 1
            this.query.count = 0
            this.theme_length = 0
            this.seach_is = true
            this.$http({
              method: 'get',
              url: api.LibraryOfGoodsIndexsearch,
              params: {
                name: this.searchBoxValue,
                per_page: this.query.size,
                page: this.query.page
              }
            })
            .then((res) => {
              let metas = res.data.meta
              let datas = res.data.data
              if (metas.status_code === 200) {
                this.query.count = metas.pagination.total
                this.theme_Shopping = datas
              } else {
                this.$Message.error(metas.message)
              }
              this.clear_state()
            })
            .catch((res) => {
              this.$Message.error(res.message)
              this.clear_state()
            })
          }
          // 搜索产品(请求接口下面列表更换根据所选项去查,更换所选项时查询框所有东西清空,详情页搜索框使用bus传值实现)
        },
        Switch_Options (data) {
          // 请求列表接口
          this.searchBoxValue = ''
          this.theme_length = data
          this.seach_is = false
          this.table_data()
        },
        table_data () {
          // 列表请求
          this.add_state()
          this.query.page = 1
          this.query.count = 0
          this.$http({
            method: 'get',
            url: api.LibraryOfGoodsIndexlist,
            params: {
              per_page: this.query.size,
              page: this.query.page,
              token: this.$store.state.event.token,
              categories_id: this.theme_length
            }
          })
          .then((res) => {
            let metas = res.data.meta
            let datas = res.data.data
            if (metas.status_code === 200) {
              this.query.count = metas.pagination.total
              this.theme_Shopping = datas
            } else {
              this.$Message.error(metas.message)
            }
            this.clear_state()
          })
          .catch((res) => {
            this.$Message.error(res.message)
            this.clear_state()
          })
        },
        clear_state () {
          this.Spin_loding = false
          this.relative_pages_loding = false
          this.Bus.$emit('LibraryOfGoodsList_lodings_clear', 'clear')
        },
        add_state () {
          this.Bus.$emit('LibraryOfGoodsList_lodings', 'changes')
          this.relative_pages_loding = true
          this.Spin_loding = true
        },
        LibraryOfGoodsList_handleCurrentChange (currentPage) { // page分页点击的结果
          this.query.page = currentPage
          if (this.seach_is === false) {
            this.searchBoxValue = ''
            this.add_state()
            this.$http({
              method: 'get',
              url: api.LibraryOfGoodsIndexlist,
              params: {
                per_page: this.query.size,
                page: this.query.page,
                token: this.$store.state.event.token,
                categories_id: this.theme_length
              }
            })
            .then((res) => {
              let metas = res.data.meta
              let datas = res.data.data
              if (metas.status_code === 200) {
                this.query.count = metas.pagination.total
                this.theme_Shopping = datas
                this.Spin_loding = false
                this.relative_pages_loding = false
                this.Bus.$emit('LibraryOfGoodsList_lodings_clear', 'clear')
              } else {
                this.$Message.error(metas.message)
              }
              this.clear_state()
            })
            .catch((res) => {
              this.$Message.error(res.message)
              this.clear_state()
            })
          } else if (this.seach_is === true) {
            this.seach_is = true
            this.add_state()
            this.$http({
              method: 'get',
              url: api.LibraryOfGoodsIndexsearch,
              params: {
                name: this.searchBoxValue,
                per_page: this.query.size,
                page: this.query.page
              }
            })
            .then((res) => {
              let metas = res.data.meta
              let datas = res.data.data
              if (metas.status_code === 200) {
                this.query.count = metas.pagination.total
                this.theme_Shopping = datas
              } else {
                this.$Message.error(metas.message)
              }
              this.clear_state()
            })
            .catch((res) => {
              this.$Message.error(res.message)
              this.clear_state()
            })
          }
        },
        readay_seach () {
          let seach = this.$store.state.event.global_Search_Library_Of_Goods
          if (seach === '' || seach === undefined || seach === null) {
            this.seach_is = false
            this.The_first_request()
            this.$store.commit('GLOBAL_SEARCH_LIBRARY_OF_GOODS_CLEAR')
          } else {
            this.seach_is = true
            this.searchBoxValue = seach
            this.The_first_request_title()
            this.searchBox_Value()
            this.$store.commit('GLOBAL_SEARCH_LIBRARY_OF_GOODS_CLEAR')
          }
        },
        The_first_request_title () {
          // title请求
          this.$http({
            method: 'get',
            url: api.LibraryOfGoodsIndextitle,
            params: {
              token: this.$store.state.event.token
            }
          })
          .then((res) => {
            let metas = res.data.meta
            let datas = res.data.data
            if (metas.status_code === 200) {
              this.theme_nav = datas
            } else {
              this.$Message.error(metas.message)
            }
          })
          .catch((res) => {
            this.$Message.error(res.message)
          })
        },
        The_first_request () {
          this.add_state()
          this.The_first_request_title()
          // 列表请求
          this.$http({
            method: 'get',
            url: api.LibraryOfGoodsIndexlist,
            params: {
              per_page: this.query.size,
              page: this.query.page,
              token: this.$store.state.event.token,
              categories_id: this.theme_length
            }
          })
          .then((res) => {
            let metas = res.data.meta
            let datas = res.data.data
            if (metas.status_code === 200) {
              this.query.count = metas.pagination.total
              this.theme_Shopping = datas
            } else {
              this.$Message.error(metas.message)
            }
            this.clear_state()
          })
          .catch((res) => {
            this.$Message.error(res.message)
            this.clear_state()
          })
        }
      },
      created: function () {
        this.readay_seach()
      },
      mounted () {

      },
      watch: {}
    }
</script>

<style scoped>
.LibraryOfGoodsIndex_center{
  width: 1070px;
  margin: 0 auto;
  min-height: 645px;
  clear: both;
}
.LibraryOfGoodsIndex_search_box{
  margin-top: 38px;
  margin-right: 26px;
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
.LibraryOfGoodsIndex_Switch_Options{
  width: 100%;
  margin-top: 15px;
  height: 40px;
  margin-bottom: 22px;
}
.LibraryOfGoodsIndex_Switch_Options_div{
  padding: 0 25px;
  float: left;
  border-right: 1px solid #999;
  height: 18px;
  margin: 11px 0;
}
.LibraryOfGoodsIndex_Switch_Options_div:last-child{
  border-right: 0;
}
.LibraryOfGoodsIndex_Switch_Options ul{
  height: 39px;
}
.LibraryOfGoodsIndex_Switch_Options ul li{
  color: #707b87eb;
}
.LibraryOfGoodsList_relative{
  position: relative;
  min-height: 398px;
  height: auto;
}
.LibraryOfGoodsList_relative_pages{
  margin-top: 15px;
  height: 40px;
  margin-bottom: 40px;
}
</style>
