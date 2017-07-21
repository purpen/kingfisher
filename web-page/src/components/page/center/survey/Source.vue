<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <v-menu currentName="source"></v-menu>
    <div class="">
      <Spin size="large" fix v-if="isLoading"></Spin>
    
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
      msg: '销售渠道'
    }
  },
  methods: {
  },
  created: function () {
    const self = this
    self.isLoading = true
    self.$http.get(api.surveySalesTrends, {})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
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
    height: 310px;
    margin: 10px 0;
  }

  .item img {
    width: 100%;
  }

  .image-box {
    height: 250px;
    overflow: hidden;
  }

  .content {
    padding: 10px;
  }
  .content a {
    font-size: 1.5rem;
  }

  .content .des {
    height: 30px;
    margin: 10px 0;
    overflow: hidden;
  }

  .content .des p {
    color: #666;
    font-size: 1.2rem;
    line-height: 1.3;
    text-overflow: ellipsis;
  }

  .content .des .price {
    float: left;
  }
  .content .des .inventory {
    float: right;
  }


</style>
