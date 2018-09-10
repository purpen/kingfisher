<template>

  <div class="menu-list invoiceCenterIndex-menu-list">
    <ul>
      <li>
        <router-link :to="{name: 'centerOrder'}" :class="{'item': true, 'is-active': currentName === 'order' ? true : false}">
          我的订单
        </router-link>
      </li>
      <!--<li>-->
        <!--<router-link :to="{name: 'centerBasic'}" :class="{'item': true, 'is-active': currentName === 'base' ? true : false}">-->
          <!--账户概况-->
        <!--</router-link>-->
      <!--</li>-->
      <!--<li>-->
        <!--<router-link :to="{name: 'centerProduct'}" :class="{'item': true, 'is-active': currentName === 'product' ? true : false}">-->
          <!--我的产品-->
        <!--</router-link>-->
      <!--</li>-->
      <li>
        <router-link :to="{name: 'centerIdentifyShow'}" :class="{'item': true, 'is-active': currentName === 'identify_show' ? true : false}">
          企业信息
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'personalcenter'}" :class="{'item': true, 'is-active': currentName === 'personalcenter' ? true : false}">
          账号设置
        </router-link>
      </li>
      <li>
        <router-link :to="{name: 'addressManagementIndex'}" :class="{'item': true, 'is-active': currentName === 'management_index' ? true : false}">
          收货地址
        </router-link>
      </li>
      <Menu theme="light" :active-name="currentName === 'invoiceCenter_index' ? '1-1' : '1-2'" :open-names="currentName === 'invoiceCenter_index' ? ['1'] : ['2']" class="last_invoiceCenterIndex-menu-list">
        <Submenu name="1">
          <template slot="title">
            内容管理
          </template>
          <MenuItem name="1-1">
            <router-link :to="{name: 'invoiceCenterIndex'}" :class="{'item': true, 'is-active': currentName === 'invoiceCenter_index' ? true : false}">
            文章管理
            </router-link>
          </MenuItem>
        </Submenu>
      </Menu>
    </ul>



    <!--<router-link :to="{name: 'centerSurveyHome'}" :class="{'item': true, 'is-active': currentName === 'survey' ? true : false}">-->
      <!--销售趋势-->
    <!--</router-link>-->


  </div>

</template>

<script>
export default {
  name: 'center_menu',
  props: {
    currentName: {
      default: ''
    }
  },
  data () {
    return {
      msg: 'This is menu'
    }
  },
  methods: {
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .menu-list li {
    margin-bottom: 18px;
  }
  .rz-title p{
    font-size: 1.8rem;
  }
  .success p {
    color: #008000;
  }
  .wait p {
    color: #FF4500;
  }
  .rejust p {
    color: #FF4500;
  }

  .item p {
    line-height: 3;
  }

  .margin-l-30 i {
    color: #C6C6C6;
  }
</style>

