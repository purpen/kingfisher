<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <v-menu currentName="tag"></v-menu>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
       <div class="blank20"></div>
      <div class="item">
        <div class="title">
          <h3>Top20标签</h3>
        </div>
        <div class="tag-list">
          <a href="javascript:void(0);" v-for="(d, index) in itemList" :key="index" :class="d.cname">{{ d.tag }}</a>
        </div>
      </div>   
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
import vMenu from '@/components/page/center/survey/Menu'

export default {
  name: 'center_survey_source',
  components: {
    vMenu
  },
  data () {
    return {
      isLoading: false,
      itemList: [],
      msg: 'Top20标签'
    }
  },
  methods: {
  },
  mounted: function () {
    const self = this
    self.isLoading = true

    // Top标签
    self.$http.get(api.surveyTopFlag, {start_time: '2016-10-01', end_time: '2016-12-31'})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        var itemList = response.data.data
        var rows = []
        for (var i = 0; i < itemList.length; i++) {
          var rand = parseInt(Math.random() * (itemList.length + 1))
          var row = {
            tag: itemList[i],
            cname: 'tags' + rand
          }
          rows.push(row)
        }
        self.itemList = rows
        console.log(self.itemList)
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

  .tag-list {
    width: 100%;
    height: 450px;
  }

  .tag-list a {
    margin: 5px 2px;
  }

  .tag-list .ivu-tag {
    margin: 5px 10px;
    ling-height: 2;
    font-size: 1.5rem;
  }

  .tag-list .tags0{color:#F90;font-size: 22px;} 
  .tag-list .tags1{color:#C00; font-size:24px;} 
  .tag-list .tags2{color:#030; font-size:16px;} 
  .tag-list .tags3{color:#00F;}
  .tag-list .tags4{ font-size:16px;}
  .tag-list .tags5{color:#F00; font-size:20px;}
  .tag-list .tags6{color:#F06; font-size:30px;}
  .tag-list .tags7{color:#030; font-weight:bold; font-size:36px;} 
  .tag-list .tags8{color:#F06; font-weight:bold;} 
  .tag-list .tags9{color:#C00; font-weight:bold;font-size:26px;} 
  .tag-list .tags10{color:#090; font-weight:bold;font-size:18px;} 
  .tag-list .tags11{color:#09F; font-weight:bold;font-size:16px;} 
  .tag-list .tags12{color:#F90;font-size:14px;} 
  .tag-list a:hover{ color:#F00; text-decoration:underline;} 


</style>
