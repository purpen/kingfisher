<template>
  <div>
    <div class="container min-height350">
      <div class="blank20"></div>
      <Row :gutter="20">
        <Col :span="3" class="left-menu">
        <v-menu currentName="invoiceCenter_index"></v-menu>
        </Col>
        <Col :span="21" class="AddressManagementTable_the_new_address_width">
          1111
        </Col>
      </Row>
    </div>
  </div>
</template>

<script>
  import vMenu from '@/components/page/center/Menu'
  export default {
    name: 'invoiceCenterIndex',
    data () {
      return {
        Bus: this.$BusFactory(this)
      }
    },
    components: {
      vMenu
    },
    methods: {},
    created: function () {

    },
    mounted () {

    },
    watch: {}
  }
</script>

<style scoped>

</style>
