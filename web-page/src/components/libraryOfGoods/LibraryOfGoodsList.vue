<template>
<div>
  <div class="LibraryOfGoodsList_notList" v-if="theme_Shopping.length<=0">
    抱歉,暂无数据
  </div>
  <div class="LibraryOfGoodsList_List" v-else>
    <Col span="6" v-for="(theme_Shoppings, index) in theme_Shopping" :key="index">
      <div class="LibraryOfGoodsList_List_content" @click.self="theme_Shoppings_ids(theme_Shoppings.product_id)">
        <div class="img_div">
          <div>
            <img v-if="theme_Shoppings.image" :src="theme_Shoppings.image" @click.self="theme_Shoppings_ids(theme_Shoppings.product_id)" class="big_img" alt="">
            <img class="big_img"  src="../../assets/images/product_500.png" v-else @click.self="theme_Shoppings_ids(theme_Shoppings.product_id)" />
          </div>
          <p @click="theme_Shoppings_click(index)" v-if="theme_Shoppings.follow===0">
            <img src="../../assets/images/libraryOfGoods/icon-xingz.png" alt="">
            <i>关注</i>
          </p>
          <p class="actives" @click="theme_Shoppings_click(index)" v-else-if="theme_Shoppings.follow===1">
            <img src="../../assets/images/libraryOfGoods/icon-redxin-wirght.png" alt="">
            <i>已关注</i>
          </p>
          <p @click="theme_Shoppings_click(index)" v-else>
            <i class="failure_i">加载失败</i>
          </p>
        </div>
        <div class="price_div" @click="theme_Shoppings_ids(theme_Shoppings.product_id)">
          &#165;&nbsp;{{Math.floor(theme_Shoppings.price)}}
        </div>
        <div class="LibraryOfGoodsList_Text_Description" @click="theme_Shoppings_ids(theme_Shoppings.product_id)">
          <p>{{theme_Shoppings.name}}</p>
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
    import api from '@/api/api'
    export default {
      name: 'LibraryOfGoodsList',
      data () {
        return {
          Bus: this.$BusFactory(this),
          isShow_LibraryOfGoodsList: false, // 遮罩层是否显示
          this_follow: false // 是否完成收藏请求
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
          if (this.this_follow === false) {
            if (this.theme_Shopping[e].follow === 0) {
              this.this_follow = true
              this.$http({
                method: 'post',
                url: api.LibraryOfGoodsIndexfollow,
                data: {
                  product_id: e
                }
              })
              .then((res) => {
                let metas = res.data.meta
                if (metas.status_code === 200) {
                  this.theme_Shopping[e].follow = 1
                  this.$Message.success('关注成功')
                } else {
                  this.$Message.error(metas.message)
                }
                this.this_follow = false
              })
              .catch((res) => {
                this.$Message.error(res.message)
                this.this_follow = false
              })
            } else if (this.theme_Shopping[e].follow === 1) {
              this.this_follow = true
              this.$http({
                method: 'post',
                url: api.LibraryOfGoodsIndexnotFollow,
                data: {
                  user_id: this.$store.state.event.token,
                  product_id: e
                }
              })
              .then((res) => {
                let metas = res.data.meta
                if (metas.status_code === 200) {
                  this.theme_Shopping[e].follow = 0
                  this.$Message.success('取消关注成功')
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
            if (this.theme_Shopping[e].follow === 0) {
              this.$Message.warning('清等待收藏成功之后再取消收藏')
            } else if (this.theme_Shopping[e].follow === 1) {
              this.$Message.warning('清等待取消收藏成功之后再点击收藏')
            }
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
        console.log(this.theme_Shopping)
      },
      mounted () {

      },
      watch: {}
    }
</script>

<style scoped>
.LibraryOfGoodsList_notList{
  width: 100%;
  min-height: 398px;
  line-height: 398px;
  font-size: 18px;
  text-align: center;
}
.LibraryOfGoodsList_List{
  position: relative;
  top: 0;
}
.isShow_LibraryOfGoodsList_show{

}
.LibraryOfGoodsList_List_loding{

}
.LibraryOfGoodsList_List_content{
  width: 220px;
  height: 360px;
  margin: 0 auto;
  margin-bottom: 38px;
  border: 1px solid rgba(240,240,240,1);
  border-radius: 8px;
  overflow: hidden;
  clear: both;
  min-width: 218px;
}
.LibraryOfGoodsList_List_content:hover{
  border: 1px solid #ED3A4A;
}
.LibraryOfGoodsList_List_content div.img_div{
  max-width: 218px;
  max-height: 218px;
  min-width: 218px;
  min-height: 218px;
  position: relative;
  overflow: hidden;
}
.LibraryOfGoodsList_List_content div.img_div p{
  position: absolute;
  height: 26px;
  bottom: -26px;
  width: 80px;
  background: rgba(255, 255, 255, 0.8);
  right: 0;
  cursor:pointer;
  -webkit-transition: bottom .3s;
  -moz-transition: bottom .3s;
  -o-transition: bottom .3s;
  transition: bottom .3s;
  text-align: center;
}
.LibraryOfGoodsList_List_content div.img_div p.actives{
  background:rgba(237,58,74,1);
  color: #fff;
}
.LibraryOfGoodsList_List_content div.img_div p.actives i{
  color: #fff;
}
.LibraryOfGoodsList_List_content:hover div.img_div p{
  bottom: 0px;
}
.LibraryOfGoodsList_List_content div.img_div p:hover{
  bottom: 0;
}
.LibraryOfGoodsList_List_content div.img_div p img{
  width: 19px;
  height: 17px;
  margin: 5px 0 5px 6px;
  vertical-align: middle;
  float: left;
}
.LibraryOfGoodsList_List_content div.img_div p i{
  float: right;
  height: 26px;
  font-size: 14px;
  color: #ED3A4A;
  line-height: 26px;
  width: 55px;
  overflow: hidden;
}
.LibraryOfGoodsList_List_content div.img_div p i.failure_i{
  width: 80px;
}
.LibraryOfGoodsList_List_content div.img_div img.big_img{
  max-width: 218px;
  max-height: 218px;
  min-width: 218px;
  min-height: 218px;
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
  -webkit-line-clamp: 3;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
