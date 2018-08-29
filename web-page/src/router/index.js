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
    // redirect: '/home'
    component: require('@/components/page/home/Home')
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
  // ERP测试
  // 登录
  {
    path: '/auth/login',
    name: 'login',
    meta: {
      title: '登录',
      requireAuth: false
    },
    component: require('@/components/page/auth/Login')
  },
  // 找回密码
  {
    path: '/auth/forget',
    name: 'forget',
    meta: {
      title: '找回密码',
      requireAuth: false
    },
    component: require('@/components/page/auth/Forget')
  },
  {
    path: '/supplier',
    name: 'supplier',
    meta: {
      title: '品牌',
      requireAuth: false
    },
    component: require('@/components/page/home/Supplier')
  },
  {
    path: '/trader',
    name: 'trader',
    meta: {
      title: '渠道',
      requireAuth: false
    },
    component: require('@/components/page/home/Trader')
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
  {
    path: '/auth/register',
    name: 'register',
    meta: {
      title: '注册',
      requireAuth: false
    },
    component: require('@/components/page/auth/Register')
  },
  // 新注册
  {
    path: '/auth/newregister',
    name: 'newregister',
    meta: {
      title: '注册',
      requireAuth: false,
      hideHeader: true
    },
    component: require('@/components/page/auth/NewRegister')
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
  // 实名认证展示
  {
    path: '/center/account/identify_show',
    name: 'centerIdentifyShow',
    meta: {
      title: '实名认证展示',
      requireAuth: true
    },
    component: require('@/components/page/center/account/IdentifyShow')
  },
  // 实名认证提交
  {
    path: '/center/account/identify_submit',
    name: 'centerIdentifySubmit',
    meta: {
      title: '实名认证提交',
      requireAuth: true
    },
    component: require('@/components/page/center/account/IdentifySubmit')
  },
  {
    path: '/center/account/identify_submit1',
    name: 'centerIdentifySubmit1',
    meta: {
      title: '实名认证提交',
      requireAuth: true
    },
    component: require('@/components/page/center/account/IdentifySubmit1')
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
  // 我的订单
  {
    path: '/center/order',
    name: 'centerOrder',
    meta: {
      title: '我的订单',
      requireAuth: true
    },
    component: require('@/components/page/center/order/List')
  },
  // 创建订单
  {
    path: '/center/order/submit',
    name: 'centerOrderSubmit',
    meta: {
      title: '创建订单',
      requireAuth: true
    },
    component: require('@/components/page/center/order/Submit')
  },
  // 导入订单记录列表
  {
    path: '/center/order/import_record',
    name: 'centerOrderImportRecord',
    meta: {
      title: '导入订单记录',
      requireAuth: true
    },
    component: require('@/components/page/center/order/ImportRecord')
  },

  // 销售统计
  {
    path: '/center/survey',
    name: 'centerSurveyHome',
    meta: {
      title: '销售统计',
      requireAuth: true
    },
    // 按需加载
    component: (resolve) => { require(['@/components/page/center/survey/Home'], resolve) }
  },
  // 地址管理主界面
  {
    path: '/center/addressManagementIndex',
    name: 'addressManagementIndex',
    meta: {
      title: '地址管理',
      requireAuth: true
    },
    // 按需加载
    component: (resolve) => { require(['@/components/addressManagement/AddressManagementIndex'], resolve) }
  },
  // 销售渠道
  {
    path: '/center/survey/source',
    name: 'centerSurveySource',
    meta: {
      title: '销售渠道',
      requireAuth: true
    },
    // 按需加载
    component: (resolve) => { require(['@/components/page/center/survey/Source'], resolve) }
  },
  // 客单价
  {
    path: '/center/survey/customer',
    name: 'centerSurveyCustomer',
    meta: {
      title: '客单价',
      requireAuth: true
    },
    // 按需加载
    component: (resolve) => { require(['@/components/page/center/survey/Customer'], resolve) }
  },
  // 地域分布
  {
    path: '/center/survey/area',
    name: 'centerSurveyArea',
    meta: {
      title: '地域分布',
      requireAuth: true
    },
    // 按需加载
    component: (resolve) => { require(['@/components/page/center/survey/Area'], resolve) }
  },
  // Top标签
  {
    path: '/center/survey/tag',
    name: 'centerSurveyTag',
    meta: {
      title: '标签',
      requireAuth: true
    },
    // 按需加载
    component: (resolve) => { require(['@/components/page/center/survey/Tag'], resolve) }
  },

  {
    path: '/center/EchartsTest',
    name: 'EchartsTest',
    meta: {
      title: '测试Echarts'
    },
    component: require('@/components/page/center/EchartsTest')
  },

  {
    path: '/test',
    redirect: '/home'
  }
]

const router = new Router({
  mode: 'history',
  linkActiveClass: 'is-active', // 这是链接激活时的class
  routes,
  // 滚动行为
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
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

  // 判断页面来源是web or wap
  if (to.meta.platform) {
    store.commit(types.PLATFORM, to.meta.platform)
  } else {
    store.commit(types.PLATFORM, 1)
  }
  // 是否显示头尾部
  if (to.meta.hideHeader) {
    store.commit(types.HIDE_HEADER, to.meta.hideHeader)
  } else {
    store.commit(types.HIDE_HEADER, false)
  }
})

export default router
