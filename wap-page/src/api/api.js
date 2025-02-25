export default {
  // Auth
  login: '/MicroApi/auth/login', // POST 登录
  logout: '/MicroApi/auth/logout', // POST 退出登录
  register: '/MicroApi/auth/register', // POST 注册
  checkAccount: '/MicroApi/auth/phone', // GET 验证手机号是否存在
  fetchMsmCode: '/MicroApi/auth/getRegisterCode', // POST 获取手机验证码
  user: '/MicroApi/auth/user',  // GET 获取用户信息
  getRetrieveCode: '/MicroApi/auth/getRetrieveCode', // 忘记密码,获取手机验证码
  retrievePassword: '/MicroApi/auth/retrievePassword', // 忘记密码,更新密码
  changePassword: '/MicroApi/auth/changePassword', // 修改密码
  // Product
  productList: '/MicroApi/product/lists', // GET 产品库列表
  productRecommendList: '/MicroApi/product/recommendList', // GET 产品库列表
  productShow: '/MicroApi/product', // GET 商品详情
  productSearch: '/MicroApi/product/search', // GET 商品搜索

  // Cart
  cart: '/MicroApi/cart', // POST 我的购物车列表
  cartadd: '/MicroApi/cart/add', // POST 添加产品到购物车
  cartdel: '/MicroApi/cart/deleted', // POST 删除购物车
  cartfetch_count: '/MicroApi/cart/fetch_count', // POST 删除购物车

  // 下单
  orderStore: '/MicroApi/order/store', // 直接下单
  orderLists: 'MicroApi/order/lists', // 订单列表
  order: '/MicroApi/order', // 订单详情
  microStore: '/MicroApi/order/microStore', // 购物车下单
  delorder: '/MicroApi/order/delete', // 删除订单

  // 城市信息
  city: '/city',
  fetchCity: '/fetchCity',

  // 收货地址管理
  delivery_address: '/MicroApi/delivery_address/list', // 我的收货地址
  add_address: '/MicroApi/delivery_address/submit', // 添加/编辑收货地址
  addr_details: '/MicroApi/delivery_address/show', // 编辑时获取当前地址
  del_address: '/MicroApi/delivery_address/deleted', // 删除收货地址
  default_address: '/MicroApi/delivery_address/defaulted', // 快捷更新默认收货地址

  // 支付方式
  pay_ment: '/pay/pay_types',
  wxPay: '/pay/wxPay',
  // test
  test: '/'
}
