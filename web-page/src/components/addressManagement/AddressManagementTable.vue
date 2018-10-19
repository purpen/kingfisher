<template>
  <div>
    <div class="adderss-table-wrapper">
      <div class="headers">
        <table>
          <thead>
          <tr>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">姓名</span>
              </div>
            </th>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">收货人</span>
              </div>
            </th>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">所在地区</span>
              </div>
            </th>
            <th class="ivu-table-column-left width200">
              <div class="ivu-table-cell">
                <span class="">地址</span>
              </div>
            </th>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">手机</span>
              </div>
            </th>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">固定电话</span>
              </div>
            </th>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">电子邮箱</span>
              </div>
            </th>
            <th class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span class="">邮编</span>
              </div>
            </th>
            <th class="ivu-table-column-left width120">
              <div class="ivu-table-cell">
                <span class="">操作</span>
              </div>
            </th>
            <th class="ivu-table-column-left width100">
              <div class="ivu-table-cell">
              </div>
            </th>
          </tr>
          </thead>
          <tbody v-if="dataTable.length>0">
          <tr class="table-row-hover" v-for="dataTables in dataTable">
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span>{{dataTables.name}}</span>
              </div>
            </td>
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span>{{dataTables.theConsignee}}</span>
              </div>
            </td>
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span>{{dataTables.region}}</span>
              </div>
            </td>
            <td class="ivu-table-column-left width200">
              <div class="ivu-table-cell">
                <span>{{dataTables.address}}</span>
              </div>
            </td>
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span>{{dataTables.mobilePhone}}</span>
              </div>
            </td>
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <span>{{dataTables.fixedTelephone}}</span>
              </div>
            </td>
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <div>{{dataTables.email}}</div>
              </div>
            </td>
            <td class="ivu-table-column-left">
              <div class="ivu-table-cell">
                <div>{{dataTables.zip}}</div>
              </div>
            </td>
            <td class="ivu-table-column-left width120">
              <div class="ivu-table-cell">
                <div class="operations">
                  <span class="sapn-color" @click="modifyThe(
                      {
                      name:dataTables.name,
                      theConsignee:dataTables.theConsignee,
                      region:dataTables.region,
                      address:dataTables.address,
                      mobilePhone:dataTables.mobilePhone,
                      fixedTelephone:dataTables.fixedTelephone,
                      email:dataTables.email,
                      state:dataTables.state,
                      ids:dataTables.ids,
                      zip:dataTables.zip,
                      province_id:dataTables.province_id,
                      city_id:dataTables.city_id,
                      county_id:dataTables.county_id,
                      town_id:dataTables.town_id
                      })">修改</span>
                  <span>&ensp;|&ensp;</span>
                  <span class="sapn-color" @click="deletes(dataTables.ids)">删除</span>
                </div>
              </div>
            </td>
            <td class="ivu-table-column-left width100">
              <div class="ivu-table-cell">
                <Button type="text" :size="buttonSize" v-if="dataTables.state==0" @click.native="setTheDefault(dataTables.ids)">设为默认</Button>
                <Button type="warning" :size="buttonSize" v-else-if="dataTables.state==1">默认地址</Button>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
        <div class="table-row-hover-tr" v-if="dataTable.length==0">
          暂无数据
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
  .adderss-table-wrapper{
    position: relative;
    border: 1px solid #dcdee2;
    border-bottom: 0;
    border-right: 0;
  }
  .headers {
    overflow: hidden;
  }
  .headers table {
    table-layout: fixed;
    width: 100%;
  }
  .headers thead{
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
  }
  .headers tr{
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
  }
  .headers th{
    text-align: center;
    border-right: 1px solid #e8eaec;
    height: 40px;
    white-space: nowrap;
    overflow: hidden;
    background-color: #f8f8f9;
    min-width: 0;
    box-sizing: border-box;
    text-overflow: ellipsis;
    vertical-align: middle;
    border-bottom: 1px solid #e8eaec;
  }
  .width200{
    width: 200px;
  }
  .width120{
    width: 120px;
  }
  .width100{
    width: 100px;
  }
  .headers table{
    table-layout: fixed;
    border-collapse: collapse;
    border-spacing: 0;
  }
  .headers tbody {
    display: table-row-group;
  }
  .headers tr{
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
    display: table-row;
  }
  .headers td{
    text-align: center;
    background-color: #fff;
    transition: background-color 0.2s ease-in-out;
    min-width: 0;
    height: 48px;
    box-sizing: border-box;
    text-overflow: ellipsis;
    vertical-align: middle;
    border-bottom: 1px solid #e8eaec;
    border-right: 1px solid #e8eaec;
  }
  .headers tr.table-row-hover:hover td{
    background-color: #ebf7ff;
  }
  .operations span{
    line-height: 20px;
  }
  .sapn-color:hover{
    color: #2d8cf0;
  }
  .ivu-btn-text:hover {
    background: rgba(0,0,0,0);
    color: #2d8cf0;
  }
  .ivu-btn-warning:hover{
    color: #fff;
    background-color: #ff9900;
    border-color: #ff9900;
  }
  .table-row-hover-tr{
    width: calc( 100% - 0.5px );
    height: 48px;
    line-height: 48px;
    border-bottom: 1px solid #e8eaec;
    border-right: 1px solid #e8eaec;
    text-align: center;
  }
</style>
