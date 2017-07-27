
export default {
  // Auth
  login: '/saasApi/auth/login', // POST 登录
  logout: '/saasApi/auth/logout', // POST 退出登录
  register: '/saasApi/auth/register', // POST 注册
  check_account: '/saasApi/auth/phone',  // GET 验证手机号是否存在
  fetch_msm_code: '/saasApi/auth/getRegisterCode', // POST 获取手机验证码
  user: '/saasApi/auth/user',  // GET 获取用户信息

  // Product
  productLists: '/saasApi/product/recommendList', // GET 产品库列表
  productShow: '/saasApi/product/info', // GET 商品详情
  // 商品素材
  productImageList: '/saasApi/product/imageLists', // GET 商品图片列表
  productTextList: '/saasApi/product/describeLists', // GET 文字素材
  productArticleList: '/saasApi/product/articleLists', // GET 文章列表
  productArticle: '/saasApi/product/article', // GET 文章详情
  productVideoList: '/saasApi/product/videoLists', // GET 视频列表
  productVideo: '/saasApi/product/video', // GET 视频详情

  // center
  myProductList: '/saasApi/product/cooperateProductLists', // GET 合作的商品列表
  trueCooperProduct: '/saasApi/product/trueCooperate', // POST 添加、取消合作产品
  surveyIndex: '/saasApi/survey/index', // GET 账户概况
  surveySalesTrends: '/saasApi/survey/salesTrends', // GET 销售趋势
  surveyTopFlag: '/saasApi/survey/topFlag', // GET Top20标签
  surveySalesRanking: '/saasApi/survey/salesRanking', // GET 商品销售排行
  surveyHourOrder: '/saasApi/survey/hourOrder', // GET 24小时下单统计
  surveyCustomerPriceDistribution: '/saasApi/survey/customerPriceDistribution', // GET 客单价分布
  surveyRepeatPurchase: '/saasApi/survey/repeatPurchase', // GET 重复购买率
  surveyOrderDistribution: '/saasApi/survey/orderDistribution', // GET 订单地域分步
  surveySourceSales: '/saasApi/survey/sourceSales', // GET 销售渠道

  test: '/'  // End
}
