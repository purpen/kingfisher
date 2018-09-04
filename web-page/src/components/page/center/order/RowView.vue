<template>
  <div class="">
    <div class="content">
      <Tabs type="card" size="small">
          <Tab-pane label="商品信息">
            <div class="product-info">
              <table class="product-table">
                <tr>
                  <th style="width: 10%;">产品图</th>
                  <th style="width: 10%;">SKU编码</th>
                  <th style="width: 30%;">产品名称</th>
                  <th style="width: 15%;">零售价</th>
                  <th style="width: 10%;">数量</th>
                  <th>实付款</th>
                  <th>状态</th>
                </tr>
                <tr>
                  <td class="sku-box" colspan="5">
                    <table class="sku-table">
                      <tr>{{ item.pay_money }}</tr>
                      <tr v-for="(d, index) in item.orderSku" :key="index">
                        <td style="width: 10%;">
                          <img :src="d.path" v-if="d.path" width="80" />
                          <img src="../../../../assets/images/product_500.png" v-else width="80" />
                        </td>
                        <td style="width: 10%;">
                          <p>{{ d.sku_number }}</p>
                        </td>
                        <td style="width: 30%;">
                          <p class="p-title">{{ d.product_title }}({{ d.sku_name }})</p>
                        </td>
                        <td style="width: 15%;">
                          <p class="p-price">{{ d.price }}</p>
                        </td>
                        <td style="width: 10%;">
                          <p>{{ d.quantity }}</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td>
                    <p class="p-price">¥{{ item.pay_money }}</p>
                  </td>
                  <td>
                    <p>{{ item.status_val }}</p>
                  </td>
                </tr>
              </table>
            </div>
          </Tab-pane>
          <Tab-pane label="客户信息">
            <Row class="expand-row">
                <Col span="6">
                    <span class="expand-key">收货人：</span>
                    <span class="expand-value">{{ item.buyer_name }}</span>
                </Col>
                <Col span="6">
                    <span class="expand-key">邮编：</span>
                    <span class="expand-value">{{ item.buyer_zip }}</span>
                </Col>
                <Col span="6">
                    <span class="expand-key">电话：</span>
                    <span class="expand-value">{{ item.buyer_phone }}</span>
                </Col>
            </Row>
            <Row class="expand-row">
                <Col span="6">
                    <span class="expand-key">收货地址：</span>
                    <span class="expand-value">{{ item.shipping_address }}</span>
                </Col>
            </Row>
          </Tab-pane>

          <Tab-pane label="订单信息">
            <Row class="expand-row" :gutter="16">
                <Col span="6">
                    <span class="expand-key">订单类型：</span>
                    <span class="expand-value">{{ item.type_val }}</span>
                </Col>
                <Col span="6">
                    <span class="expand-key">付款方式：</span>
                    <span class="expand-value">{{ item.payment_type }}</span>
                </Col>
            </Row>
            <Row class="expand-row" :gutter="16">
                <Col span="6">
                    <span class="expand-key">物流公司：</span>
                    <span class="expand-value">{{ item.logistics_name }}</span>
                </Col>
                <Col span="6">
                    <span class="expand-key">运单号：</span>
                    <span class="expand-value">{{ item.express_no }}</span>
                </Col>
                <Col span="6">
                    <span class="expand-key">快递费：</span>
                    <span class="expand-value">{{ item.freight }}</span>
                </Col>
            </Row>
          </Tab-pane>
      </Tabs>
    </div>

  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'center_order_table_show',
  props: {
    orderId: Number
  },
  data () {
    return {
      isLoading: false,
      item: '',
      msg: ''
    }
  },
  methods: {
  },
  created: function () {
    const self = this
    self.isLoading = true
    // 产品详情
    self.$http.get(api.order, {params: {order_id: self.orderId}})
    .then(function (response) {
      if (response.data.meta.status_code === 200) {
        var item = response.data.data
        item.shipping_address = item.buyer_province + ' ' + item.buyer_city + ' ' + item.buyer_county + ' ' + item.buyer_township + ' ' + item.buyer_address
        self.item = item
        console.log(self.item)
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .expand-row{
    margin-bottom: 16px;
    text-align: left;
  }

  .summary-box {
  }
  .summary-box p {
    min-height: 60px;
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 10px;
    font-size: 1.2rem;
    line-height: 1.5;
  }

  .product-info {
    background-color: #fff;
    text-align: center;
  }

  .product-table {
    width: 100%;
    border: 1px solid #ccc;
  }
  .product-table tr {
  }
  .product-table tr th, .product-table tr td {
    background-color: #fff;
    text-align: center;
    padding: 5px 0;
  }
  .product-table tr td {
    border: 1px solid #ccc;
  }
  .product-table tr td p {
    font-size: 1.2rem;
    line-height: 1.2;
  }

  .sku-table {
    width: 100%;
  }

  .sku-table tr td {
    border: none;
  }

  p.p-title {
  }
  p.p-price {
    color: #C18D1D;
  }


</style>
