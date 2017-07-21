<template>
  <div class="container min-height350">
    <div class="blank20"></div>
    <div class="item-list">
      <Spin size="large" fix v-if="isLoading"></Spin>
      <Row :gutter="20">

        <Col :span="6" v-for="(d, index) in itemList" :key="index">
          <Card :padding="0" class="item">
            <div class="image-box">
              <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">
                <img v-if="d.image" :src="d.image" style="width: 100%;" />
                <img v-else src="../../../assets/images/default_thn.png" style="width: 100%;" />
              </router-link>
            </div>
            <div class="content">
              <router-link :to="{name: 'productShow', params: {id: d.product_id}}" target="_blank">{{ d.name }}</router-link>
              <div class="des">
                <p class="price">¥ {{ d.price }}</p>
                <p class="inventory">库存: {{ d.inventory }}</p>
              </div>
            </div>
          </Card>
        </Col>

      </Row>
    
    </div>
    
  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'product',
  data () {
    return {
      isLoading: false,
      itemList: [],
      msg: '产品库'
    }
  },
  created: function () {
    const self = this
    self.isLoading = true
    self.$http.get(api.productLists, {params: {page: 1, per_page: 9}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        self.itemList = response.data.data
        console.log(self.itemList)
        for (var i = 0; i < self.itemList.length; i++) {
        } // endfor
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
