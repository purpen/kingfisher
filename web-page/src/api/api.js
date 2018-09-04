
export default {
  // Auth
  login: '/DealerApi/auth/login',  // POST 登录
  user: '/DealerApi/auth/user',  // GET 获取用户信息
  getRegisterCode: '/DealerApi/auth/getRegisterCode',  // POST 注册获取验证码
  getRetrieveCode: '/DealerApi/auth/getRetrieveCode',  // POST 找回密码验证码
  check_account1: '/DealerApi/auth/phone',  // GET 验证手机号是否存在
  retrievePassword: '/DealerApi/auth/retrievePassword',  // POST 更改新密码
  logout: '/DealerApi/auth/logout', // POST 退出登录
  register: '/DealerApi/auth/register', // POST 注册
  captchaUrl: '/DealerApi/auth/captchaUrl',  // 获取图形验证码
  verify: '/DealerApi/auth/verify',  // 验证短信验证码
  // 附件操作
  // deleteAsset: '/saasApi/tools/deleteAsset', // POST 删除附件
  // 填写认证信息
  upToken: '/DealerApi/tools/getToken',  // 获取上传token
  category: '/DealerApi/message/category',  // 获取商品分类(提交信息时)
  authorization: '/DealerApi/message/authorization',  // 获取授权条件(提交信息时)
  city: '/DealerApi/message/city',  // 获取省份
  fetchCity: '/DealerApi/message/fetchCity',  // 获取市
  addMessage: '/DealerApi/message/addMessage',   // POST 经销商信息添加
  updateMessage: '/DealerApi/message/updateMessage',   // POST 经销商信息添加

  // showMessage
  showMessage: '/DealerApi/message/show',  //
  AddressSubmit: '/DealerApi/address/submit',  //

  // Products
  productlist: '/DealerApi/product/list',  // GET 产品库列表
  productShow: '/DealerApi/product/info', // GET 商品详情
  search: '/DealerApi/product/search', // GET 商品详情
  productRecommendList: '/DealerApi/product/recommendList', // GET 智能推荐

  // 商品素材
  productImageList: '/saasApi/product/imageLists', // GET 商品图片列表
  productTextList: '/saasApi/product/describeLists', // GET 文字素材
  productArticleList: '/saasApi/product/articleLists', // GET 文章列表
  productArticle: '/saasApi/product/article', // GET 文章详情
  productVideoList: '/saasApi/product/videoLists', // GET 视频列表
  productVideo: '/saasApi/product/video', // GET 视频详情
  productArticleDownload: '/saasApi/product/article/download', // GET 文章下载

  // center
  myProductList: '/saasApi/product/cooperateProductLists', // GET 合作的商品列表
  trueCooperProduct: '/saasApi/product/trueCooperate', // POST 添加、取消合作产品
  surveyIndex: '/saasApi/survey/index',                   // GET 账户概况
  surveySalesTrends: '/saasApi/survey/salesTrends', // GET 销售趋势
  surveyTopFlag: '/saasApi/survey/topFlag', // GET Top20标签
  surveySalesRanking: '/saasApi/survey/salesRanking', // GET 商品销售排行
  surveyHourOrder: '/saasApi/survey/hourOrder', // GET 24小时下单统计
  surveyCustomerPriceDistribution: '/saasApi/survey/customerPriceDistribution', // GET 客单价分布
  surveyRepeatPurchase: '/saasApi/survey/repeatPurchase', // GET 重复购买率
  surveyOrderDistribution: '/saasApi/survey/orderDistribution', // GET 订单地域分步
  surveySourceSales: '/saasApi/survey/sourceSales', // GET 销售渠道

  // 订单
  // orderCity: '/DealerApi/order/city', // GET 收货地址获取省
  // orderFetchCity: '/DealerApi/order/fetchCity', // GET 收货地址获取市
  orders: '/DealerApi/orders', // GET 订单列表
  order: '/DealerApi/order', // GET 订单详情
  orderStore: '/DealerApi/order/store', // POST 保存订单
  orderDestroy: '/DealerApi/order/destroy', // POST 删除订单
  orderExcel: '/saasApi/order/excel', // POST 订单导入
  fileRecords: '/saasApi/fileRecords', // GET 导入记录
  fileRecordsDestroy: '/saasApi/fileRecords/destroy', // POST 订单记录删除

  // 城市

  test: '/',  // End
  // 商品库
  LibraryOfGoodsIndexlist: '/DealerApi/product/recommendList', // GET 商品库列表请求
  LibraryOfGoodsIndextitle: '/DealerApi/product/categories', // GET 商品库title能看到的列表
  LibraryOfGoodsIndexsearch: '/DealerApi/product/search', // GET 商品库搜索
  LibraryOfGoodsIndexfollow: '/DealerApi/product/follow', // POST 关注收藏
  LibraryOfGoodsIndexnotFollow: '/DealerApi/product/notFollow', // POST 取消关注收藏
  // 商品详情
  LibraryOfGoodsIndexnotinfo: '/DealerApi/product/info', // GET 商品详情
  LibraryOfGoodsIndexnotadd: '/DealerApi/cart/add' // POST 添加到产品进货单
}
