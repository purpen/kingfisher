<template>
<div class="LibraryOfGoodsIndex_center">
  <Row :gutter="20" type="flex" justify="center">
    <Col span="24">
    <div class="LibraryOfGoodsIndex_search_box">
      <Input v-model="searchBoxValue" placeholder="搜索商品名称" class="search_box_search" />
      <Button type="primary" :loading="search_box_loading" class="search_box" @click="searchBox_Value">搜索</Button>
    </div>
    </Col>
    <Col span="24">
    <div class="LibraryOfGoodsIndex_Switch_Options">
      <Spin v-show="Spin_loding" class="LibraryOfGoodsIndex_center_Spin_loding"></Spin>
      <Menu mode="horizontal" :theme="theme" :active-name="0">
        <MenuItem v-for="(theme_navs,index) in theme_nav" :name="index" :key="index" @click.native="Switch_Options(theme_navs.theme_nav_ids)">
          {{theme_navs.theme_nav_name}}
        </MenuItem>
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
          theme_Shopping: [ // 商品库
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气1',
              lengths: 0,
              ids: '1234',
              money: 11190,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气2',
              lengths: 1,
              ids: '1244',
              money: 11190,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气3',
              lengths: 0,
              ids: '1334',
              money: 11190,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气4',
              lengths: 1,
              ids: '1134',
              money: 11190,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气4',
              lengths: 1,
              ids: '1134',
              money: 11190,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            }
          ],
          theme_nav: [ // 商品导航栏
            {theme_nav_name: '全部商品分类', theme_nav_ids: '0'},
            {theme_nav_name: '先锋智能', theme_nav_ids: '1'},
            {theme_nav_name: '数码电子', theme_nav_ids: '2'},
            {theme_nav_name: '户外出行', theme_nav_ids: '3'},
            {theme_nav_name: '运动健康', theme_nav_ids: '4'},
            {theme_nav_name: '先锋设计', theme_nav_ids: '5'},
            {theme_nav_name: '家用日常', theme_nav_ids: '6'},
            {theme_nav_name: '美丽装扮', theme_nav_ids: '7'},
            {theme_nav_name: '母婴成长', theme_nav_ids: '8'}
          ],
          count: '',     // 全部商品,搜索为空时总条数
          query: { // 分页初始,每页条数总条数
            page: 1,
            size: 20,
            count: 1000,
            sort: 1,
            test: null
          },
          relative_pages_loding: false // 分页误触发
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
          } else {
            let _this = this
            this.theme_Shopping = []
            this.theme_Shopping.push(
              {
                text: '夏季白衬衫男短袖纯棉免烫白色衬',
                lengths: 1,
                ids: '1234',
                money: 11191,
                img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
              }
            )
            this.Bus.$emit('LibraryOfGoodsList_lodings', 'changes')
            this.search_box_loading = true
            this.relative_pages_loding = true
            this.Spin_loding = true
//            this.query.count = 0
            this.query.page = 1
            setTimeout(function () {
              _this.search_box_loading = false
              _this.relative_pages_loding = false
              _this.Spin_loding = false
              _this.query.count = 500
              _this.query.page = 1
              _this.Bus.$emit('LibraryOfGoodsList_lodings_clear', 'clear')
            }, 2000)
            console.log(this.searchBoxValue)
          }
          // 搜索产品(请求接口下面列表更换根据所选项去查,更换所选项时查询框所有东西清空,详情页搜索框使用bus传值实现)
        },
        Switch_Options (data) { // 请求列表接口
          // 点击导航菜单获取值信息
//          if (this.theme_length === data) {
//            console.log('重复')
//            return false
//          } else {
//            console.log('不重复')
//            this.theme_length = data
//          }
          this.searchBoxValue = ''
          let _this = this
          this.theme_Shopping = []
          this.theme_Shopping.push(
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            }
          )
          this.Bus.$emit('LibraryOfGoodsList_lodings', 'changes')
          this.relative_pages_loding = true
          this.Spin_loding = true
//          this.query.count = 0
          this.query.page = 1
          setTimeout(function () {
            _this.Spin_loding = false
            _this.relative_pages_loding = false
            _this.query.count = 100
            _this.query.page = 1
            _this.Bus.$emit('LibraryOfGoodsList_lodings_clear', 'clear')
          }, 2000)
          console.log(data)
        },
        table_data (data) { // 列表数据

        },
        LibraryOfGoodsList_handleCurrentChange (currentPage) { // page分页点击的结果
          this.query.page = currentPage
          let _this = this
          this.theme_Shopping = []
          this.theme_Shopping.push(
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            },
            {
              text: '夏季白衬衫男短袖纯棉免烫白色衬',
              lengths: 1,
              ids: '1234',
              money: 11191,
              img: '//g-search1.alicdn.com/img/bao/uploaded/i4/i3/2658829235/TB26_0ZsDmWBKNjSZFBXXXxUFXa_!!2658829235-0-item_pic.jpg_230x230.jpg_.webp'
            }
          )
          this.Bus.$emit('LibraryOfGoodsList_lodings', 'changes')
          this.relative_pages_loding = true
          this.Spin_loding = true
          setTimeout(function () {
            _this.relative_pages_loding = false
            _this.Spin_loding = false
            _this.Bus.$emit('LibraryOfGoodsList_lodings_clear', 'clear')
          }, 2000)
        },
        readay_seach () {
          let seach = this.$store.state.event.global_Search_Library_Of_Goods
          if (seach === '' || seach === undefined || seach === null) {
            this.$store.commit('GLOBAL_SEARCH_LIBRARY_OF_GOODS_CLEAR')
          } else {
            this.searchBoxValue = seach
            this.search_box_loading = true
            this.relative_pages_loding = true
            this.Spin_loding = true
            this.searchBox_Value()
            this.$store.commit('GLOBAL_SEARCH_LIBRARY_OF_GOODS_CLEAR')
            this.Bus.$emit('LibraryOfGoodsList_lodings', 'changes')
            let _this = this
            setTimeout(function () {
              _this.search_box_loading = false
              _this.relative_pages_loding = false
              _this.Spin_loding = false
              _this.Bus.$emit('LibraryOfGoodsList_lodings_clear', 'clear')
            }, 2000)
          }
        }
      },
      created: function () {
      },
      mounted () {
        this.readay_seach()
      },
      watch: {}
    }
</script>

<style scoped>
.LibraryOfGoodsIndex_center{
  padding: 0 100px;
  clear: both;
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
.LibraryOfGoodsIndex_search_box div.search_box_search input{
  border: 0;
}
.LibraryOfGoodsIndex_Switch_Options{
  width: 100%;
  margin-top: 75px;
  height: 40px;
  border-bottom: 1px solid #666666;
  padding: 0 15px;
  margin-bottom: 40px;
}
.LibraryOfGoodsIndex_Switch_Options ul{
  height: 39px;
}
.LibraryOfGoodsIndex_Switch_Options ul li{
  color: #707b87eb;
}
.LibraryOfGoodsList_relative{
  position: relative;
  height: auto;
}
.LibraryOfGoodsList_relative_pages{
  margin-top: 15px;
  height: 40px;
  margin-bottom: 40px;
}
/*设置了浏览器宽度不大于1200px时  显示992px宽度 */
@media screen and (min-width: 300px) and (max-width: 1170px) {
  .LibraryOfGoodsIndex_center {
    margin: 0 auto;
    padding: 0 20px;
    width: 1180px;
  }
}
@media screen and (min-width: 1450px) and (max-width: 2500px) {
  .LibraryOfGoodsIndex_center {
    margin: 0 auto;
    padding: 0 20px;
    width: 1180px;
  }
}
@media screen and (min-width: 1250px) and (max-width: 1450px) {
  .LibraryOfGoodsIndex_center {
    margin: 0 auto;
    padding: 0 20px;
    width: 1060px;
  }
}
@media screen and (min-width: 300px) and (max-width: 1250px) {
  .LibraryOfGoodsIndex_center {
    margin: 0 auto;
    padding: 0 20px;
    width: 1060px;
  }
}
</style>
