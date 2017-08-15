<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <v-menu currentName="source"></v-menu>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
       <div class="blank20"></div>
      <div class="item">
        <div class="title">
          <h3>销售渠道</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="sourceDateOptions" placement="bottom-end" :value="lastMonthDate()" placeholder="选择日期" @on-change="changeDate" @on-ok="sureDate(1)"></Date-picker>
        </div>
        <div id="source"></div>
      </div>   
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/survey/Menu'
// 引入 ECharts 主模块
import echarts from 'echarts/lib/echarts'
// 引入主题
require('echarts/theme/macarons')
// 引入饼图
require('echarts/lib/chart/pie')
// 引入时间轴
require('echarts/lib/component/timeline')
// 引入提示框和标题组件
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
export default {
  name: 'center_survey_source',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      itemList: [],
      sourceChart: '',
      sourceDate: '',
      sourceDateOptions: {
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
      msg: '销售渠道'
    }
  },
  methods: {
    // 确定选择的日期
    sureDate (evt) {
      if (this.sourceDate) {
        this.loadData(this.sourceDate[0], this.sourceDate[1])
      }
    },
    changeDate (date) {
      this.sourceDate = date
    },
    // 近一个月内时间
    lastMonthDate () {
      const end = new Date()
      const start = new Date()
      end.setTime(end.getTime() - 3600 * 1000 * 24 * 1)
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 31)
      return [start, end]
    },
    // 销售渠道数据加载
    loadData (beginTime, endTime) {
      const self = this
      // 销售渠道
      self.$http.get(api.surveySourceSales, {params: {start_time: beginTime, end_time: endTime}})
      .then(function (response) {
        self.isLoading = false
        if (response.data.meta.status_code === 200) {
          var items = []
          for (var i = 0; i < response.data.data.length; i++) {
            var item = {
              name: response.data.data[i].name,
              value: response.data.data[i].count
            }
            items.push(item)
          }
          self.sourceChart.hideLoading()
          self.sourceChart.setOption({
            tooltip: {
              trigger: 'item',
              formatter: '{a} <br/>{b}: {c} ({d}%)'
            },
            legend: {
              orient: 'vertical',
              x: 'left'
            },
            series: [
              {
                name: '访问来源',
                type: 'pie',
                radius: ['70%', '90%'],
                avoidLabelOverlap: false,
                label: {
                  normal: {
                    show: false,
                    position: 'center'
                  },
                  emphasis: {
                    show: true,
                    textStyle: {
                      fontSize: '30',
                      fontWeight: 'bold'
                    }
                  }
                },
                labelLine: {
                  normal: {
                    show: false
                  }
                },
                data: items
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
    // 初始化echarts实例 --- 销售渠道
    self.sourceChart = echarts.init(document.getElementById('source'), 'macarons')
    self.sourceChart.showLoading()

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

  #source {
    width: 100%;
    height: 450px;
    border: 1px solid #ccc;
  }


</style>
