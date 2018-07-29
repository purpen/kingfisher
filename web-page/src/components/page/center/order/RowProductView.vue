<template>
  <div class="">
    <div class="content">
      <Table :columns="skuHead" :data="skuList" :no-data-text="loadText"></Table>
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
                  width: '80px'
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
          key: 'price'
        },
        {
          title: '库存',
          key: 'inventory'
        },
        {
          title: '数量',
          key: 'inventory',
          width: 90,
          render: (h, params) => {
            return h('Tooltip', {
              props: {
                content: '1111',
                placement: 'right'
              }
            }, [
              h('inputNumber', {
                style: {
                  width: 100 + '%',
                  padding: 0
                },
                props: {
                  size: 'small',
                  value: this.skuList[params.index].value,
                  max: 10,
                  min: 0
                },
                on: {
                  'on-change': (event) => {
                    params.row.value = event
                    this.isDisabled(params)
                    this.modalTest = event
                  }
                }
              })
            ])
          }
        },
        {
          title: '库存',
          key: 'inventory',
          render: (h, params) => {
            return h('Tooltip', {
              style: {
              },
              props: {
                size: 'small'
              }
            })
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
                  console.log(this.isModal1)
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
    modalTest () {
      if (this.modalTest > 0) {
        this.isModal1 = false
      } else {
        this.isModal1 = true
      }
    }
  },
  methods: {
    // 添加产品
    addSkuBtn (sku) {
      console.log(sku)
      sku.product_id = this.item.product_id
      sku.product_name = this.item.name
      sku.product_number = this.item.number
      sku.product_cover = this.item.image
      sku.modalTest = this.modalTest
      console.log(sku)
      this.$emit('skuData', sku)
    },
    isDisabled (p) {
      if (p.row.value) {
        console.log(1)
      } else {
        console.log(0)
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
        var item = response.data.data
        self.item = item
        self.skuList = item.skus
        for (let i = 0; i < self.skuList.length; i++) {
          self.skuList[i].value = 0
        }
        if (self.skuList.length === 0) self.loadText = '暂无数据'
        console.log(self.skuList)
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
