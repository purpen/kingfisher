<template>
  <div class="">
    <div class="content">
      <h3 class="title">导入失败的订单记录:</h3>
      <Tabs type="card" size="small">
          <Tab-pane :label="label1">
            <div class="record-list">
              {{ row.no_sku_string }}
            </div>
          </Tab-pane>

          <Tab-pane :label="label2">
            <div class="record-list">
              {{ row.product_unopened_string }}
            </div>
          </Tab-pane>

          <Tab-pane :label="label3">
            <div class="record-list">
              {{ row.sku_storage_quantity_string }}
            </div>
          </Tab-pane>

          <Tab-pane :label="label4">
            <div class="record-list">
              {{ row.repeat_outside_string }}
            </div>
          </Tab-pane>

          <Tab-pane :label="label5">
            <div class="record-list">
              {{ row.null_field_string }}
            </div>
          </Tab-pane>
      </Tabs>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'center_export_table_show',
  props: {
    row: Object
  },
  data () {
    return {
      isLoading: false,
      item: '',
      label1: (h) => {
        return h('div', [
          h('span', '商品不存在'),
          h('Badge', {
            style: {
              marginLeft: '3px'
            },
            props: {
              count: this.row.no_sku_count
            }
          })
        ])
      },
      label2: (h) => {
        return h('div', [
          h('span', '商品未开放'),
          h('Badge', {
            style: {
              marginLeft: '3px'
            },
            props: {
              count: this.row.product_unopened_count
            }
          })
        ])
      },
      label3: (h) => {
        return h('div', [
          h('span', '商品库存不足'),
          h('Badge', {
            style: {
              marginLeft: '3px'
            },
            props: {
              count: this.row.sku_storage_quantity_count
            }
          })
        ])
      },
      label4: (h) => {
        return h('div', [
          h('span', '订单重复导入'),
          h('Badge', {
            style: {
              marginLeft: '3px'
            },
            props: {
              count: this.row.repeat_outside_count
            }
          })
        ])
      },
      label5: (h) => {
        return h('div', [
          h('span', '订单信息不完整'),
          h('Badge', {
            style: {
              marginLeft: '3px'
            },
            props: {
              count: this.row.null_field_count
            }
          })
        ])
      },
      msg: ''
    }
  },
  methods: {
  },
  created: function () {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

  .title {
    font-size: 1.5rem;
    margin-bottom: 10px;
  }

  .record-list {
  
  }


</style>
