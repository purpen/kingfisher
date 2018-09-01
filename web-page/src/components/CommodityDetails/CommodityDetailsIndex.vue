<template>
  <div class="CommodityDetailsIndex_center">
    <Row :gutter="20" type="flex" justify="center">
      <Spin fix v-show="particulars_loading" class="posi_fix"></Spin>
      <Col span="24">
        <div class="LibraryOfGoodsIndex_search_box">
          <Input v-model="searchBoxValue" placeholder="搜索商品名称" class="search_box_search" />
          <Button type="primary" :loading="search_box_loading" class="search_box" @click="searchBox_Value">搜索</Button>
        </div>
      </Col>
      <Col span="24">
        <div class="LibraryOfGoodsIndex_center">
          <div class="LibraryOfGoodsIndex_center_title">
            <p>夏季白衬衫男短袖纯棉免烫白色衬衣男士修身韩版潮流商务休闲帅气1</p>
          </div>
          <div class="LibraryOfGoodsIndex_center_content">
            <div class="LibraryOfGoodsIndex_center_content_carousel">
                <div class="LibraryOfGoodsIndex_center_content_carousel_ceter">
                  <div class="LibraryOfGoodsIndex_center_content_bigimg" v-if="data.min">
                    <img-Zoom :previewImg="data.min" :zoomImg="data.max"></img-Zoom>
                  </div>
                  <div class="LibraryOfGoodsIndex_center_content_bigimg_none" v-else></div>
                </div>
                <div class="LibraryOfGoodsIndex_center_content_samll">
                  <ul>
                    <li v-for="(data_smalls, index) in data_small" :key="index" :class="{actives : index == page_index}" @mouseover="page_index_change(index,data_smalls.min,data_smalls.max)">
                      <img :src="data_smalls.min" alt="">
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
          particulars_loading: true
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
              min: 'https://img.alicdn.com/imgextra/i3/2857774462/TB21fgcwwNlpuFjy0FfXXX3CpXa_!!2857774462.jpg_430x430q90.jpg',
              max: 'https://img.alicdn.com/imgextra/i3/2857774462/TB21fgcwwNlpuFjy0FfXXX3CpXa_!!2857774462.jpg'
            },
            {
              min: 'https://gd4.alicdn.com/imgextra/i4/1642570643/TB25JlBk5CYBuNkSnaVXXcMsVXa_!!1642570643.jpg_400x400.jpg_.webp',
              max: 'https://gd4.alicdn.com/imgextra/i4/1642570643/TB25JlBk5CYBuNkSnaVXXcMsVXa_!!1642570643.jpg_400x400.jpg_.webp'
            },
            {
              min: 'https://gd2.alicdn.com/imgextra/i2/1642570643/TB2bew.kRyWBuNkSmFPXXXguVXa_!!1642570643.jpg_400x400.jpg_.webp',
              max: 'https://gd2.alicdn.com/imgextra/i2/1642570643/TB2bew.kRyWBuNkSmFPXXXguVXa_!!1642570643.jpg_400x400.jpg_.webp'
            },
            {
              min: 'https://img.alicdn.com/imgextra/i3/2857774462/TB21fgcwwNlpuFjy0FfXXX3CpXa_!!2857774462.jpg_430x430q90.jpg',
              max: 'https://img.alicdn.com/imgextra/i3/2857774462/TB21fgcwwNlpuFjy0FfXXX3CpXa_!!2857774462.jpg'
            },
            {
              min: 'https://gd4.alicdn.com/imgextra/i4/1642570643/TB25JlBk5CYBuNkSnaVXXcMsVXa_!!1642570643.jpg_400x400.jpg_.webp',
              max: 'https://gd4.alicdn.com/imgextra/i4/1642570643/TB25JlBk5CYBuNkSnaVXXcMsVXa_!!1642570643.jpg_400x400.jpg_.webp'
            },
            {
              min: 'https://gd2.alicdn.com/imgextra/i2/1642570643/TB2bew.kRyWBuNkSmFPXXXguVXa_!!1642570643.jpg_400x400.jpg_.webp',
              max: 'https://gd2.alicdn.com/imgextra/i2/1642570643/TB2bew.kRyWBuNkSmFPXXXguVXa_!!1642570643.jpg_400x400.jpg_.webp'
            }
          )
          this.data.min = this.data_small[0].min
          this.data.max = this.data_small[0].max
          let _this = this
          setTimeout(function () {
            _this.particulars_loading = false
          }, 2000)
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
    margin-right: 20px;
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
    width: 618px;
    min-height: 501px;
    float: right;
    border: 1px solid #000;
  }
</style>
