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
      requireAuth: false
    },
    component: require('@/components/page/home/Home')
  },
  {
    path: '/supplier',
    name: 'supplier',
    meta: {
      title: '供应商',
      requireAuth: true
    },
    component: require('@/components/page/home/Supplier')
  },
  {
    path: '/trader',
    name: 'trader',
    meta: {
      title: '分销商',
      requireAuth: true
    },
    component: require('@/components/page/home/Trader')
  },
  {
    path: '/product',
    name: 'product',
    meta: {
      title: '产品库',
      requireAuth: true
    },
    component: require('@/components/page/home/Product')
  },
  {
    path: '/product/show/:id',
    name: 'productShow',
    meta: {
      title: '产品详情',
      requireAuth: true
    },
    component: require('@/components/page/product/Show')
  },

  // AUTH 注册／登录
  {
    path: '/auth/login',
    name: 'login',
    meta: {
      title: '登录',
      requireAuth: false
    },
    component: require('@/components/page/auth/Login')
  },
  {
    path: '/auth/register',
    name: 'register',
    meta: {
      title: '注册',
      requireAuth: false
    },
    component: require('@/components/page/auth/Register')
  },

  // 产品
  // 图片列表
  {
    path: '/product/:product_id/image_list',
    name: 'productImageList',
    meta: {
      title: '图片列表',
      requireAuth: true
    },
    component: require('@/components/page/product/ImageList')
  },
  // 文字列表
  {
    path: '/product/:product_id/text_list',
    name: 'productTextList',
    meta: {
      title: '文字列表',
      requireAuth: true
    },
    component: require('@/components/page/product/TextList')
  },
  // 文章列表
  {
    path: '/product/:product_id/article_list',
    name: 'productArticleList',
    meta: {
      title: '文章列表',
      requireAuth: true
    },
    component: require('@/components/page/product/ArticleList')
  },
  // 文章详情
  {
    path: '/product/article_show/:id',
    name: 'productArticleShow',
    meta: {
      title: '文章详情',
      requireAuth: true
    },
    component: require('@/components/page/product/ArticleShow')
  },
  // 视频列表
  {
    path: '/product/:product_id/video_list',
    name: 'productVideoList',
    meta: {
      title: '视频列表',
      requireAuth: true
    },
    component: require('@/components/page/product/VideoList')
  },
  // 视频详情
  {
    path: '/product/video_show/:id',
    name: 'productVideoShow',
    meta: {
      title: '视频详情',
      requireAuth: true
    },
    component: require('@/components/page/product/VideoShow')
  },
  // Vcenter 我的
  // 概况
  {
    path: '/center/basic',
    name: 'centerBasic',
    meta: {
      title: '账户概况',
      requireAuth: true
    },
    component: require('@/components/page/center/Basic')
  },
  // 我的产品库
  {
    path: '/center/product',
    name: 'centerProduct',
    meta: {
      title: '我的产品库',
      requireAuth: true
    },
    component: require('@/components/page/center/Product')
  },

  // 销售统计
  {
    path: '/center/survey',
    name: 'centerSurveyHome',
    meta: {
      title: '销售统计',
      requireAuth: true
    },
    component: require('@/components/page/center/survey/Home')
  },
  // 销售渠道
  {
    path: '/center/survey/source',
    name: 'centerSurveySource',
    meta: {
      title: '销售渠道',
      requireAuth: true
    },
    component: require('@/components/page/center/survey/Source')
  },
  // 客单价
  {
    path: '/center/survey/customer',
    name: 'centerSurveyCustomer',
    meta: {
      title: '客单价',
      requireAuth: true
    },
    component: require('@/components/page/center/survey/Customer')
  },
  // 地域分布
  {
    path: '/center/survey/area',
    name: 'centerSurveyArea',
    meta: {
      title: '地域分布',
      requireAuth: true
    },
    component: require('@/components/page/center/survey/Area')
  },
  // Top标签
  {
    path: '/center/survey/tag',
    name: 'centerSurveyTag',
    meta: {
      title: '标签',
      requireAuth: true
    },
    component: require('@/components/page/center/survey/Tag')
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
  if (to.meta.title) {
    if (to.meta.title === '首页') {
      document.title = '太火鸟'
    } else {
      document.title = to.meta.title + '-太火鸟'
    }
  } else {
    document.title = '太火鸟'
  }
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
})

export default router
