export default {
  // Auth
  login: '/MicroApi/auth/login', // POST 登录
  logout: '/MicroApi/auth/logout', // POST 退出登录
  register: '/MicroApi/auth/register', // POST 注册
  check_account: '/MicroApi/auth/phone',  // GET 验证手机号是否存在
  fetch_msm_code: '/MicroApi/auth/getRegisterCode', // POST 获取手机验证码
  user: '/MicroApi/auth/user',  // GET 获取用户信息

  // Product
  productList: '/MicroApi/product/lists', // GET 产品库列表
  productRecommendList: '/MicroApi/product/recommendList', // GET 产品库列表
  productShow: '/MicroApi/product', // GET 商品详情

  // Cart
  cart: '/MicroApi/cart', // POST 我的购物车列表
  cartadd: '/MicroApi/cart/add', // POST 添加产品到购物车
  cartdel: '/MicroApi/cart/deleted', // POST 删除购物车
  cartfetch_count: '/MicroApi/cart/fetch_count', // POST 删除购物车

  // 商品素材
  productImageList: '/MicroApi/product/imageLists', // GET 商品图片列表
  productTextList: '/MicroApi/product/describeLists', // GET 文字素材
  productArticleList: '/MicroApi/product/articleLists', // GET 文章列表
  productArticle: '/MicroApi/product/article', // GET 文章详情
  productVideoList: '/MicroApi/product/videoLists', // GET 视频列表
  productVideo: '/MicroApi/product/video', // GET 视频详情

  // center
  myProductList: '/MicroApi/product/cooperateProductLists', // GET 合作的商品列表
  trueCooperProduct: '/MicroApi/product/trueCooperate', // POST 添加、取消合作产品
  surveyIndex: '/MicroApi/survey/index',                   // GET 账户概况
  surveySalesTrends: '/MicroApi/survey/salesTrends', // GET 销售趋势
  surveyTopFlag: '/MicroApi/survey/topFlag', // GET Top20标签
  surveySalesRanking: '/MicroApi/survey/salesRanking', // GET 商品销售排行
  surveyHourOrder: '/MicroApi/survey/hourOrder', // GET 24小时下单统计
  surveyCustomerPriceDistribution: '/MicroApi/survey/customerPriceDistribution', // GET 客单价分布
  surveyRepeatPurchase: '/MicroApi/survey/repeatPurchase', // GET 重复购买率
  surveyOrderDistribution: '/MicroApi/survey/orderDistribution', // GET 订单地域分步
  surveySourceSales: '/MicroApi/survey/sourceSales', // GET 销售渠道

  test: '/'  // End
}
