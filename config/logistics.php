<?php

return [

    'logistics' => [
        '圆通快递' => ['jd' => 463, 'tb' => '', 'zy' => 'y', 'kdn' => 'YTO'],
        '申通快递' => ['jd' => 470, 'tb' => '', 'zy' => 's', 'kdn' => 'STO'],
        '顺丰快递' => ['jd' => 467, 'tb' => '', 'zy' => 'f', 'kdn' => 'SF'],
        '天天快递' => ['jd' => 2009, 'tb' => '', 'zy' => 't', 'kdn' => 'HHTT'],
        '中通速递' => ['jd' => 1499, 'tb' => '', 'zy' => 'z', 'kdn' => 'ZTO'],
        '邮政EMS' => ['jd' => 465, 'tb' => '', 'zy' => 'e', 'kdn' => 'EMS'],
        '韵达快递' => ['jd' => 1327, 'tb' => '', 'zy' => 'm', 'kdn' => 'YD'],
        '优速快递' => ['jd' => 1747, 'tb' => '', 'zy' => 'u', 'kdn' => 'UC'],
        '全峰快递' => ['jd' => 2016, 'tb' => '', 'zy' => 'q', 'kdn' => 'QFKD'],
        '宅急送' => ['jd' => 1409, 'tb' => '', 'zy' => 'j', 'kdn' => 'ZJS'],
        '百世快递' => ['jd' => 1748, 'tb' => '', 'zy' => 'b', 'kdn' => 'BTWL'],
        '国通快递' => ['jd' => 2465, 'tb' => '', 'zy' => 'g', 'kdn' => 'GTO'],
        '德邦物流' => ['jd' => 2130, 'tb' => '', 'zy' => 'd', 'kdn' => 'DBL'],
        '快捷快递' => ['jd' => 2094, 'tb' => '', 'zy' => 'k', 'kdn' => 'FAST'],
        '品牌代发' => ['jd' => '', 'tb' => '', 'zy' => '', 'kdn' => 'QT'],
        '全一快递' => ['jd' => '2100', 'tb' => '', 'zy' => 'qy', 'kdn' => 'UAPEX'],
    ],

    // 物流匹配配置
    "matching" => [
        'YTO' => ['圆通','YTO'],
        'STO' => ['申通', 'STO'],
        'SF' => ['顺丰', 'SF'],
        'HHTT' => ['天天','HHTT'],
        'ZTO' => ['中通','ZTO'],
        'EMS' => ['邮政', 'EMS'],
        'YD' => ['韵达', 'YD'],
        'UC' => ['优速', 'UC'],
        'QFKD' => ['全峰', 'QFKD'],
        'ZJS' => ['宅急送', 'ZJS'],
        'BTWL' => ['百世', 'BTWL'],
        'GTO' => ['国通', 'GTO'],
        'DBL' => ['德邦', 'DBL'],
        'FAST' => ['快捷', 'FAST'],
        'UAPEX' => ['全一', 'UAPEX'],
    ]

    //自营快递代码
    /*array(
        'id' => 's',
        'title' => '申通快递',
    ),
    array(
        'id' => 'y',
        'title' => '圆通快递',
    ),
    array(
        'id' => 'f',
        'title' => '顺丰速运',
    ),
    array(
        'id' => 'z',
        'title' => '中通快递',
    ),
    array(
        'id' => 'u',
        'title' => '优速快递',
    ),
    array(
        'id' => 'm',
        'title' => '韵达快递',
    ),
    array(
        'id' => 't',
        'title' => '天天快递',
    ),
    array(
        'id' => 'j',
        'title' => '宅急送',
    ),
    array(
        'id' => 'b',
        'title' => '百世汇通',
    ),
    array(
        'id' => 'g',
        'title' => '国通快递',
    ),
    array(
        'id' => 'e',
        'title' => 'EMS',
    ),
    array(
        'id' => 'd',
        'title' => '德邦物流',
    ),
    array(
        'id' => 'q',
        'title' => '全峰快递',
    ),
    array(
        'id' => 'k',
        'title' => '快捷快递',
    ),*/

    //京东平台物流代码
    /*'jd_logistics' => [
        [
            "id" => 568096,
            "name" => "万家康",
            "description" => "万家康",
        ],
        [
            "id" => 500043,
            "name" => "卡行天下",
            "description" => "卡行天下",
        ],
        [
            "id" => 323141,
            "name" => "亚风快运",
            "description" => "亚风快运",
        ],
        [
            "id" => 332098,
            "name" => "海关自提",
            "description" => "海关自提",
        ],
        [
            "id" => 336878,
            "name" => "京东大件开放承运商",
            "description" => "京东大件开放承运商",
        ],
        [
            "id" => 328977,
            "name" => "上药物流",
            "description" => "上药物流",
        ],
        [
            "id" => 313214,
            "name" => "如风达",
            "description" => "如风达",
        ],
        [
            "id" => 222693,
            "name" => "贝业新兄弟",
            "description" => "贝业新兄弟",
        ],
        [
            "id" => 171686,
            "name" => "易宅配物流",
            "description" => "易宅配物流",
        ],
        [
            "id" => 171683,
            "name" => "一智通物流",
            "description" => "一智通物流",
        ],
        [
            "id" => 6012,
            "name" => "斑马物联网",
            "description" => "斑马物联网",
        ],
        [
            "id" => 5419,
            "name" => "中铁物流",
            "description" => "中铁物流",
        ],
        [
            "id" => 4832,
            "name" => "安能物流",
            "description" => "安能物流",
        ],
        [
            "id" => 4605,
            "name" => "微特派",
            "description" => "微特派",
        ],
        [
            "id" => 3046,
            "name" => "德邦快递",
            "description" => "德邦快运",
        ],
        [
            "id" => 2909,
            "name" => "快行线物流",
            "description" => "快行线物流",
        ],
        [
            "id" => 2462,
            "name" => "天地华宇",
            "description" => "天地华宇",
        ],
        [
            "id" => 2460,
            "name" => "佳吉快运",
            "description" => "佳吉快运",
        ],
        [
            "id" => 2461,
            "name" => "新邦物流",
            "description" => "新邦物流",
        ],
        [
            "id" => 2465,
            "name" => "国通快递",
            "description" => "国通快递",
        ],
        [
            "id" => 2087,
            "name" => "京东快递",
            "description" => "京东快递",
        ],
        [
            "id" => 2171,
            "name" => "中国邮政挂号信",
            "description" => "中国邮政挂号信",
        ],
        [
            "id" => 2170,
            "name" => "邮政快递包裹",
            "description" => "邮政快递包裹",
        ],
        [
            "id" => 2105,
            "name" => "速尔快递",
            "description" => "速尔快递",
        ],
        [
            "id" => 2101,
            "name" => "嘉里大通物流",
            "description" => "嘉里大通物流",
        ],
        [
            "id" => 2100,
            "name" => "全一快递",
            "description" => "全一快递",
        ],
        [
            "id" => 2096,
            "name" => "联邦快递",
            "description" => "联邦快递",
        ],
        [
            "id" => 2094,
            "name" => "快捷速递",
            "description" => "快捷速递",
        ],
        [
            "id" => 471,
            "name" => "龙邦快递",
            "description" => "龙邦快递",
        ],
        [
            "id" => 2130,
            "name" => "德邦物流",
            "description" => "德邦物流",
        ],
        [
            "id" => 2016,
            "name" => "全峰快递",
            "description" => "全峰快递",
        ],
        [
            "id" => 2009,
            "name" => "天天快递",
            "description" => "天天快递",
        ],
        [
            "id" => 1748,
            "name" => "百世快递",
            "description" => "百世快递",
        ],
        [
            "id" => 1747,
            "name" => "优速速运",
            "description" => "优速速运",
        ],
        [
            "id" => 1549,
            "name" => "宅急便",
            "description" => "宅急便",
        ],
        [
            "id" => 1499,
            "name" => "中通速递",
            "description" => "中通速递",
        ],
        [
            "id" => 1409,
            "name" => "宅急送",
            "description" => "宅急送",
        ],
        [
            "id" => 1327,
            "name" => "韵达快递",
            "description" => "韵达快递",
        ],
        [
            "id" => 1274,
            "name" => "厂家自送",
            "description" => "厂家自送",
        ],
        [
            "id" => 470,
            "name" => "申通快递",
            "description" => "申通快递",
        ],
        [
            "id" => 467,
            "name" => "顺丰快递",
            "description" => "顺丰快递",
        ],
        [
            "id" => 465,
            "name" => "邮政EMS",
            "description" => "邮政EMS",
        ],
        [
            "id" => 463,
            "name" => "圆通快递",
            "description" => "圆通快递",
        ],
    ]*/
];