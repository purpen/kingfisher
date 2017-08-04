<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <v-menu currentName="customer"></v-menu>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
       <div class="blank20"></div>
      <div class="item">
        <div class="title">
          <h3>销售客单价</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="customerDateOptions" placement="bottom-end" :value="lastMonthDate()" placeholder="选择日期" @on-change="changeDate" @on-ok="sureDate(1)"></Date-picker>
        </div>
        <div id="customer"></div>
      </div>   
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/survey/Menu'
// 引入 ECharts 主模块
import echarts from 'echarts/lib/echarts'
// 引入柱状图
require('echarts/lib/chart/bar')
// 引入时间轴
require('echarts/lib/component/timeline')
// 引入提示框和标题组件
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
// 加载主题
require('echarts/theme/macarons')
export default {
  name: 'center_survey_source',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      itemList: [],
      customerChart: '',
      customerDate: '',
      customerDateOptions: {
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
      msg: '销售客单价'
    }
  },
  methods: {
    // 确定选择的日期
    sureDate (evt) {
      if (this.customerDate) {
        this.loadData(this.customerDate[0], this.customerDate[1])
      }
    },
    changeDate (date) {
      this.customerDate = date
    },
    // 近一个月内时间
    lastMonthDate () {
      const end = new Date()
      const start = new Date()
      end.setTime(end.getTime() - 3600 * 1000 * 24 * 1)
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 31)
      return [start, end]
    },
    // 加载数据
    loadData (beginTime, endTime) {
      const self = this
      self.$http.get(api.surveyCustomerPriceDistribution, {start_time: beginTime, end_time: endTime})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          // 销售额
          self.customerChart.hideLoading()
          self.customerChart.setOption({
            color: ['#3398DB'],
            tooltip: {
              trigger: 'axis',
              axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
              }
            },
            grid: {
              left: '3%',
              right: '4%',
              bottom: '3%',
              containLabel: true
            },
            xAxis: [
              {
                type: 'category',
                data: ['大于等于100元', '200元', '300元', '400元', '500元', '800元', '2000元', '小于等于3000元'],
                axisTick: {
                  alignWithLabel: true
                }
              }
            ],
            yAxis: [
              {
                name: '订单数(个)',
                type: 'value'
              }
            ],
            series: [
              {
                name: '直接访问',
                type: 'bar',
                barWidth: '60%',
                data: [10, 52, 200, 334, 390, 330, 220, 520]
              }
            ]
          })

          console.log(response.data)
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
    // 初始化echarts实例 --- 客单价
    self.customerChart = echarts.init(document.getElementById('customer'), 'macarons')
    self.customerChart.showLoading()

    var lastMonth = self.lastMonthDate()
    this.loadData(lastMonth[0], lastMonth[1])
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

  #customer {
    width: 100%;
    height: 450px;
    border: 1px solid #ccc;
  }


</style>
