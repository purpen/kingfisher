<template>
    <div>
      <div id="main" ref="test1" :style="{width: '300px', height: '300px'}"></div>
    </div>
</template>

<script>
  import echarts from 'echarts/lib/echarts'
  require('echarts/lib/chart/bar')
  export default {
    name: 'EchartsTest',
    data () {
      return {}
    },
    methods: {
      drawLine () {
        console.log(document.getElementById('main'))
        console.log(this.$refs.test1)
        var myChart = echarts.init(document.getElementById('main'))
        myChart.setOption({
          title: {
            text: 'ECharts 入门示例'
          },
          tooltip: {},
          xAxis: {
            data: ['衬衫', '羊毛衫', '雪纺衫', '裤子', '高跟鞋', '袜子']
          },
          yAxis: {},
          series: [{
            name: '销量',
            type: 'bar',
            data: [5, 20, 36, 10, 10, 20]
          }]
        })
      }
    },
    mounted () {
      this.drawLine()
    },
    components: {}
  }
</script>

<style scoped>

</style>
