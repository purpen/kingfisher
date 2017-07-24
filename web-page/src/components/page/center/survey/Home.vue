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
          <Date-picker type="daterange" confirm class="select-date" :options="trendsDateOptions" placement="bottom-end" placeholder="选择日期" @on-change="changeDate(this, 1)" @on-ok="sureDate(1)"></Date-picker>
        </div>
        <div id="trends"></div>
      </div>

      <div class="item">
        <div class="title">
          <h3>销售订单</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="trendsDateOptions" placement="bottom-end" placeholder="选择日期" @on-change="changeDate(this, 2)" @on-ok="sureDate(2)"></Date-picker>
        </div>
        <div id="orderMap"></div>
      </div>

      <div class="item">
        <div class="title">
          <h3>24小时成功下单</h3>
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
// 引入线性图
require('echarts/lib/chart/line')
// 引入时间轴
require('echarts/lib/component/timeline')
// 引入提示框和标题组件
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')

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
      const self = this
      switch (evt) {
        case 1:
          self.trendsChart.setOption({
            xAxis: {
              data: self.sdata.slice(5, 10).map(function (item) {
                return item[0]
              })
            },
            series: [{
              data: self.sdata.slice(5, 10).map(function (item) {
                return item[1]
              })
            }]
          })
          break
        case 2:
          self.orderChart.setOption({
            xAxis: {
              data: self.sdata.slice(5, 10).map(function (item) {
                return item[0]
              })
            },
            series: [{
              data: self.sdata.slice(5, 10).map(function (item) {
                return item[1]
              })
            }]
          })
          break
      }
    },
    changeDate (date, evt) {
      switch (evt) {
        case 1:
          this.trendsDate = date
          break
        case 2:
          this.orderDate = date
          break
      }
    }
  },
  mounted: function () {
    const self = this
    self.isLoading = true

    // 初始化echarts实例 --- 销售额
    self.trendsChart = echarts.init(document.getElementById('trends'))
    self.trendsChart.showLoading()

    // 初始化echarts实例 --- 销售订单
    self.orderChart = echarts.init(document.getElementById('orderMap'))
    self.orderChart.showLoading()

    // 初始化echarts实例 --- 销售订单
    self.hourChart = echarts.init(document.getElementById('hourMap'))
    self.hourChart.showLoading()

    self.sdata = [
      ['2016-12-01', 15], ['2016-12-02', 30], ['2016-12-03', 120], ['2016-12-05', 99], ['2016-12-06', 290], ['2016-12-08', 180],
      ['2016-12-09', 5], ['2016-12-10', 70], ['2016-12-11', 560], ['2016-12-11', 599], ['2016-12-12', 690], ['2016-12-13', 980],
      ['2016-12-15', 15], ['2016-12-16', 700], ['2016-12-17', 160], ['2016-12-18', 399], ['2016-12-19', 1090], ['2016-12-20', 80],
      ['2016-12-09', 5], ['2016-12-10', 90], ['2016-12-11', 560], ['2016-12-11', 599], ['2016-12-12', 690], ['2016-12-13', 980],
      ['2016-12-25', 15], ['2016-12-26', 290], ['2016-12-27', 60], ['2016-12-28', 199], ['2016-12-29', 50], ['2016-12-30', 20],
      ['2017-01-01', 15], ['2017-01-02', 300], ['2017-01-03', 10], ['2017-01-05', 39], ['2017-01-06', 200], ['2017-01-08', 120],
      ['2017-02-09', 5], ['2017-02-10', 90], ['2017-02-11', 60], ['2017-02-11', 199], ['2017-02-12', 990], ['2017-02-13', 280]
    ]

    // 销售额
    self.$http.get(api.surveySalesTrends, {start_time: '2016-10-01', end_time: '2016-12-31'})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        // 销售额
        self.trendsChart.hideLoading()
        self.trendsChart.setOption({
          tooltip: {},
          xAxis: {
            name: '日期(天)',
            data: self.sdata.map(function (item) {
              return item[0]
            })
          },
          yAxis: {
            name: '销售额(元)'
          },
          series: [{
            name: '销量',
            type: 'line',
            data: self.sdata.map(function (item) {
              return item[1]
            })
          }]
        })

        // 销售订单
        self.orderChart.hideLoading()
        self.orderChart.setOption({
          tooltip: {},
          xAxis: {
            name: '日期(天)',
            data: self.sdata.map(function (item) {
              return item[0]
            })
          },
          yAxis: {
            name: '订单数(个)'
          },
          series: [{
            name: '销量',
            type: 'line',
            data: self.sdata.map(function (item) {
              return item[1]
            })
          }]
        })
        console.log(response.data)
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })

    var hdata = [ ['0点', 15], ['1点', 30], ['2点', 120], ['3点', 99], ['4点', 290], ['5点', 180], ['6点', 5], ['7点', 70], ['8点', 560], ['9点', 599], ['10点', 690], ['11点', 980] ]

    // 24小时成功下单
    self.$http.get(api.surveyHourOrder, {start_time: '2016-10-01', end_time: '2016-12-31'})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        // 销售订单
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
        console.log(response.data)
      }
    })
    .catch(function (error) {
      self.isLoading = false
      self.$Message.error(error.message)
    })

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
        console.log('rank')
        console.log(item)
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
