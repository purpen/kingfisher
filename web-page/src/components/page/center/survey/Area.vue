<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <v-menu currentName="area"></v-menu>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
       <div class="blank20"></div>
      <div class="item">
        <div class="title">
          <h3>地域分布</h3>
          <Date-picker type="daterange" confirm class="select-date" :options="areaDateOptions" placement="bottom-end" placeholder="选择日期" @on-change="changeDate(this, 1)" @on-ok="sureDate(1)"></Date-picker>
        </div>
        <div id="areaMap"></div>
      </div>   
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/survey/Menu'
// 引入 ECharts 主模块
import echarts from 'echarts'

export default {
  name: 'center_survey_area',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      itemList: [],
      areaChart: '',
      areaDate: '',
      areaDateOptions: {
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
      // this.areaChart.setOption({})
    },
    changeDate (date, evt) {
      this.areaDate = date
    }
  },
  mounted: function () {
    const self = this
    self.isLoading = true

    var geoCoordMap = {
      '鄂尔多斯': [109.781327, 39.608266],
      '齐齐哈尔': [123.97, 47.33],
      '宜宾': [104.56, 29.77],
      '呼和浩特': [111.65, 40.82],
      '成都': [104.06, 30.67],
      '大同': [113.3, 40.12],
      '桂林': [110.28, 25.29],
      '宜兴': [119.82, 31.36],
      '北海': [109.12, 21.49],
      '渭南': [109.5, 34.52],
      '马鞍山': [118.48, 31.56],
      '宝鸡': [107.15, 34.38],
      '焦作': [113.21, 35.24],
      '句容': [119.16, 31.95],
      '北京': [116.46, 39.92],
      '长沙': [113, 28.21],
      '大庆': [125.03, 46.58]
    }

    var convertData = function (data) {
      var res = []
      for (var i = 0; i < data.length; i++) {
        var geoCoord = geoCoordMap[data[i].name]
        if (geoCoord) {
          res.push({
            name: data[i].name,
            value: geoCoord.concat(data[i].value)
          })
        }
      }
      return res
    }

    var chinaJson = require('@/chinaMap')
    // 初始化echarts实例 --- 地域分布
    echarts.registerMap('china', chinaJson)
    self.areaChart = echarts.init(document.getElementById('areaMap'))
    self.areaChart.showLoading()

    // 销售渠道
    self.$http.get(api.surveyOrderDistribution, {start_time: '2016-10-01', end_time: '2016-12-31'})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        // 销售额
        self.areaChart.hideLoading()
        self.areaChart.setOption({
          backgroundColor: '#404a59',
          title: {
            text: '',
            subtext: '',
            sublink: '',
            show: false,
            x: 'center',
            textStyle: {
              color: '#fff'
            }
          },
          tooltip: {
            trigger: 'item',
            formatter: function (params) {
              return params.name + ' : ' + params.value[2]
            }
          },
          legend: {
            orient: 'vertical',
            y: 'bottom',
            x: 'right',
            data: ['pm2.5'],
            textStyle: {
              color: '#fff'
            }
          },
          visualMap: {
            min: 0,
            max: 300,
            calculable: true,
            inRange: {
              color: ['#50a3ba', '#eac736', '#d94e5d']
            },
            textStyle: {
              color: '#fff'
            }
          },
          geo: {
            map: 'china',
            label: {
              emphasis: {
                show: false
              }
            },
            itemStyle: {
              normal: {
                areaColor: '#323c48',
                borderColor: '#111'
              },
              emphasis: {
                areaColor: '#2a333d'
              }
            }
          },
          series: [
            {
              name: 'pm2.5',
              type: 'scatter',
              coordinateSystem: 'geo',
              data: convertData([
                {name: '鄂尔多斯', value: 12},
                {name: '齐齐哈尔', value: 14},
                {name: '宜宾', value: 58},
                {name: '呼和浩特', value: 58},
                {name: '成都', value: 58},
                {name: '大同', value: 58},
                {name: '桂林', value: 59},
                {name: '北海', value: 60},
                {name: '渭南', value: 72},
                {name: '宝鸡', value: 72},
                {name: '焦作', value: 75},
                {name: '句容', value: 75},
                {name: '北京', value: 79},
                {name: '长沙', value: 175},
                {name: '大庆', value: 279}
              ]),
              symbolSize: 12,
              label: {
                normal: {
                  show: false
                },
                emphasis: {
                  show: false
                }
              },
              itemStyle: {
                emphasis: {
                  borderColor: '#fff',
                  borderWidth: 1
                }
              }
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

  #areaMap {
    width: 100%;
    height: 450px;
    border: 1px solid #ccc;
  }


</style>
