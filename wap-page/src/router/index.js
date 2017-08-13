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

  // h5文章详情
  {
    path: '/h5/article_show/:id',
    name: 'articleShow',
    meta: {
      title: '文章详情',
      requireAuth: false,
      hideHeader: true
    },
    component: require('@/components/page/h5/ProductArticleShow')
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
      document.title = '太火鸟'
    } else {
      document.title = to.meta.title + '-太火鸟'
    }
  } else {
    document.title = '太火鸟'
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
