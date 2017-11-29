<template>
  <div class="addr-control">
    <h2>收货地址</h2>
    <!--<ul class="addrlist" v-if="addrlist.length">-->
    <ul class="addrlist">
      <li v-for="(ele, index) in addrlist">
        <p class="clearfix "><span class="fl name">{{ele.name}}</span><span class="fr phone">{{ele.phone}}</span>
        </p>
        <p class="addrs"><span class="province">{{ele.province}}</span><span class="city">{{ele.city}}</span>
        </p>
        <p class="addrs bomborder"><span class="county">{{ele.county}}</span><span
          class="town">{{ele.town}}</span><span
          class="address">{{ele.address}}</span></p>
        <p class="addr-opt clearfix">
          <i @click="changeDef(ele.id)"><span :class="['default', {'checked': ele.is_default === 1}]"
          ></span>{{ele.is_default}}设为默认地址</i>
          <span class="modify fr">
            <i class="edit">编辑</i>
            <i class="del" @click="deladdr(ele.id)">删除</i>
          </span>
        </p>
      </li>
    </ul>
  </div>
</template>
<script>
  import api from '@/api/api'
  export default {
    name: 'addrControl',
    data () {
      return {
        addrlist: [],
        defid: -1
      }
    },
    created () {
      this.getAddrlist()
    },
    computed: {
      isLogin: {
        get () {
          return this.$store.state.event.token
        },
        set () {}
      }
    },
    methods: {
      getAddrlist () {
        const that = this
        that.$http.get(api.delivery_address, {params: {token: that.isLogin}})
          .then((res) => {
            console.log(res)
            that.addrlist = res.data.data
          })
          .catch((err) => {
            console.log(err)
          })
      },
      changeDef (e) {
        const that = this
        that.$http.post(api.default_address, {id: e, token: that.isLogin})
          .then((res) => {
            console.log(res)
            if (res.data.meta.status_code === 200) {
              that.$Message.success('已设为默认')
              that.getAddrlist()
            }
          })
          .catch((err) => {
            console.log(err)
          })
      },
      deladdr (e) {
        const that = this
        that.$http.post(api.del_address, {id: e, token: that.isLogin})
          .then((res) => {
            console.log(res)
            if (res.data.meta.status_code === 200) {
              that.$Message.success('删除成功')
              that.getAddrlist()
            }
          })
          .catch((err) => {
            console.log(err)
          })
      }
    }
  }
</script>
<style scoped>
  h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
  }

  .addrlist {
    border-top: 0.5px solid #E6E6E6;
  }

  .addrlist li {
    padding: 15px 15px 0;
    border-bottom: 0.5px solid #E6E6E6;
  }

  .name, .phone {
    font-weight: 600;
    line-height: 40px;
    height: 40px;
  }

  li .bomborder {
    border-bottom: 0.5px solid #E6E6E6;
  }

  .addrs {
    padding-bottom: 8px;
  }

  .addrs span {
    margin-right: 8px;
  }

  .addr-opt {
    line-height: 20px;
    height: 40px;
    padding: 10px 0;
  }

  .default {
    position: relative;
    float: left;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    border: 0.5px solid #979797;
    background: #ffffff;
    margin-right: 8px;
  }

  .checked {
    background: #BE8914;
  }

  .default::after {
    content: "";
    display: block;
    position: absolute;
    left: 5px;
    top: 2px;
    width: 7px;
    height: 12px;
    border: 2px solid #fff;
    border-top: none;
    border-left: none;
    border-radius: 2px;
    transform: rotate(45deg);
  }

  .modify {
    width: 50%;
    display: flex;
    justify-content: space-around;
  }
</style>
