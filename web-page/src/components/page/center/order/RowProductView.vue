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
      isModal1: true,
      inputValue: 1,
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
          width: 140,
          render: (h, params) => {
            return h('div', {
              props: {
              },
              style: {
              }
            }, [
              h('Button', {
                style: {
                },
                props: {
                  type: 'ghost',
                  icon: 'ios-minus-empty',
                  size: 'small'
                },
                on: {
                  click: () => {
                    if (params.row.value) {
                      params.row.value--
                    }
                  }
                }
              }),
              h('Input', {
                style: {
                  width: '48%',
                  padding: 0,
                  margin: '0px 5px'
                },
                props: {
                  size: 'small',
                  value: params.row.value,
                  max: params.row.inventory,
                  min: 1
                },
                on: {
                  'on-change': (event) => {
                    if (!(/^[1-9]\d*$/.test(event.target.value))) {
                      params.row.value = event.target.value
                    } else {
                      params.row.value = parseInt(event.target.value)
                    }
                  }
                }
              }),
              h('Button', {
                style: {
                },
                props: {
                  type: 'ghost',
                  icon: 'ios-plus-empty',
                  size: 'small'
                },
                on: {
                  click: () => {
                    params.row.value++
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
                params.row.sku_region.map(function (item, index, arr) {
                  // let skuMax = params.row.sku_region.length - 1
                  return h('p', {
                    domProps: {
                      innerHTML: '数量' + item.min + '~' + item.max + '价格' + item.sell_price
                    },
                    'class': {
                      colorff5a5f: params.row.value >= item.min && params.row.value <= item.max
                      // colorff5a5f2: params.row.value >= params.row.sku_region[skuMax].max
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
                  if (params.row.value) {
                    if (!(/^[1-9]\d*$/.test(params.row.value))) {
                      this.$Message.error('请输入正确数量')
                    } else {
                      if (params.row.value > params.row.inventory) {
                        this.$Message.error('大于库存量')
                      } else {
                        this.addSkuBtn(params.row)
                      }
                    }
                  } else {
                    this.$Message.error('数量不能为空')
                  }
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
        sku.value = parseInt(sku.value)
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
          self.skuList[i].value = null
          if (!self.skuList[i].sku_region) {     // 区间值为空的delete
            self.skuList.splice(i, 1)
          }
          if (!self.skuList[i].inventory) {      // 库存为空的delete
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
