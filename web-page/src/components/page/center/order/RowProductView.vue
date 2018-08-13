<template>
  <div class="">
    <div class="content">
      <Table :columns="skuHead" :data="skuList" class="addOrder" :no-data-text="loadText"></Table>
      <div class="blank20"></div>
    </div>

  </div>
</template>

<script>
import api from '@/api/api'
export default {
  name: 'center_order_table_show',
  props: {
    productId: String
  },
  data () {
    return {
      isLoading: false,
      loadText: '加载数据...',
      item: '',
      skuList: [],
      modalTest: 0,
      isModal1: true,
      skuHead: [
        {
          title: '规格图',
          key: 'img',
          width: 100,
          render: (h, params) => {
            return h('p', {
              style: {
                margin: '5px'
              }
            }, [
              h('img', {
                attrs: {
                  src: params.row.image
                },
                style: {
                  width: '100%'
                }
              })
            ])
          }
        },
        {
          title: '规格',
          key: 'mode',
          width: 100
        },
        {
          title: '编号',
          key: 'number',
          width: 120
        },
        {
          title: '价格',
          key: 'price',
          width: 90
        },
        {
          title: '库存',
          key: 'inventory',
          width: 90
        },
        {
          title: '数量',
          key: 'value',
          width: 110,
          render: (h, params) => {
            return h('div', {
              props: {
              }
            }, [
              h('inputNumber', {
                style: {
                  width: '100%',
                  padding: 0
                },
                props: {
                  size: 'small',
                  value: this.skuList[params.index].value,
                  max: params.row.inventory,
                  min: 0
                },
                on: {
                  'on-change': (event) => {
                    params.row.value = event
                    this.changePrice(params)
                    this.modalTest = event
                  }
                }
              })
            ])
          }
        },
        {
          title: '优惠',
          key: 'inventory',
          width: 180,
          render: (h, params) => {
            if (params.row.sku_region && params.row.sku_region.length !== 0) {
              return h('div',
                params.row.sku_region.map(function (item) {
                  return h('p', {
                    domProps: {
                      innerHTML: '数量' + item.min + '~' + item.max + '价格' + item.sell_price
                    },
                    'class': {
                      colorff5a5f: params.row.value >= item.min && params.row.value <= item.max
                    },
                    style: {
                      fontSize: '12px',
                      textAlign: 'center'
                    }
                  })
                })
              )
            } else {
              return h('p', {
                domProps: {
                  innerHTML: '该产品暂无优惠'
                },
                style: {
                  fontSize: '12px'
                }
              })
            }
          }
        },
        {
          title: '操作',
          key: 'action',
          render: (h, params) => {
            return h('Button', {
              style: {
              },
              props: {
                size: 'small',
                type: 'primary'
              },
              on: {
                click: () => {
                  this.addSkuBtn(params.row)
                }
              }
            }, '添加')
          }
        }
      ],
      msg: ''
    }
  },
  watch: {
  },
  methods: {
    // 添加产品
    addSkuBtn (sku) {
      if (sku.value !== 0 && sku.value !== '') {  // 当前行的value
        sku.product_id = this.item.product_id
        sku.product_name = this.item.name
        sku.product_number = this.item.number
        sku.product_cover = this.item.image
        sku.value = sku.value
        sku.price = sku.price
        this.$emit('skuData', sku)
      } else {
        this.$Message.error('请选择数量')
      }
    },
    // 价格变动
    changePrice (p) {
      let skuRegion = p.row.sku_region
      let quantity = p.row.value
      if (skuRegion) {
        skuRegion.forEach((item, index, array) => {
          p.row.qujian = item.min + '---' + item.max + '---' + item.sell_price
          if (index === array.length - 1) {
            p.row.price = array[index].sell_price
          } else {
            if (quantity) {
              if (quantity >= item.min && quantity <= item.max) {
                this.$nextTick(() => {
                  p.row.price = item.sell_price
                })
              }
            } else {
              p.row.price = p.row.price
            }
          }
        })
      }
    }
  },
  created: function () {
    const self = this
    self.isLoading = true
    // 产品详情
    self.$http.get(api.productShow, {params: {product_id: self.productId}})
    .then(function (response) {
      self.isLoading = false
      if (response.data.meta.status_code === 200) {
        let item = response.data.data
        self.item = item
        self.skuList = item.skus
        for (let i = 0; i < self.skuList.length; i++) {
          self.skuList[i].value = 0
          if (!self.skuList[i].sku_region) {
            self.skuList.splice(i, 1)
          }
        }
        if (self.skuList.length === 0) self.loadText = '暂无数据'
      } else {
        self.loadText = '暂无数据'
        self.$Message.error(response.data.meta.message)
      }
    })
    .catch(function (error) {
      self.$Message.error(error.message)
      self.isLoading = false
      self.loadText = '暂无数据'
    })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
