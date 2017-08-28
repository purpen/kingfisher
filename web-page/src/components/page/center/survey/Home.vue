<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <v-menu currentName="home"></v-menu>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <div class="blank20"></div>
      <div class="item">
        <div class="title">
          <h3>销售额</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="trendsDateOptions" :value="lastMonthDate()" placement="bottom-end" placeholder="选择日期" @on-change="changeTrendsDate" @on-ok="sureDate(1)"></Date-picker>
        </div>
        <div id="trends"></div>
      </div>

      <div class="item">
        <div class="title">
          <h3>销售订单</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="trendsDateOptions" :value="lastMonthDate()" placement="bottom-end" placeholder="选择日期" @on-change="changeOrderDate" @on-ok="sureDate(2)"></Date-picker>
        </div>
        <div id="orderMap"></div>
      </div>

      <div class="item">
        <div class="title">
          <h3>24小时成功下单</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="trendsDateOptions" :value="lastMonthDate()" placement="bottom-end" placeholder="选择日期" @on-change="changeHourDate" @on-ok="sureDate(3)"></Date-picker>
        </div>
        <div id="hourMap"></div>
      </div>

      <div class="item">
        <div class="title">
          <h3>销售排行榜</h3>
        </div>
        <div id="rankBox">
          <Table :columns="rankLabel" :data="rankData"></Table>
        
        </div>
      </div>
    
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/survey/Menu'
// 引入 ECharts 主模块
import echarts from 'echarts/lib/echarts'
require('echarts-gl')

// 引入线性图
require('echarts/lib/chart/line')
// 引入时间轴
require('echarts/lib/component/timeline')
// 引入提示框和标题组件
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
// 引入主题
require('echarts/theme/macarons')

export default {
  name: 'center_survey_home',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      trendsDate: '',
      orderDate: '',
      hourDate: '',
      trendsDateOptions: {
        shortcuts: [
          {
            text: '最近一周',
            value () {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
              return [start, end]
            }
          },
          {
            text: '最近一个月',
            value () {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
              return [start, end]
            }
          },
          {
            text: '最近三个月',
            value () {
              const end = new Date()
              const start = new Date()
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
              return [start, end]
            }
          }
        ]
      },
      trendsChart: '',
      orderChart: '',
      hourChart: '',
      sdata: [],
      rankLabel: [
        {
          title: '序号',
          key: 'no',
          width: 80
        },
        {
          title: '产品名称',
          key: 'title',
          width: 500
        },
        {
          title: '销售数量',
          key: 'sale_count'
        },
        {
          title: '销售额',
          key: 'sale_money'
        },
        {
          title: '占比',
          key: 'ratio'
        }
      ],
      rankData: [],
      msg: '统计图'
    }
  },
  methods: {
    // 确定选择的日期
    sureDate (evt) {
      switch (evt) {
        case 1:
          if (this.trendsDate) {
            this.saleTrendMoney(this.trendsDate[0], this.trendsDate[1])
          }
          break
        case 2:
          if (this.orderDate) {
            this.saleTrendMoney(this.orderDate[0], this.orderDate[1])
          }
          break
        case 3:
          if (this.hourDate) {
            this.saleHourOrder(this.hourDate[0], this.hourDate[1])
          }
          break
      }
    },
    changeTrendsDate (date) {
      this.trendsDate = date
    },
    changeOrderDate (date) {
      this.orderDate = date
    },
    changeHourDate (date) {
      this.hourDate = date
    },
    // 近一个月内时间
    lastMonthDate () {
      const end = new Date()
      const start = new Date()
      end.setTime(end.getTime() - 3600 * 1000 * 24 * 1)
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 31)
      return [start, end]
    },
    // 销售额统计
    saleTrendMoney (beginTime, endTime) {
      const self = this
      console.log(beginTime)
      console.log(endTime)
      self.$http.get(api.surveySalesTrends, {params: {start_time: beginTime, end_time: endTime}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          var days = []
          var amount = []
          for (var i = 0; i < response.data.data.length; i++) {
            days.push(response.data.data[i].time)
            amount.push(response.data.data[i].sum_money)
          }
          self.trendsChart.hideLoading()
          self.trendsChart.setOption({
            tooltip: {},
            xAxis: {
              name: '日期(天)',
              data: days
            },
            yAxis: {
              name: '销售额(元)'
            },
            series: [{
              name: '销量',
              type: 'line',
              data: amount
            }]
          })
        }
      })
      .catch(function (error) {
        self.isLoading = false
        self.$Message.error(error.message)
      })
    },
    // 销售订单统计
    saleTrendOrder (beginTime, endTime) {
      const self = this
      self.$http.get(api.surveySalesTrends, {params: {start_time: beginTime, end_time: endTime}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          var days = []
          var orderCount = []
          for (var i = 0; i < response.data.data.length; i++) {
            days.push(response.data.data[i].time)
            orderCount.push(response.data.data[i].order_count)
          }
          self.orderChart.hideLoading()
          self.orderChart.setOption({
            tooltip: {},
            xAxis: {
              name: '日期(天)',
              data: days
            },
            yAxis: {
              name: '订单数(个)'
            },
            series: [{
              name: '销量',
              type: 'line',
              data: orderCount
            }]
          })
        }
      })
      .catch(function (error) {
        self.isLoading = false
        self.$Message.error(error.message)
      })
    },
    // 24小时成功下单统计
    saleHourOrder (beginTime, endTime) {
      var hdata = [ ['0点', 15], ['1点', 30], ['2点', 120], ['3点', 99], ['4点', 290], ['5点', 180], ['6点', 5], ['7点', 70], ['8点', 560], ['9点', 599], ['10点', 690], ['11点', 980] ]
      const self = this
      self.$http.get(api.surveySalesTrends, {params: {start_time: beginTime, end_time: endTime}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          var days = []
          var orderCount = []
          for (var i = 0; i < response.data.data.length; i++) {
            days.push(response.data.data[i].time)
            orderCount.push(response.data.data[i].order_count)
          }
          self.hourChart.hideLoading()
          self.hourChart.setOption({
            xAxis: {
              name: '小时',
              data: hdata.map(function (item) {
                return item[0]
              })
            },
            yAxis: {
              name: '订单数(个)'
            },
            tooltip: {},
            series: [{
              name: '销量',
              type: 'line',
              data: hdata.map(function (item) {
                return item[1]
              })
            }]
          })
        }
      })
      .catch(function (error) {
        self.isLoading = false
        self.$Message.error(error.message)
      })
    }
  },
  mounted: function () {
    const self = this
    self.isLoading = true

    // 初始化echarts实例 --- 销售额
    self.trendsChart = echarts.init(document.getElementById('trends'), 'macarons')
    self.trendsChart.showLoading()

    // 初始化echarts实例 --- 销售订单
    self.orderChart = echarts.init(document.getElementById('orderMap'), 'macarons')
    self.orderChart.showLoading()

    // 初始化echarts实例 --- 销售订单
    self.hourChart = echarts.init(document.getElementById('hourMap'), 'macarons')
    self.hourChart.showLoading()

    var lastMonth = self.lastMonthDate()
    this.saleTrendMoney(lastMonth[0], lastMonth[1])
    this.saleTrendOrder(lastMonth[0], lastMonth[1])
    this.saleHourOrder(lastMonth[0], lastMonth[1])

    // 销售排行榜
    self.$http.get(api.surveySalesRanking, {start_time: '2016-10-01', end_time: '2016-12-31'})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        var item = response.data.data
        var newItem = []
        for (var i = 0; i < item.length; i++) {
          var d = {
            no: i + 1,
            title: item[i].sku_name,
            sale_count: item[i].sales_quantity,
            sale_money: '¥' + item[i].sum_money,
            ratio: item[i].proportion + '%'
          }
          newItem.push(d)
        } // endfor
        self.rankData = newItem
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })
  },
  created: function () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .item {
    margin: 10px 0 50px 0;
  }
  .item .title {
    height: 30px;
    margin: 10px 0;
  }
  .item .title h3 {
    font-size: 1.8rem;
    line-height: 30px;
    float: left;
  }

  .item .title .select-date {
    width: 200px;
    float: right;
  }

  #trends, #orderMap, #hourMap {
    width: 100%;
    height: 450px;
    border: 1px solid #ccc;
  }


</style>
