<template>
<div>
  <div class="LibraryOfGoodsList_notList" v-if="theme_Shopping.length<=0">
    抱歉,暂无数据
  </div>
  <div class="LibraryOfGoodsList_List" v-else>
    <Col span="6" v-for="(theme_Shoppings, index) in theme_Shopping" :key="index">
      <div class="LibraryOfGoodsList_List_content" @click.self="theme_Shoppings_ids(theme_Shoppings.ids)">
        <div class="img_div">
          <img v-if="theme_Shoppings.img" :src="theme_Shoppings.img" @click.self="theme_Shoppings_ids(theme_Shoppings.ids)" class="big_img" alt="">
          <img v-else src="../../assets/images/product_500.png" @click.self="theme_Shoppings_ids(theme_Shoppings.ids)" />
          <p @click.self="theme_Shoppings_click(index)" v-if="theme_Shoppings.lengths===0">
            <img src="../../assets/images/libraryOfGoods/icon-xingz.png" alt="">
            <i>关注</i>
          </p>
          <p @click="theme_Shoppings_click(index)" v-else-if="theme_Shoppings.lengths===1">
            <img src="../../assets/images/libraryOfGoods/icon-redxin.png" alt="">
            <i>已关注</i>
          </p>
        </div>
        <div class="price_div" @click="theme_Shoppings_ids(theme_Shoppings.ids)">
          &#165;&nbsp;{{theme_Shoppings.money}}
        </div>
        <div class="LibraryOfGoodsList_Text_Description" @click="theme_Shoppings_ids(theme_Shoppings.ids)">
          <p>{{theme_Shoppings.text.replace(/(\s)*([a-zA-Z0-9]+|\W)(\.\.\.)?$/,"...")}}</p>
        </div>
      </div>
    </Col>
  </div>
  <div v-if="isShow_LibraryOfGoodsList" class="isShow_LibraryOfGoodsList_show">
    <Spin fix class="LibraryOfGoodsList_List_loding"></Spin>
  </div>
</div>
</template>

<script>
    export default {
      name: 'LibraryOfGoodsList',
      data () {
        return {
          Bus: this.$BusFactory(this),
          isShow_LibraryOfGoodsList: false // 遮罩层是否显示
//          theme_Shoppingser: this.theme_Shopping
        }
      },
      props: ['theme_Shopping'],
      components: {},
      methods: {
        theme_Shoppings_ids (ids) {
          this.$router.push({name: 'CommodityDetailsIndex', params: {id: ids}})
          console.log(ids) // 通过id进入详情界面
        },
        theme_Shoppings_click (e) {
          // 改变状态请求数据关注未关注
          console.log(e)
          if (this.theme_Shopping[e].lengths === 0) {
            this.theme_Shopping[e].lengths = 1
            this.$Message.success('关注成功')
          } else if (this.theme_Shopping[e].lengths === 1) {
            this.theme_Shopping[e].lengths = 0
            this.$Message.success('取消关注成功')
          }
        }
      },
      created: function () {
        this.Bus.$on('LibraryOfGoodsList_lodings', (em) => { // 开启等待
          this.isShow_LibraryOfGoodsList = true
        })
        this.Bus.$on('LibraryOfGoodsList_lodings_clear', (em) => { // 关闭等待
          this.isShow_LibraryOfGoodsList = false
        })
      },
      mounted () {

      },
      watch: {}
    }
</script>

<style scoped>
.LibraryOfGoodsList_notList{
  width: 100%;
  height: 100px;
  line-height: 100px;
  font-size: 16px;
  text-align: center;
}
.LibraryOfGoodsList_List{
  position: relative;
  top: 0;
}
.isShow_LibraryOfGoodsList_show{
  min-height: 500px;
}
.LibraryOfGoodsList_List_loding{
  min-height: 500px;
}
.LibraryOfGoodsList_List_content{
  height: 370px;
  margin: 0 13px;
  border: 1px solid rgba(240,240,240,1);
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 38px;
  clear: both;
  min-width: 218px;
}
.LibraryOfGoodsList_List_content:hover{
  border: 1px solid #ED3A4A;
}
.LibraryOfGoodsList_List_content div.img_div{
  width: 100%;
  min-width: 218px;
  min-height: 218px;
  position: relative;
  overflow: hidden;
}
.LibraryOfGoodsList_List_content div.img_div p{
  position: absolute;
  height: 25px;
  bottom: -25px;
  border: 1px solid #ED3A4A;
  padding: 0 12px;
  background: rgba(225,225,225,0.74);
  right: 0;
  border-radius:15px;
  cursor:pointer;
  -webkit-transition: bottom .3s;
  -moz-transition: bottom .3s;
  -o-transition: bottom .3s;
  transition: bottom .3s;
}
.LibraryOfGoodsList_List_content:hover div.img_div p{
  bottom: 1px;
}
.LibraryOfGoodsList_List_content div.img_div p:hover{
  bottom: 1px;
}
.LibraryOfGoodsList_List_content div.img_div p img{
  width: 19px;
  height: 17px;
  margin: 3px 5px 3px 0;
  vertical-align: middle;
  float: left;
}
.LibraryOfGoodsList_List_content div.img_div p i{
  float: right;
  height: 25px;
  font-size: 16px;
  color: #ED3A4A;
  line-height: 25px;
  overflow: hidden;
}
.LibraryOfGoodsList_List_content div.img_div img.big_img{
  width: 100%;
  max-height: 218px;
  min-width: 220px;
}
.LibraryOfGoodsList_List_content div.price_div{
  margin-top: 14px;
  width: 100%;
  height: 20px;
  font-size: 16px;
  padding: 0 13px;
  overflow: hidden;
  text-overflow: ellipsis;
  -o-text-overflow: ellipsis;
  white-space:nowrap;
  color: #ED3A4A;
  line-height: 20px;
  text-align: left;
}
.LibraryOfGoodsList_Text_Description {
  width: 100%;
  padding: 0 13px;
  margin-top: 13px;
}
.LibraryOfGoodsList_Text_Description p{
  font-size:14px;
  text-align: left;
  width: 100%;
  line-height: 18px;
  line-clamp: 2;
  display: -webkit-box;
  box-orient: vertical;
  overflow: hidden;
}
@media screen and (min-width: 1450px) and (max-width: 2500px) {
  .LibraryOfGoodsList_List_content {
    width: 250px;
    height: 390px;
    margin: 0 auto;
    margin-bottom: 38px;
  }
  .LibraryOfGoodsList_List_content div.img_div{
    max-width: 248px;
    max-height: 248px;
    min-width: 248px;
    min-height: 248px;
  }
  .LibraryOfGoodsList_List_content div.img_div img.big_img{
    max-width: 248px;
    max-height: 248px;
  }
}
@media screen and (min-width: 1250px) and (max-width: 1450px) {
  .LibraryOfGoodsList_List_content {
    width: 220px;
    height: 360px;
    margin: 0 auto;
    margin-bottom: 38px;
  }
  .LibraryOfGoodsList_List_content div.img_div{
    max-width: 218px;
    max-height: 218px;
    min-width: 218px;
    min-height: 218px;
  }
  .LibraryOfGoodsList_List_content div.img_div img.big_img{
    max-width: 218px;
    max-height: 218px;
    min-width: 218px;
    min-height: 218px;
  }
  .LibraryOfGoodsList_Text_Description p{
    font-size:14px;
  }
}
@media screen and (min-width: 300px) and (max-width: 1250px) {
  .LibraryOfGoodsList_List_content {
    width: 220px;
    height: 360px;
    margin: 0 auto;
    margin-bottom: 38px;
  }
  .LibraryOfGoodsList_List_content div.img_div{
    max-width: 218px;
    max-height: 218px;
    min-width: 218px;
    min-height: 218px;
  }
  .LibraryOfGoodsList_List_content div.img_div img.big_img{
    max-width: 218px;
    max-height: 218px;
  }
  .LibraryOfGoodsList_Text_Description p{
    font-size:14px;
  }
}
</style>
