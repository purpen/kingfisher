import { USER_SIGNIN, USER_SIGNOUT, USER_INFO, MSG_COUNT, PREV_URL_NAME, CLEAR_PREV_URL_NAME, PLATFORM, HIDE_HEADER, GLOBAL_SEARCH_LIBRARY_OF_GOODS, GLOBAL_SEARCH_LIBRARY_OF_GOODS_CLEAR, THE_SHOPPING_CART_LENGTH_THEBACKGROUND, THE_SHOPPING_CART_LENGTH_THEBACKGROUND_CLEAR, THE_ORDER_SHOPPING_CART_IDS_GLOBAL, THE_ORDER_SHOPPING_CART_IDS_GLOBAL_CLEAR } from './mutation-types.js'

// 判断是否登录
var isLoggedIn = function () {
  // TODO 此处可以写异步请求，到后台一直比较Token
  var token = localStorage.getItem('token')
  if (token) {
    return JSON.parse(token)
  } else {
    return false
  }
}

var userInfo = function () {
  // TODO 用户从Store获取
  var user = localStorage.getItem('user')
  if (user) {
    return JSON.parse(user)
  } else {
    return false
  }
}

var prevUrlName = function () {
  var urlName = localStorage.getItem('prev_url_name')
  if (urlName) {
    return urlName
  } else {
    return null
  }
}

// 消息数量
var msgCount = function () {
  var messageCount = localStorage.getItem('msgCount')
  if (messageCount) {
    return messageCount
  } else {
    return 0
  }
}

// 平台来源 Web or Wap
var platform = function () {
  var n = localStorage.getItem('platform')
  if (n) {
    return n
  } else {
    return 1
  }
}

// 是否隐藏头部
var hideHeader = function () {
  var bool = localStorage.getItem('hide_header')
  return JSON.parse(bool)
}

const state = {
  token: isLoggedIn() || null,
  user: userInfo() || {},
  loading: false,  // 是否显示loading
  apiUrl: 'http://sa.taihuoniao.com', // 接口base url
  imgUrl: 'http://sa.taihuoniao.com', // 图片base url
  prevUrlName: prevUrlName(),
  msgCount: msgCount(),
  platform: platform(),
  indexConf: {
    hideHeader: hideHeader(), // 是否显示头部
    isFooter: true, // 是否显示底部
    isSearch: true, // 是否显示搜索
    isBack: false, // 是否显示返回
    isShare: false, // 是否显示分享
    title: '' // 标题
  },
  global_Search_Library_Of_Goods: '', // 全局搜索商品
  The_shopping_cart_length_Thebackground: 15, // 购物车商品数量
  The_order_shopping_cart_ids_global: ''
}

const mutations = {
  [USER_SIGNIN] (state, token) {
    localStorage.setItem('token', null)
    localStorage.setItem('token', JSON.stringify(token))
    state.token = token
  },
  [USER_SIGNOUT] (state) {
    localStorage.removeItem('token')
    localStorage.removeItem('user')
    localStorage.setItem('msgCount', 0)
    state.token = false
    state.user = {}
  },
  [USER_INFO] (state, user) {
    localStorage.setItem('user', {})
    localStorage.setItem('user', JSON.stringify(user))
    state.user = user
  },
  [MSG_COUNT] (state, msgCount) {
    if (msgCount < 0) {
      msgCount = 0
    }
    localStorage.setItem('msgCount', JSON.stringify(msgCount))
    state.msgCount = msgCount
  },
  [PREV_URL_NAME] (state, urlName) {
    localStorage.setItem('prev_url_name', urlName)
    state.prevUrlName = urlName
  },
  [CLEAR_PREV_URL_NAME] (state) {
    localStorage.removeItem('prev_url_name')
    state.prevUrlName = null
  },
  [PLATFORM] (state, n) {
    localStorage.setItem('platform', n)
    state.platform = n
  },
  [HIDE_HEADER] (state, bool) {
    localStorage.setItem('hide_header', JSON.stringify(bool))
    state.indexConf.hideHeader = bool
  },
  [GLOBAL_SEARCH_LIBRARY_OF_GOODS] (state, seacher) {
    state.global_Search_Library_Of_Goods = seacher
  },
  [GLOBAL_SEARCH_LIBRARY_OF_GOODS_CLEAR] (state) {
    state.global_Search_Library_Of_Goods = ''
  },
  [THE_SHOPPING_CART_LENGTH_THEBACKGROUND] (state, lengths) {
    state.The_shopping_cart_length_Thebackground = lengths
  },
  [THE_SHOPPING_CART_LENGTH_THEBACKGROUND_CLEAR] (state) {
    state.The_shopping_cart_length_Thebackground = 0
  },
  [THE_ORDER_SHOPPING_CART_IDS_GLOBAL] (state, global) {
    state.The_order_shopping_cart_ids_global = global
  },
  [THE_ORDER_SHOPPING_CART_IDS_GLOBAL_CLEAR] (state) {
    state.The_order_shopping_cart_ids_global = ''
  }
}

export default {
  state,
  mutations
}
