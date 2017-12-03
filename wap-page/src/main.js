// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store/index'
import axios from './http'
import iView from 'iview'
import VueLazyload from 'vue-lazyload'
import VueAwesomeSwiper from 'vue-awesome-swiper'

// 兼容 IE
import 'babel-polyfill'
import phenix from '@/assets/js/base'

// 样式表导入
import 'iview/dist/styles/iview.css'
import '@/assets/css/reset.css'
import './assets/css/font-awesome.min.css'
import '@/assets/css/base.css'
import 'swiper/dist/css/swiper.css'

// 将axios挂载到prototype上，在组件中可以直接使用this.http访问
Vue.prototype.$http = axios
// js自定义方法集
Vue.prototype.$phenix = phenix
Vue.use(iView)

// 图片懒加载
Vue.use(VueLazyload, {
  loading: require('@/assets/images/default_thn.png')
})

Vue.use(VueAwesomeSwiper)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {App}
})
