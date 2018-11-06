define({ "api": [
  {
    "type": "post",
    "url": "/DealerApi/address/defaulted",
    "title": "更新默认收货地址",
    "version": "1.0.0",
    "name": "Address_defaulted",
    "group": "Address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AddressController.php",
    "groupTitle": "Address",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/address/defaulted"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/address/deleted",
    "title": "删除收货地址",
    "version": "1.0.0",
    "name": "Address_deleted",
    "group": "Address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AddressController.php",
    "groupTitle": "Address",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/address/deleted"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/address/list",
    "title": "我的收货地址",
    "version": "1.0.0",
    "name": "Address_lists",
    "group": "Address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                            // ID\n     \"name\": 张明,                   // 收货人\n     \"phone\": \"15000000000\",           // 电话\n     \"fixed_telephone\": \"021-3288129\",           // 固定电话\n     \"zip\": \"101500\",                      // 邮编\n     \"province\":北京市,                         // 省份\n     \"city\": 朝阳区,                         // 城市\n     \"county\": 三环到四环,                         // 区县\n     \"town\": 某某村,                         // 城镇／乡\n     \"address\": \"酒仙桥798\"                // 详细地址\n     \"is_default\": 1,                      // 是否默认收货地址\n     \"status\": 1,                            // 状态: 0.禁用；1.正常；\n     }\n],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"pagination\": {\n          \"total\": 705,\n          \"count\": 15,\n          \"per_page\": 15,\n          \"current_page\": 1,\n          \"total_pages\": 47,\n          \"links\": {\n          \"next\": \"http://www.work.com/DealerApi/address/lists?page=2\"\n          }\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AddressController.php",
    "groupTitle": "Address",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/address/list"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/address/show",
    "title": "收货地址详情(暂未使用)",
    "version": "1.0.0",
    "name": "Address_show",
    "group": "Address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\":\n     {\n     \"id\": 2,                            // ID\n     \"name\": 张明,                   // 收货人\n     \"phone\": \"15000000000\",           // 电话\n     \"zip\": \"101500\",                      // 邮编\n     \"province_id\": 1,                         // 省份oid\n     \"city_id\": 1,                         // 城市oid\n     \"county_id\": 1,                         // 区县oid\n     \"town_id\": 1,                         // 城镇／乡oid\n     \"address\": \"酒仙桥798\"                // 详细地址\n     \"is_default\": 1,                      // 是否默认收货地址\n     \"status\": 1,                            // 状态: 0.禁用；1.正常；\n     }\n\n*      \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"pagination\": {\n          \"total\": 705,\n          \"count\": 15,\n          \"per_page\": 15,\n          \"current_page\": 1,\n          \"total_pages\": 47,\n          \"links\": {\n          \"next\": \"http://www.work.com/DealerApi/address/show?page=2\"\n          }\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AddressController.php",
    "groupTitle": "Address",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/address/show"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/address/submit",
    "title": "添加/编辑收货地址",
    "version": "1.0.0",
    "name": "Address_submit",
    "group": "Address",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>编辑时必传</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>电话</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "fixed_telephone",
            "description": "<p>固定电话</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "province_id",
            "description": "<p>省份oiD</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市oiD</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "county_id",
            "description": "<p>城镇oiD</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "town_id",
            "description": "<p>乡oiD</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "is_default",
            "description": "<p>是否默认：0.否；1.是；</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "address",
            "description": "<p>详细地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AddressController.php",
    "groupTitle": "Address",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/address/submit"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/cart/add",
    "title": "添加产品到进货单",
    "version": "1.0.0",
    "name": "Cart_add",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "number",
            "description": "<p>购买数量 默认值：1</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品id 默认值：1</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sku_id",
            "description": "<p>sku的id 默认值：1</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"id\"    : cart_id,\n         \"status\":3,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/add"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/cart/buy",
    "title": "立即购买",
    "version": "1.0.0",
    "name": "Cart_buy",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "number",
            "description": "<p>购买数量 默认值：1</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品id 默认值：1</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sku_id",
            "description": "<p>sku的id 默认值：2</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"id\"    : cart_id,\n         \"status\":4,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/buy"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/cart/deleted",
    "title": "删除购物车",
    "version": "1.0.0",
    "name": "Cart_deleted",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>Cart id (1,4,6 支持多个ID)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/deleted"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/cart/emptyShopping",
    "title": "清空个人购物车",
    "version": "1.0.0",
    "name": "Cart_emptyShopping",
    "group": "Cart",
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/emptyShopping"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/cart/fetch_count",
    "title": "获取购物车数量",
    "version": "1.0.0",
    "name": "Cart_fetch_count",
    "group": "Cart",
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"count\"    : 1,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/fetch_count"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/cart",
    "title": "我的进货单列表",
    "version": "1.0.0",
    "name": "Cart_lists",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "status",
            "description": "<p>1:立即购买进入的进货单</p>"
          },
          {
            "group": "Parameter",
            "type": "char",
            "optional": false,
            "field": "title",
            "description": "<p>大米:搜索时所需参数</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "per_page",
            "description": "<p>1:一页多少条数据</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>1:页码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                      // 购物车ID\n     product_name :\"大米\",                   商品名称\n     inventory  :40,                 商品库存数量\n     market_price    \"111\",            商品销售价格\n     cover_url   ：1.img ,              图片url\n     \"product_id\": 4456,           // 商品ID\n     \"price\": \"200.00\",            // 商品价格\n     \"mode\":颜色：白色 ,                   类型\n     \"number\": 1,                       // 购买数量\n     \"status\": 3,                  // 状态：3添加，4立即购买\n     \"focus\": 1,                  // 状态：1关注，2未关注\n      \"sku_region\"[{\n              min:2, //下限数量\n             max:2,//上限数量\n             sell_price:22 //销售价格\n         }]\n     }\n  ],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          \"data\" : $data,\n         \"count\":22,\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/cart/reduce",
    "title": "购物车增减数量",
    "version": "1.0.0",
    "name": "Cart_reduce",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "future",
            "description": "<p>:数组 { id:1, number :20 , }</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/reduce"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/cart/settlement",
    "title": "点击结算",
    "version": "1.0.0",
    "name": "Cart_settlement",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "id",
            "description": "<p>1:一个或多个进货单id(数组形式传参)</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"product_id\": 2,                      // 商品id\n     \"sku_id\": 2,                      // sku id\n     \"product_name\" :\"大米\",            //       商品名称\n     \"cover_url\"   ：1.img ,          //    图片url\n     \"price\": \"200.00\",            // 商品价格\n     \"mode\":颜色：白色 ,               //    类型\n     \"number\": 1,                       // 购买数量\n     }\n  ],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          \"data\" : $data,\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/CartController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/cart/settlement"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/invoice/deleted",
    "title": "删除发票",
    "version": "1.0.0",
    "name": "Invoice_deleted",
    "group": "Cart",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>invoice id :1</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/InvoiceController.php",
    "groupTitle": "Cart",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/invoice/deleted"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/updateUser",
    "title": "更新用户信息",
    "version": "1.0.0",
    "name": "DealerApi_updateUser",
    "group": "DealerApi",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "random",
            "description": "<p>random</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>门店联系人手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>门店联系人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "cover_id",
            "description": "<p>头像id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>email</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "sex",
            "description": "<p>性别</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"meta\": {\n\"message\": \"Success.\",\n\"status_code\": 200\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerApi",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/updateUser"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/getRegisterCode",
    "title": "获取注册验证码",
    "version": "1.0.0",
    "name": "DealerUser_Code",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>用户手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n  \"meta\": {\n    \"message\": \"Success.\",\n    \"status_code\": 200\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/getRegisterCode"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/auth/captchaUrl",
    "title": "获取验证码路径",
    "version": "1.0.0",
    "name": "DealerUser_captchaUrl",
    "group": "DealerUser",
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n\"data\":{\n'url':  \"http://www.work.com/DealerApi/auth/createCapcha?ed17dd\"    //图片验证码路径\n'str':    'abuxbsn'  //随机字符串\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/captchaUrl"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/changePassword",
    "title": "修改密码",
    "version": "1.0.0",
    "name": "DealerUser_changePassword",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "old_password",
            "description": "<p>原密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>新密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    },\n    \"data\": {\n      \"token\": \"sdfs1sfcd\"\n   }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/changePassword"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/getRetrieveCode",
    "title": "忘记密码(验证身份)-获取手机验证码",
    "version": "1.0.0",
    "name": "DealerUser_getRetrieveCode",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/getRetrieveCode"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/login",
    "title": "登录",
    "version": "1.0.0",
    "name": "DealerUser_login",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "account",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>设置密码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n  \"meta\": {\n    \"message\": \"登录成功！\",\n    \"status_code\": 200\n  },\n  \"data\": {\n    \"token\": \"eyJ0eXAiOiiOiJIUzI1NiJ9.sIm5iZiI6MTzkifQ.piS_YZhOqsjAF4XbxELIs2y70cq8\",\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/login"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/logout",
    "title": "退出登录",
    "version": "1.0.0",
    "name": "DealerUser_logout",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n   \"meta\": {\n     \"message\": \"A token is required\",\n     \"status_code\": 500\n   }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/logout"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/auth/phone",
    "title": "检测手机号是否注册",
    "version": "1.0.0",
    "name": "DealerUser_phone",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n  \"meta\": {\n    \"message\": \"可以注册.\",\n    \"status_code\": 200\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/phone"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/register",
    "title": "用户注册",
    "version": "1.0.0",
    "name": "DealerUser_register",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "random",
            "description": "<p>随机数</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "account",
            "description": "<p>用户账号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>设置密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>门店联系人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_name",
            "description": "<p>门店名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>门店联系人手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "province_id",
            "description": "<p>门店所在省份oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "city_id",
            "description": "<p>门店城市oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "county_id",
            "description": "<p>下级区县oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "enter_province",
            "description": "<p>企业所在省份oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "enter_city",
            "description": "<p>企业城市oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "enter_county",
            "description": "<p>企业区县oID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "operation_situation",
            "description": "<p>主要情况</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "front_id",
            "description": "<p>门店正面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "Inside_id",
            "description": "<p>门店内部照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "portrait_id",
            "description": "<p>身份证人像面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "national_emblem_id",
            "description": "<p>身份证国徽面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "position",
            "description": "<p>职位</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "full_name",
            "description": "<p>企业全称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal_person",
            "description": "<p>法人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal_phone",
            "description": "<p>法人手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "enter_phone",
            "description": "<p>企业电话</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal_number",
            "description": "<p>法人身份证号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "ein",
            "description": "<p>税号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "taxpayer",
            "description": "<p>纳税人类型</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_name",
            "description": "<p>开户行</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_address",
            "description": "<p>企业详细地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "enter_Address",
            "description": "<p>门店详细地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "business_license_number",
            "description": "<p>统一社会信用代码</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "mode",
            "description": "<p>是否月结</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "contract_id",
            "description": "<p>电子版合同照片id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n   \"meta\": {\n     \"message\": \"Success\",\n     \"status_code\": 200\n   }\n   \"data\": {\n        \"token\": \"\"\n    }\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/register"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/retrievePassword",
    "title": "忘记密码-更改新密码",
    "version": "1.0.0",
    "name": "DealerUser_retrievePassword",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>短信验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "captcha",
            "description": "<p>图片验证码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "str",
            "description": "<p>随机字符串</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/retrievePassword"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/upToken",
    "title": "更新或换取新Token",
    "version": "1.0.0",
    "name": "DealerUser_token",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"更新Token成功！\",\n      \"status_code\": 200\n    },\n    \"data\": {\n      \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9\"\n   }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/upToken"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/auth/user",
    "title": "获取用户信息",
    "version": "1.0.0",
    "name": "DealerUser_user",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": {\n\"id\": 1,\n\"realname\": \"张三疯\",               // 真实姓名\n\"phone\": \"15810295774\",                 // 手机号\n\"status\": 1                             // 状态 0.未激活 1.激活\n\"type\": 4                             // 类型 0.ERP ；1.分销商；2.c端用户; 4.经销商；\n\"verify_status\": 1                       // 资料审核 1.待审核，2.拒绝，3.通过\n\"distributor_status\": 0                       //审核状态：1.待审核；2.已审核；3.关闭；4.重新审核\n\"mode\": \"月结\",               // 是否可以月结 1.月结 2.非月结\n},\n\n\"meta\": {\n\"message\": \"Success.\",\n\"status_code\": 200\n}\n}Request $request",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/user"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/auth/verify",
    "title": "验证注册短信验证码",
    "version": "1.0.0",
    "name": "DealerUser_verify",
    "group": "DealerUser",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>用户账号/手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "code",
            "description": "<p>验证码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n  \"meta\": {\n    \"message\": \"success！\",\n    \"status_code\": 200\n  },\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/AuthenticateController.php",
    "groupTitle": "DealerUser",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/auth/verify"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/history/application",
    "title": "开票记录中申请开票",
    "version": "1.0.0",
    "name": "HistoryInvoice_application",
    "group": "HistoryInvoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>1:发票历史id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "invoice_id",
            "description": "<p>1:发票表id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "order_id",
            "description": "<p>1:订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "invoicevalue",
            "description": "<p>321:订单金额</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/HistoryInvoiceController.php",
    "groupTitle": "HistoryInvoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/history/application"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/history/historyTo",
    "title": "查看专用增值税发票详情-弹框页面",
    "version": "1.0.0",
    "name": "HistoryInvoice_historyTo",
    "group": "HistoryInvoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>1:发票历史id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                      // 发票历史表id\n     \"number\": DD2018042600003,    // 订单号\n     total_money :\"500\",            //总金额\n     receiving_id\t  :1,            //发票类型 发票类型0.不开票 1.普通发票 2.专票\n     company_name    \"111\",            //名称\n     duty_paragraph   ：84091-1,   //税号\n     \"unit_address\": 时尚广场,           // 单位地址\n     \"company_phone\":15112341234,               // 电话号码\n     \"opening_bank\":小关支行,               // 开户银行\n     \"receiving_name\":李白,               // 收件人姓名\n     \"receiving_phone\":15112341234,               // 收件人电话\n     \"receiving_address\":时尚广场,               // 收件人地址\n     }\n  ],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          \"history\" : $history,\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/HistoryInvoiceController.php",
    "groupTitle": "HistoryInvoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/history/historyTo"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/history/lists",
    "title": "开票记录列表",
    "version": "1.0.0",
    "name": "HistoryInvoice_lists",
    "group": "HistoryInvoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "receiving_type",
            "description": "<p>1:开发票的状态 1.未开票 2.审核中 3.已开票. 4.拒绝 5.已过期(为空查询所有)</p>"
          },
          {
            "group": "Parameter",
            "type": "char",
            "optional": false,
            "field": "number",
            "description": "<p>DD2018042600002:搜索时所需参数</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "per_page",
            "description": "<p>1:一页多少条数据</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "page",
            "description": "<p>1:页码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                      // 发票历史表id\n     receiving_id :\"1\",            //发票类型 发票类型0.不开票 1.普通发票 2.专票\n     receving_type  :1,            //开发票的状态 1.未开票 2.审核中 3.已开票. 4.拒绝 5.已过期\n     order_id    \"111\",            //订单id\n     number   ：DD2018042600002,   //订单编号\n     \"total_money\": 500.00,           // 订单金额\n     \"remaining\":178,               // 未开票倒计时(天数)\n     }\n  ],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          \"data\" : $data,\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/HistoryInvoiceController.php",
    "groupTitle": "HistoryInvoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/history/lists"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/invoice",
    "title": "发票管理",
    "version": "1.0.0",
    "name": "Invoice",
    "group": "Invoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"invoice\": [\n     {\n     \"company_name\": 太火鸟1,              // 公司全称\n     \"company_phone\": 15112341234,          // 公司电话\n     \"opening_bank\": 小关支行,           // 开户行\n     \"bank_account\": 879799***989,           // 银行账户\n     \"unit_address\": 朝阳区时尚广场b区,           // 单位地址\n     \"duty_paragraph\": 7879***8032,           // 税号\n     \"receiving_address\": 朝阳时尚广场C区A東,      // 发票收件地址\n     \"receiving_name\": 李白,      // 发票收件姓名\n     \"cover_url\": 1.img,      // 一般纳税人证明(专票时有url,普通时无此字段)\n     \"receiving_phone\": 15112341234,      // 发票收件电话\n     \"receiving_id\" :\"1\",            //  \t发票类型0.不开票 1.普通发票 2.专票\n     }\n  ],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          \"invoice\" : $invoice,\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/InvoiceController.php",
    "groupTitle": "Invoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/invoice"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/invoice/ordinaryAdd",
    "title": "普通和专票发票添加",
    "version": "1.0.0",
    "name": "Invoice_ordinaryAdd",
    "group": "Invoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "char",
            "optional": false,
            "field": "province_id",
            "description": "<p>3:省份id</p>"
          },
          {
            "group": "Parameter",
            "type": "char",
            "optional": false,
            "field": "city_id",
            "description": "<p>3:市id</p>"
          },
          {
            "group": "Parameter",
            "type": "char",
            "optional": false,
            "field": "area_id",
            "description": "<p>3:县\\区id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "company_name",
            "description": "<p>太火鸟科技:公司全称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "company_phone",
            "description": "<p>15112341234:公司电话</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "opening_bank",
            "description": "<p>小关支行:开户行</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_account",
            "description": "<p>5361*********:银行账户</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "unit_address",
            "description": "<p>时尚广场:单位地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "duty_paragraph",
            "description": "<p>998766331:税号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "receiving_id",
            "description": "<p>1:发票类型0.不开票 1.普通发票 2.专票</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "receiving_address",
            "description": "<p>时尚广场xx楼:发票收件地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "receiving_name",
            "description": "<p>李白:收件人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "receiving_phone",
            "description": "<p>15311112222:收件人电话</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "\"meta\": {\n    \"message\": \"添加成功.\",\n    \"status_code\": 200,\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/InvoiceController.php",
    "groupTitle": "Invoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/invoice/ordinaryAdd"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/invoice/ordinaryEdit",
    "title": "普通发票和专票修改",
    "version": "1.0.0",
    "name": "Invoice_ordinaryEdit",
    "group": "Invoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>3:发票id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "\"meta\": {\n    \"message\": \"Success.\",\n    \"status_code\": 200,\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/InvoiceController.php",
    "groupTitle": "Invoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/invoice/ordinaryEdit"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/invoice/ordinaryList",
    "title": "普通发票和专票编辑展示与详情",
    "version": "1.0.0",
    "name": "Invoice_ordinaryList",
    "group": "Invoice",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "int",
            "optional": false,
            "field": "id",
            "description": "<p>3:发票id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": " {\"ids\": [\n     {\n     \"company_name\": 太火鸟2,              // 公司全称\n     \"company_phone\": 15112341234,          // 公司电话\n     \"opening_bank\": 小关支行,           // 开户行\n     \"bank_account\": 879799***989,           // 银行账户\n     \"unit_address\": 朝阳区时尚广场b区,           // 单位地址\n     \"duty_paragraph\": 7879***8032,           // 税号\n     \"receiving_address\": 朝阳时尚广场C区A東,      // 发票收件地址\n     \"receiving_name\": 李白,      // 发票收件姓名\n     \"cover_url\": 1.img,      // 一般纳税人证明(专票时有url,普通时无此字段)\n     \"receiving_phone\": 15112341234,      // 发票收件电话\n     \"receiving_id\" :\"1\",            //  \t发票类型0.不开票 1.普通发票 2.专票\n     }\n  ],\n     \"meta\": {\n         \"message\": \"success.\",\n         \"status_code\": 200,\n         'ids':$ids,\n      }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/InvoiceController.php",
    "groupTitle": "Invoice",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/invoice/ordinaryList"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/message/addMessage",
    "title": "经销商信息添加(暂不使用)",
    "version": "1.0.0",
    "name": "Message_addMessage",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "random",
            "description": "<p>随机数</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_name",
            "description": "<p>门店名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>电话</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "province_id",
            "description": "<p>省份ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "city_id",
            "description": "<p>城市ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "category_id",
            "description": "<p>商品分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "authorization_id",
            "description": "<p>授权条件</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_address",
            "description": "<p>门店地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "operation_situation",
            "description": "<p>经营情况</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "front_id",
            "description": "<p>门店正面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "Inside_id",
            "description": "<p>门店内部照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "portrait_id",
            "description": "<p>身份证人像面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "national_emblem_id",
            "description": "<p>身份证国徽面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "license_id",
            "description": "<p>营业执照照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "bank_number",
            "description": "<p>银行卡账号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_name",
            "description": "<p>开户行</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "business_license_number",
            "description": "<p>营业执照号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "taxpayer",
            "description": "<p>纳税人类型:1.一般纳税人 2.小规模纳税人</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                            // ID\n     \"user_id\": 2,                            // 用户ID\n     \"name\": 小明,           // 姓名\n     \"phone\": 13265363728,           // 电话\n     \"store_name\": 铟立方,           // 门店名称\n     \"province_id\": 1,                         // 省份oid\n     \"city_id\": 1,                         // 城市oid\n     \"category_id\": \"116\",           // 商品分类id\n     \"authorization_id\": 11,2,                          // 授权条件\n     \"store_address\": 北京市朝阳区,                      // 门店地址\n     \"operation_situation\": 非常好,                         // 经营情况\n     \"front_id\": \"1\",                  // 门店正面照片\n     \"Inside_id\": \"2\",                  // 门店内部照片\n     \"portrait_id\": \"3\",                  // 身份证人像面照片\n     \"national_emblem_id\": \"4\",                  // 身份证国徽面照片\n     \"license_id\": \"5\",                  // 营业执照照片\n     \"bank_number\": \"1234567890\",              // 银行卡账号\n     \"bank_name\": 中国银行,               // 开户行\n     \"business_license_number\":  \"638272611291\",     //营业执照号\n     \"taxpayer\": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人\n     }\n],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/addMessage"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/authorization",
    "title": "获取授权条件",
    "version": "1.0.0",
    "name": "Message_authorization",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/authorization"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/category",
    "title": "所有商品分类列表",
    "version": "1.0.0",
    "name": "Message_category",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/category"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/city",
    "title": "省份列表",
    "version": "1.0.0",
    "name": "Message_cities",
    "group": "Message",
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/city"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/county",
    "title": "根据城市查看下级县(区)的列表",
    "version": "1.0.0",
    "name": "Message_county",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "oid",
            "description": "<p>唯一（父id）</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "layer",
            "description": "<p>级别（子id）3</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/county"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/fetchCity",
    "title": "根据省份查看下级城市的列表",
    "version": "1.0.0",
    "name": "Message_fetchCity",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "oid",
            "description": "<p>唯一（父id）</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "layer",
            "description": "<p>级别（子id）2</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/fetchCity"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/show",
    "title": "经销商信息展示",
    "version": "1.0.0",
    "name": "Message_show",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                            // ID\n     \"user_id\": 1,                            // 用户ID\n     \"name\": 小明,           // 门店联系人姓名\n     \"ein\": 12345,           // 税号\n     \"phone\": 13265363728,           // 电话\n     \"enter_phone\": 13435363728,           // 企业电话\n     \"legal_phone\": 13435233728,           // 法人电话\n     \"store_name\": 铟立方,           // 门店名称\n     \"province_id\": 1,                         // 省份\n     \"city_id\": 1,                         // 城市\n     \"county_id\": 1,                         // 县\n     \"enter_province\": 1,                         // 企业省份\n     \"enter_city\": 1,                         // 企业城市\n     \"enter_county\": 1,                         // 企业县\n     \"category_id\": \"11，12\",           // 商品分类id\n     \"authorization_id\": 11,2,                          // 授权条件\n     \"operation_situation\": 非常好,                         // 经营情况\n     \"front_id\": \"1\",                  // 门店正面照片\n     \"Inside_id\": \"2\",                  // 门店内部照片\n     \"portrait_id\": \"3\",                  // 身份证人像面照片\n     \"national_emblem_id\": \"4\",                  // 身份证国徽面照片\n     \"bank_number\": \"1234567890\",              // 银行卡账号\n     \"bank_name\": 中国银行,               // 开户行\n     \"legal_number\":               // 法人身份证号\n     \"legal_person\":               // 法人姓名\n     \"full_name\":               // 企业全称\n     \"position\":               // 职位\n     \"store_address\":               // 门店详细地址\n     \"enter_Address\":               // 企业详细地址\n     \"business_license_number\":  \"638272611291\",     //统一社会信用代码\n     \"taxpayer\": 1,                      // 纳税人类型:1.一般纳税人 2.小规模纳税人\n    \"status\": 1,                    // 状态：1.待审核；2.已审核；3.关闭；4.重新审核\n     }\n],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/show"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/message/town",
    "title": "根据区县查看下级乡镇的列表",
    "version": "1.0.0",
    "name": "Message_town",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "oid",
            "description": "<p>唯一（父id）</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "layer",
            "description": "<p>级别（子id）4</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/town"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/message/updateMessage",
    "title": "经销商信息修改",
    "version": "1.0.0",
    "name": "Message_updateMessage",
    "group": "Message",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "target_id",
            "description": "<p>关联id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>门店联系人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_name",
            "description": "<p>门店名称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "phone",
            "description": "<p>门店联系人手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "province_id",
            "description": "<p>门店所在省份oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "city_id",
            "description": "<p>门店城市oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "county_id",
            "description": "<p>下级区县oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "enter_province",
            "description": "<p>企业所在省份oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "enter_city",
            "description": "<p>企业城市oID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "enter_county",
            "description": "<p>企业区县oID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "operation_situation",
            "description": "<p>主要情况</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "front_id",
            "description": "<p>门店正面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "Inside_id",
            "description": "<p>门店内部照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "portrait_id",
            "description": "<p>身份证人像面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "national_emblem_id",
            "description": "<p>身份证国徽面照片</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "position",
            "description": "<p>职位</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "full_name",
            "description": "<p>企业全称</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal_person",
            "description": "<p>法人姓名</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal_phone",
            "description": "<p>法人手机号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "enter_phone",
            "description": "<p>企业电话</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "legal_number",
            "description": "<p>法人身份证号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "ein",
            "description": "<p>税号</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "taxpayer",
            "description": "<p>纳税人类型</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "bank_name",
            "description": "<p>开户行</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "store_address",
            "description": "<p>门店详细地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "enter_Address",
            "description": "<p>企业详细地址</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "business_license_number",
            "description": "<p>统一社会信用代码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                            // ID\n     \"ein\": 23452,                       // 税号\n     \"user_id\": 2,                       // 用户ID\n     \"name\": 小明,                        // 姓名\n     \"phone\": 187254262512,              // 电话\n     \"store_name\": 铟立方,                // 门店名称\n     \"province_id\": 1,                   // 省份ID\n     \"city_id\": 1,                       // 城市ID\n     \"county_id\": 1,                      //区县ID\n     \"enter_province\": 1,                // 企业省份oID\n     \"enter_city\": 1,                    // 企业城市oID\n     \"enter_county\": 1,                   //企业区县oID\n     \"operation_situation\": 非常好,      //  经营情况\n     \"front_id\": \"1\",                  //   门店正面照片\n     \"Inside_id\": \"2\",                  //  门店内部照片\n     \"portrait_id\": \"3\",                  //身份证人像面照片\n     \"national_emblem_id\": \"4\",          // 身份证国徽面照片\n     \"bank_number\": \"1234567890\",        // 银行卡账号\n     \"bank_name\": 中国银行,               // 开户行\n     \"business_license_number\":  \"\",      //统一社会信用代码\n     \"position\"                          //职位\n     \"enter_phone\"                       //企业电话\n     \"full_name\"                         //企业全称\n     \"legal_person\"                      //法人姓名\n     \"legal_phone\"                       //法人手机号\n     \"legal_number\"                      //法人身份证号\n     \"store_address\"                      //门店详细地址\n     \"enter_Address\"                      //企业详细地址\n     \"taxpayer\": 1,                      //纳税人类型:1.一般纳税人 2.小规模纳税人\n     \"status\": 1,                    // 状态：1.待审核；2.已审核；3.关闭；4.重新审核\n     }\n],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/MessageController.php",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/message/updateMessage"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/order/cancel",
    "title": "取消订单",
    "version": "1.0.0",
    "name": "Order_cancel",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order/cancel"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/order/confirm",
    "title": "确认收货",
    "version": "1.0.0",
    "name": "Order_confirm",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order/confirm"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/order/destroy",
    "title": "订单删除",
    "version": "1.0.0",
    "name": "Order_destroy",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order/destroy"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/order",
    "title": "订单详情",
    "version": "1.0.0",
    "name": "Order_order",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n \"data\": {\n \"id\": 25918,\n \"number\": \"11969757068000\",  //订单编号\n \"pay_money\": \"119.00\",   //应付总金额\n \"total_money\": \"299.00\",    //商品总金额\n \"count\": 1,                 //商品总数量\n \"user_id\": 19,             //用户id\n \"express_id\": 3,        // 物流id\n \"express\": 圆通快递,        //快递名称\n \"express_no\": 536728987,     //快递单号\n \"order_start_time\": \"0000-00-00 00:00:00\", //发货时间\n \"status\": 8,\n \"status_val\": \"待发货\",                //状态   2.上传凭证待审核\n \"receiving_id\": \"1\",          //发票类型(0.不开 1.普通 2.专票)\n \"company_name\": \"北京太火红鸟科技有限公司\",          //发票抬头\n \"invoice_value\": \"1453\",        //发票金额\n \"over_time\": \"2018-09-11 00:00:00\",  //过期时间\n\n  \"address\": \"三亚市天涯海角\",\n  \"province_id\": 23,\n  \"city_id\": 3690,\n  \"county_id\": 3696,\n  \"town_id\": 0,\n  \"name\": \"小蜜蜂\",\n  \"phone\": \"17802998888\",\n  \"zip\": null,\n  \"is_default\": 0,\n  \"status\": 1,\n  \"created_at\": \"2018-09-03 19:22:48\",\n  \"updated_at\": \"2018-09-04 15:53:10\",\n  \"deleted_at\": null,\n  \"fixed_telephone\": null\n  \"orderSkus\": [\n{\n\"sku_id\": 42,\n\"price\":   单价\n\"product_title\": \"小风扇\",                   //商品名称\n\"quantity\": 1,                      //订单明细数量\n\"sku_mode\": \"黑色\",                     // 颜色/型号\n\"image\": \"http://www.work.com/images/default/erp_product1.png\",   //sku图片\n}\n]\n },\n\"meta\": {\n \"message\": \"Success.\",\n\"status_code\": 200\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/orders",
    "title": "订单列表",
    "version": "1.0.0",
    "name": "Order_orders",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "status",
            "description": "<p>状态: 0.全部； -1.取消(过期)；1.待付款；2.上传凭证待确认 5.待审核；6.待财务审核 8.待发货；10.已发货；20.完成</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "types",
            "description": "<p>0.全部 1.当月</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": " {\n\"data\": [\n{\n \"id\": 25918,\n  \"number\": \"11969757068000\",       //订单编号\n \"buyer_name\": \"冯宇\",               //收货人\n \"pay_money\": \"119.00\",              //支付总金额\n \"user_id\": 19,\n\"order_start_time\": \"0000-00-00 00:00:00\", //下单时间\n\"status\": 8,\n\"status_val\": \"待发货\",                 //订单状态\n\"payment_type\": \"在线支付\"               //支付方式\n\"total_money\": \"299.00\",             //商品总金额\n\"count\": 1,                            //商品总数量\n\"sku_relation\": [\n{\n\"sku_id\": 42,\n\"price\":   单价\n\"product_title\": \"小风扇\",                   //商品名称\n\"quantity\": 1,                      //订单明细数量\n\"sku_mode\": \"黑色\",                     // 颜色/型号\n\"image\": \"http://www.work.com/images/default/erp_product1.png\",   //sku图片\n}\n],\n \"meta\": {\n \"message\": \"Success.\",\n \"status_code\": 200,\n \"pagination\": {\n \"total\": 717,\n \"count\": 2,\n \"per_page\": 2,\n \"current_page\": 1,\n \"total_pages\": 359,\n \"links\": {\n \"next\": \"http://www.work.com/DealerApi/orders?page=2\"\n }\n }\n }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/orders"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/order/pay_money",
    "title": "收银台",
    "version": "1.0.0",
    "name": "Order_pay_money",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order/pay_money"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/order/store",
    "title": "保存新建订单",
    "version": "1.0.0",
    "name": "Order_store",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "address_id",
            "description": "<p>收获地址ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "payment_type",
            "description": "<p>付款方式：1.在线 4.月结；6.公司转账</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "invoice_id",
            "description": "<p>发票id  0.不开发票</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "sku_id_quantity",
            "description": "<p>sku_id和数量 [{&quot;sku_id&quot;:&quot;9&quot;,&quot;quantity&quot;:&quot;15&quot;}]</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "product_id",
            "description": "<p>'2,1,4,9'</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order/store"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/order/upload_img",
    "title": "上传转账凭证",
    "version": "1.0.0",
    "name": "Order_upload_img",
    "group": "Order",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "payment_type",
            "description": "<p>付款方式：1.在线 6.公司转账</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "voucher_id",
            "description": "<p>银行凭证图片ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "order_id",
            "description": "<p>订单ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "random",
            "description": "<p>随机数</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n    \"meta\": {\n      \"message\": \"Success\",\n      \"status_code\": 200\n    }\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/OrderController.php",
    "groupTitle": "Order",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/order/upload_img"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/product/categories",
    "title": "经销商能看到的商品分类列表",
    "version": "1.0.0",
    "name": "Products_categories",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/categories"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/product/follow",
    "title": "关注商品",
    "version": "1.0.0",
    "name": "Products_follow",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n{\n\"id\": 2,\n\"product_id\": 60,                   // 商品ID\n}\n],\n\"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/follow"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/product/followList",
    "title": "关注的商品列表",
    "version": "1.0.0",
    "name": "Products_followList",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "per_page",
            "description": "<p>分页数量  默认10</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n{\n\"id\": 2,\n\"product_id\": 60,                   // 商品ID\n\"number\": \"116110418454\",           // 商品编号\n\"name\": \"Artiart可爱便携小鸟刀水果刀\",    // 商品名称\n\"price\": \"200.00\",                      // 商品价格\n\"image\": \"http://erp.me/images/default/erp_product.png\",\n}\n],\n\"meta\": {\n         \"pagination\": {\n          \"total\": 705,\n          \"count\": 15,\n          \"per_page\": 15,\n          \"current_page\": 1,\n          \"total_pages\": 47,\n          \"links\": {\n          \"next\": \"http://www.work.com/DealerApi/product/followList?page=2\"\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/followList"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/product/info",
    "title": "商品详情",
    "version": "1.0.0",
    "name": "Products_info",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": {\n\"id\": 2,\n\"product_id\": 60,                           // 商品ID\n\"number\": \"116110418454\",                   // 商品编号\n\"category\": \"智能硬件\",                         //分类\n\"name\": \"Artiart可爱便携小鸟刀水果刀\",            //商品名称\n\"short_name\": \"Artiart可爱便携小鸟刀水果刀\",      //短名称\n\"price\": \"200.00\",                              // 价格\n\"sale_price\": \"123\",                           // 供货价\n\"weight\": \"0.00\",                               // 重量\n\"summary\": \"\",                                  // 备注\n\"inventory\": 1,                                 // 库存\n\"image\": \"http://erp.me/images/default/erp_product.png\",\n\"product_details\"                               //商品图文详情\n\"status\": 1                          // 状态：0.未合作；1.已合作\n\"sales_number\": 23                           // 销售数量\n\"follows\":109                                //此商品被关注数量\n\"follow\":0                                //有未被关注 0.无 1.有\n\"mode\":1                                //是否为月结 1.月结 2.非月结\n\"skus\": [\n{\n\"sku_id\": 42,\n\"number\": \"116110436487\",\n\"mode\": \"黑色\",                     // 型号\n\"price\": \"123.00\"                   // 价格\n\"sale_price\": \"123\",               // 供货价\n\"image\": \"http://erp.me/images/default/erp_product1.png\",\n \"product_details\":  \"<img src=\"/uploads/ueditor/php/upload/image/20180829/1535523347162632.jpeg\",\n\"inventory\": 0                               // 库存\n\n \"sku_region\": [\n     {\n     \"id\": 2,                            // ID\n     \"sku_id\": 60,                   // skuID\n     \"user_id\": \"1\",           // 用户id\n     \"min\": \"1\",    // 下限数量\n     \"max\": \"50\",    // 上限数量\n     \"sell_price\": \"200.00\",                      // 商品价格\n     }\n],\n},\n]\n},\n\"meta\": {\n\"message\": \"Success.\",\n\"status_code\": 200\n}\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/info"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/product/lists",
    "title": "商品库列表(暂未使用)",
    "version": "1.0.0",
    "name": "Products_lists",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "per_page",
            "description": "<p>分页数量  默认10</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                            // 商品ID\n     \"product_id\": 60,                   // 商品ID\n     \"number\": \"116110418454\",           // 商品编号\n     \"name\": \"Artiart可爱便携小鸟刀水果刀\",    // 商品名称\n     \"price\": \"200.00\",                      // 商品价格\n     \"inventory\": 1,                         // 库存\n     \"image\": \"http://erp.me/images/default/erp_product.png\",\n     \"status\": 1                          // 状态：0.未合作；1.已合作\n     }\n],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"pagination\": {\n             \"total\": 1,\n             \"count\": 1,\n             \"per_page\": 10,\n             \"current_page\": 1,\n             \"total_pages\": 1,\n             \"links\": []\n             }\n         }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/lists"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/product/notFollow",
    "title": "取消关注商品",
    "version": "1.0.0",
    "name": "Products_notFollow",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "product_id",
            "description": "<p>商品id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n{\n\"id\": 2,\n\"product_id\": 60,        // 商品ID\n\"user_id\": 60,         // 用户ID\n}\n],\n\"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n          }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/notFollow"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/product/recommendList",
    "title": "推荐的商品列表",
    "version": "1.0.0",
    "name": "Products_recommendList",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "per_page",
            "description": "<p>分页数量  默认10</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "token",
            "description": "<p>token</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "categories_id",
            "description": "<p>商品分类ID 0代表所有 其他正常</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n{\n\"id\": 2,\n\"product_id\": 60,                   // 商品ID\n\"number\": \"116110418454\",           // 商品编号\n\"name\": \"Artiart可爱便携小鸟刀水果刀\",    // 商品名称\n\"price\": \"200.00\",                      // 商品价格\n\"inventory\": 1,                         // 库存\n\"mode\": 1,                         // 是否为月结 1.月结 2.非月结\n\"image\": \"http://www.work.com/images/default/erp_product.png\",  //商品图\n\"product_details\":  \"http://www.work.com/images/default/erp_product1.png\", //商品详情介绍图\n\"categories\"：  //分类名称\n\"follow\"：  //是否被关注  1.已关注 0.未关注\n}\n],\n\"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"pagination\": {\n          \"total\": 705,\n          \"count\": 15,\n          \"per_page\": 15,\n          \"current_page\": 1,\n          \"total_pages\": 47,\n          \"links\": {\n          \"next\": \"http://www.work.com/DealerApi/product/recommendList?page=2\"\n          }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/recommendList"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/product/search",
    "title": "商品搜索",
    "version": "1.0.0",
    "name": "Products_search",
    "group": "Products",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>商品名称</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "per_page",
            "description": "<p>分页数量  默认10</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n\"data\": [\n     {\n     \"id\": 2,                            // ID\n     \"product_id\": 60,                   // 商品ID\n     \"number\": \"116110418454\",           // 商品编号\n     \"name\": \"Artiart可爱便携小鸟刀水果刀\",    // 商品名称\n     \"price\": \"200.00\",                      // 商品供货价\n     \"inventory\": 1,                         // 库存\n     \"follow\":1                              //已关注\n     \"image\": \"http://erp.me/images/default/erp_product.png\",\n    \"product_details\":  \"http://erp.me/images/default/erp_product1.png\",\n     }\n],\n     \"meta\": {\n         \"message\": \"Success.\",\n         \"status_code\": 200,\n         \"pagination\": {\n          \"total\": 705,\n          \"count\": 15,\n          \"per_page\": 15,\n          \"current_page\": 1,\n          \"total_pages\": 47,\n          \"links\": {\n          \"next\": \"http://www.work.com/DealerApi/product/lists?page=2\"\n          }\n      }\n  }\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ProductsController.php",
    "groupTitle": "Products",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/product/search"
      }
    ]
  },
  {
    "type": "post",
    "url": "/DealerApi/tools/deleteAsset",
    "title": "删除上传附件",
    "version": "1.0.0",
    "name": "Tools_deleteAsset",
    "group": "Tools",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "id",
            "description": "<p>图片ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n   \"meta\": {\n     \"message\": \"Success\",\n     \"status_code\": 200\n   }\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ToolsController.php",
    "groupTitle": "Tools",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/tools/deleteAsset"
      }
    ]
  },
  {
    "type": "get",
    "url": "/DealerApi/tools/getToken",
    "title": "获取图片上传token",
    "version": "1.0.0",
    "name": "Tools_getToken",
    "group": "Tools",
    "success": {
      "examples": [
        {
          "title": "成功响应:",
          "content": "{\n   \"meta\": {\n     \"message\": \"Success\",\n     \"status_code\": 200\n   }\n   \"data\": {\n        \"token\": \"asdassfdg\",\n        \"url\": http://xxx.qinxiu.com,\n        \"random\": 5b557dd599c508.76159328,\n    }\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ToolsController.php",
    "groupTitle": "Tools",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.dev/DealerApi/tools/getToken"
      }
    ]
  },
  {
    "type": "post",
    "url": "http://upload.qiniu.com",
    "title": "测试服务器七牛上传url",
    "version": "1.0.0",
    "name": "Tools_upload",
    "group": "Tools",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "x:user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "x:random",
            "description": "<p>附件随机数</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "x:target_id",
            "description": "<p>目标ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "x:type",
            "description": "<p>类型：17.门店正面照片；18.门店内部照片；19.营业执照；20.身份证人像面；21.身份证国徽面</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ToolsController.php",
    "groupTitle": "Tools",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.devhttp://upload.qiniu.com"
      }
    ]
  },
  {
    "type": "post",
    "url": "http://upload.qiniu.com",
    "title": "测试服务器七牛上传url",
    "version": "1.0.0",
    "name": "Tools_upload",
    "group": "Tools",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "x:user_id",
            "description": "<p>用户ID</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": false,
            "field": "x:random",
            "description": "<p>附件随机数</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "x:target_id",
            "description": "<p>目标ID</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": false,
            "field": "x:type",
            "description": "<p>17.门店正面照片；18.门店内部照片；19.营业执照；20.身份证人像面；21.身份证国徽面</p>"
          }
        ]
      }
    },
    "filename": "app/Http/Controllers/Api/DealerV1/ToolsController.php",
    "groupTitle": "Tools",
    "sampleRequest": [
      {
        "url": "http://www.taihuoniao.devhttp://upload.qiniu.com"
      }
    ]
  }
] });
