<template>
  <div class="language">
    <h2>
      <router-link :to="{name:'systemSetting'}" class="backIcon">
      </router-link>
      {{language.systemSetting.accountSetting}}</h2>
    <ul>
      <li :class="['item', {'active': current === 'chinese'}]"
        @click="changeLanguage('chinese')">简体中文</li>
      <li :class="['item', {'active': current === 'english'}]"
        @click="changeLanguage('english')">English</li>
    </ul>
  </div>
</template>
<script>
import { LANGUAGE } from '@/store/mutation-types'
export default {
  name: 'language',
  data() {
    return {
      current: ''
    }
  },
  computed: {
    language() {
      return this.$store.state.event.language
    }
  },
  created() {
    this.current = this.language.language
  },
  methods: {
    changeLanguage(e) {
      this.current = e
      this.$store.commit(LANGUAGE, e)
      this.$router.push({name: 'i'})
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
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
  }
  ul {
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
  }
  ul li.item {
    line-height: 42px;
    border-top: 0.5px solid rgba(204,204,204,0.49);
    padding: 0 15px;
    position: relative;
  }

  ul li.item:first-child {
    border-top: none
  }

  ul li.item.active::after {
    content: "";
    position: absolute;
    right: 15px;
    top: 16px;
    width: 16px;
    height: 10px;
    border-bottom: 2px solid #BE8914;
    border-left: 2px solid #BE8914;
    transform: rotate(-45deg)
  }
</style>
