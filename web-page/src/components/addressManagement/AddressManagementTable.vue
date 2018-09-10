<template>
  <div>
    <div class="shipping_address_wrapper">
      <div class="LibraryOfGoodsIndex_center_content_merchandise_selectionnone" v-if="dataTable.length<=0">
        <img src="../../assets/images/empty-data.png" alt="">
      </div>
      <div class="shipping_address_wrapper_div" v-for="(dataTables, index) in dataTable" :key="index">
        <div class="shipping_address_wrapper_div_p">
          {{dataTables.name}}
          <span v-if="dataTables.state==1">默认地址</span>
        </div>
        <div class="shipping_address_wrapper_div_ul">
          <ul>
            <li>
              <span>收货人</span>
              <p>{{dataTables.name}}</p>
            </li>
            <li>
              <span>手机</span>
              <p>{{dataTables.mobilePhone}}</p>
            </li>
            <li>
              <span>所在地区</span>
              <p>{{dataTables.region}}</p>
            </li>
            <li>
              <span>地址</span>
              <p>{{dataTables.address}}</p>
            </li>
          </ul>
        </div>
        <div class="shipping_address_wrapper_div_button">
          <Button @click.native="deletes(dataTables.ids)">删除</Button>
          <Button @click="modifyThe(
                      {
                      name:dataTables.name,
                      region:dataTables.region,
                      address:dataTables.address,
                      mobilePhone:dataTables.mobilePhone,
                      state:dataTables.state,
                      ids:dataTables.ids,
                      province_id:dataTables.province_id,
                      city_id:dataTables.city_id,
                      county_id:dataTables.county_id,
                      town_id:dataTables.town_id
                      })">编辑</Button>
          <Button class="big_ivu-btn" v-if="dataTables.state==0" @click.native="setTheDefault(dataTables.ids)">设为默认</Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'addressManagementTable',
  data () {
    return {
      Bus: this.$BusFactory(this), // bus方法
      buttonSize: 'small' // button大小
    }
  },
  props: ['dataTable'],
  components: {},
  methods: {
    modifyThe: function (data) {
//      修改地址
//      console.log(
//        data.name,
//        data.theConsignee,
//        data.region,
//        data.address,
//        data.mobilePhone,
//        data.fixedTelephone,
//        data.email,
//        data.state,
//        data.ids
//      )
      this.Bus.$emit('erp-address-management-modifyThe', data)
    },
    deletes: function (data) {
      // 删除地址
      this.Bus.$emit('erp-address-management-deletion', data)
    },
    setTheDefault: function (data) {
      // 默认地址
      this.Bus.$emit('erp-address-management-setTheDefault', data)
    }
  },
  created: function () {

  },
  mounted () {

  },
  watch: {}
}
</script>

<style scoped>
  .shipping_address_wrapper{
    width: 749px;
    margin: 12px auto 55px auto;
  }
  .shipping_address_wrapper_div{
    width: 747px;
    height: 209px;
    border: 1px solid #c8c8c8;
    margin-bottom: 18px;
  }
  .shipping_address_wrapper_div_p{
    margin-top: 12px;
    margin-bottom: 14px;
    width: 749px;
    padding: 0 47px;
    font-size: 14px;
    height: 20px;
    line-height: 20px;
    text-align: left;
  }
  .shipping_address_wrapper_div_p span{
    font-size: 12px;
    float: right;
    color:rgba(153,153,153,1);
  }
  .shipping_address_wrapper_div_ul{
    width: 749px;
    padding: 0 95px;
    height: 95px;
    margin-bottom: 15px;
    float: left;
  }
  .shipping_address_wrapper_div_ul ul{
    width: 100%;
    height: 115px;
    float: left;
  }
  .shipping_address_wrapper_div_ul ul li{
    width: 100%;
    height: 18px;
    margin-bottom: 7px;
    line-height: 18px;
    font-size: 12px;
    color: #999999;
  }
  .shipping_address_wrapper_div_ul ul li span{
    display: inline-block;
    width: 70px;
    margin-right: 10px;
    text-align: left;
    float: left;
  }
  .shipping_address_wrapper_div_ul ul li p{
    width: 479px;
    height: 18px;
    line-height: 18px;
    text-align: left;
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
    float: right;
  }
  .shipping_address_wrapper_div_button{
    width: 749px;
    padding: 0 47px;
    height: 30px;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectionnone{
    width: 749px;
    height: 503px;
    font-size: 18px;
    text-align: center;
    margin: 0 auto;
  }
  .LibraryOfGoodsIndex_center_content_merchandise_selectionnone img{
    width: 280px;
    height: 280px;
    margin: 108px 227px;
  }
</style>
