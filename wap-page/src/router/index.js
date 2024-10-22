import Vue from 'vue'
import Router from 'vue-router'
import store from '../store/index'
import * as types from '../store/mutation-types'

Vue.use(Router)

// 页面刷新时，重新赋值token
if (window.localStorage.getItem('token')) {
  // console.log(window.localStorage.getItem('token'))
  store.commit(types.USER_SIGNIN, JSON.parse(window.localStorage.getItem('token')))
}

const routes = [

  // ### 静态页面 #####
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/home',
    name: 'home',
    meta: {
      title: '首页',
      requireAuth: true,
      hideHeader: false
    },
    component: require('@/components/page/home/Home')
  },
  {
    path: '/test',
    name: 'test',
    meta: {
      title: 'test',
      requireAuth: false,
      hideHeader: true
    },
    component: require('@/components/page/home/test')
  },
  {
    path: '/classify',
    name: 'classify',
    meta: {
      title: '分类',
      requireAuth: true,
      hideHeader: false
    },
    component: require('@/components/page/home/Classify')
  },
  {
    path: '/search_goods',
    name: 'searchGoods',
    meta: {
      title: '搜索',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/goods/searchGoods')
  },
  {
    path: '/cart',
    name: 'cart',
    meta: {
      title: '购物车',
      requireAuth: true
    },
    component: require('@/components/page/home/Cart')
  },
  {
    path: '/i',
    name: 'i',
    meta: {
      title: '个人中心',
      requireAuth: true,
      hideHeader: false
    },
    component: require('@/components/page/home/Personal')
  },
  {
    path: '/system_setting',
    name: 'systemSetting',
    meta: {
      title: '系统设置',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/auth/option/systemSetting')
  },
  {
    path: '/language',
    name: 'language',
    meta: {
      title: '系统语言',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/auth/option/language')
  },
  {
    path: '/order',
    name: 'order',
    meta: {
      title: '填写订单',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/order/order')
  },
  {
    path: '/orderDetail/:id',
    name: 'orderDetail',
    meta: {
      title: '订单详情',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/order/orderDetail')
  },
  {
    path: '/order_control',
    name: 'orderControl',
    meta: {
      title: '我的订单',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/order/orderControl')
  },
  {
    path: '/payment',
    name: 'payment',
    meta: {
      title: '支付方式',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/order/payment')
  },
  {
    path: '/payTransfer',
    name: 'payTransfer',
    meta: {
      title: '',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/order/payTransfer')
  },
  {
    path: '/paySuccess',
    name: 'paySuccess',
    meta: {
      title: '',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/order/paySuccess')
  },
  // 商品详情
  {
    path: '/product/goods/goodsShow/:id',
    name: 'GoodsShow',
    meta: {
      title: '商品详情',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/product/goods/goodsShow')
  },
  {
    path: '/login',
    name: 'login',
    meta: {
      title: '登录',
      requireAuth: false,
      hideHeader: true
    },
    component: require('@/components/page/auth/login')
  },
  {
    path: '/register',
    name: 'register',
    meta: {
      title: '注册',
      requireAuth: false,
      hideHeader: true
    },
    component: require('@/components/page/auth/register')
  },
  {
    path: '/retrieve_password',
    name: 'retrievePassword',
    meta: {
      title: '忘记密码',
      requireAuth: false,
      hideHeader: true
    },
    component: require('@/components/page/auth/retrievePassword')
  },
  {
    path: '/modify_secret',
    name: 'modifySecret',
    meta: {
      title: '修改密码',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/auth/modifySecret')
  },
  {
    path: '/add_address',
    name: 'addAddr',
    meta: {
      title: '添加收货地址',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/auth/addr/addAddr')
  },
  {
    path: '/addr_control',
    name: 'addrControl',
    meta: {
      title: '我的收货地址',
      requireAuth: true,
      hideHeader: true
    },
    component: require('@/components/page/auth/addr/addrControl')
  },
  {
    path: '/test',
    redirect: '/home'
  }
]

const router = new Router({
  mode: 'history',
  linkActiveClass: 'is-active', // 这是链接激活时的class
  routes
})

router.beforeEach((to, from, next) => {
  // meta title
  if (to.meta.title) {
    if (to.meta.title === '首页') {
      document.title = '太火鸟FIU智能分发SaaS平台'
    } else {
      document.title = to.meta.title + '-太火鸟FIU智能分发SaaS平台'
    }
  } else {
    document.title = '太火鸟FIU智能分发SaaS平台'
  }
  // 验证登录
  if (to.matched.some(r => r.meta.requireAuth)) {
    if (store.state.event.token) {
      next()
    } else {
      store.commit(types.PREV_URL_NAME, to.name)
      next({name: 'login'})
    }
  } else {
    next()
  }

  // 是否显示头尾部
  if (to.meta.hideHeader) {
    store.commit(types.HIDE_HEADER, to.meta.hideHeader)
  } else {
    store.commit(types.HIDE_HEADER, false)
  }
})

export default router
