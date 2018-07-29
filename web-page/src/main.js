// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store/index'
import axios from './http'
import iView from 'iview'
import '@/assets/js/format'
// 兼容 IE
import 'babel-polyfill'
// import phenix from '@/assets/js/base'

// 样式表导入
import '@/assets/css/reset.css'
import 'iview/dist/styles/iview.css'
import '@/assets/css/theme.less'
import './assets/css/font-awesome.min.css'
import '@/assets/css/base.css'
import '@/assets/css/change-iview.css'
import '@/assets/css/public.css'

// 将axios挂载到prototype上，在组件中可以直接使用this.http访问
Vue.prototype.$http = axios
Vue.use(iView)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
