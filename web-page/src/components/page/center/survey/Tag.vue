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
          <Tag color="blue" v-for="(d, index) in itemList" :key="index">{{ d }}</Tag>
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
        self.itemList = response.data.data
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

  .tag-list {
    width: 100%;
    height: 450px;
  }

  .tag-list .ivu-tag {
    margin: 5px 10px;
    ling-height: 2;
    font-size: 1.5rem;
  }


</style>
