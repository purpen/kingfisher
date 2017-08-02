<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Http\ApiHelper;
use Illuminate\Http\Request;

class PosterController extends BaseController
{
    /**
     * @api {get} /saasApi/posters 海报列表
     * @apiVersion 1.0.0
     * @apiName Poster lists
     * @apiGroup Poster
     *
     * @apiParam {integer} type 状态
     * @apiParam {string} token token
     *
     * @apiSuccessExample 成功响应:
    {
        "meta": {
            "message": "Success",
            "status_code": 200
        },
        "data": {
            "id": 1,
            "type": "2",
            "background_color": "#FFFFFF",
            "size": {
                "width": 750,
                "height": 1334
            },
            "image": [
                {
                    "height": 1334,
                    "zindex": 11,
                    "width": 750,
                    "type": 97,
                    "name": "photo",
                    "imageUrl": "",
                    "position": {
                        "right": 0,
                        "top": 0,
                        "left": 0,
                        "bottom": 0
                    }
                },
                {
                    "height": 150,
                    "zindex": 9,
                    "width": 150,
                    "type": 99,
                    "name": "qr",
                    "imageUrl": "",
                    "position": {
                        "right": -210,
                        "top": 1084,
                        "left": 390,
                        "bottom": 100
                    }
                },
                {
                    "height": 150,
                    "zindex": 10,
                    "width": 150,
                    "type": 98,
                    "name": "logo",
                    "imageUrl": "",
                        "position": {
                        "right": -390,
                        "top": 1084,
                        "left": 210,
                        "bottom": -100
                        }
                }
            ],
            "text": [
            {
                "fontSize": 72,
                "color": "#FFFFFF",
                "content": "2017 HOOEASY",
                "height": 100,
                "weight": 4,
                "width": 610,
                "zindex": 1,
                "align": 1,
                "textStyle": "normal",
                "line-height": 10,
                "background": "#",
                "position": {
                    "right": -70,
                    "top": 117,
                    "left": 70,
                    "bottom": -1117
                }
            },
            {
                "fontSize": 58,
                "color": "#FFFFFF",
                "content": "NEW PEODUCT",
                "height": 81,
                "weight": 4,
                "width": 610,
                "zindex": 2,
                "align": 1,
                "textStyle": "normal",
                "line-height": 10,
                "background": "#",
                "position": {
                    "right": -70,
                    "top": 196,
                    "left": 70,
                    "bottom": -1057
                }
            },
            {
                "fontSize": 48,
                "color": "#FFFFFF",
                "content": "LAUNCH德智衣护无界",
                "height": 67,
                "weight": 0,
                "width": 610,
                "zindex": 3,
                "align": 1,
                "textStyle": "normal",
                "line-height": 10,
                "background": "#",
                "position": {
                    "right": -70,
                    "top": 264,
                    "left": 70,
                    "bottom": -1003
                }
            },
            {
                "fontSize": 74,
                "color": "#FFFFFF",
                "content": "好易点新品发布会",
                "height": 67,
                "weight": 0,
                "width": 610,
                "zindex": 5,
                "align": 1,
                "textStyle": "normal",
                "line-height": 10,
                "background": "#",
                "position": {
                    "right": -70,
                    "top": 803,
                    "left": 70,
                    "bottom": -464
                }
            },
            {
                "fontSize": 40,
                "color": "#FFFFFF",
                "content": "诚邀莅临",
                "height": 100,
                "weight": 4,
                "width": 610,
                "zindex": 1,
                "align": 1,
                "textStyle": "normal",
                "line-height": 10,
                "background": "#",
                    "position": {
                        "right": -70,
                        "top": 117,
                        "left": 70,
                        "bottom": -1117
                    }
                }
            ]
        }
    }
     */
    public function lists(Request $request)
    {
        $all['id'] = 1;
        $all['type'] = $request->input('type') ?  $request->input('type')  : '';
        $all['background_color'] = "#FFFFFF";
        $all['size'] = ['width' => 750 , 'height' => 1334];
        $all['image'] = [
            ['height' => 1334 , 'zindex' => 11 , 'width' => 750 , 'type' => 97 , 'name' => 'photo' , 'imageUrl' => '',
               'position' => [ 'right' => 0 , 'top' => 0 , 'left' => 0 , 'bottom' => 0]
            ],
            ['height' => 150 , 'zindex' => 9 , 'width' => 150 , 'type' => 99 , 'name' => 'qr' , 'imageUrl' => '',
                'position' => [ 'right' => -210 , 'top' => 1084 , 'left' => 390 , 'bottom' => 100]
            ],
            ['height' => 150 , 'zindex' => 10 , 'width' => 150 , 'type' => 98 , 'name' => 'logo' , 'imageUrl' => '',
                'position' => [ 'right' => -390 , 'top' => 1084 , 'left' => 210 , 'bottom' => -100]
            ]
        ];
        $all['text'] = [
            ['fontSize' => 72 , 'color' => "#FFFFFF" , 'content' => "2017 HOOEASY" , 'height' => 100 , 'weight' => 4 , 'textStyle' =>"normal" , 'line-height' => 10 ,'width' => 610, 'zindex' => 1 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 117 , 'left' => 70 , 'bottom' => -1117]
            ],
            ['fontSize' => 58 , 'color' => "#FFFFFF" , 'content' => "NEW PEODUCT" , 'height' => 81 , 'weight' => 4 , 'textStyle' =>"italic", 'line-height' => 10 , 'width' => 610, 'zindex' => 2 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 196 , 'left' => 70 , 'bottom' => -1057]
            ],
            ['fontSize' => 48 , 'color' => "#FFFFFF" , 'content' => "LAUNCH德智衣护无界" , 'height' => 67 , 'weight' => 0 , 'textStyle' =>"bold", 'line-height' => 10 , 'width' => 610, 'zindex' => 3 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 264 , 'left' => 70 , 'bottom' => -1003]
            ],
            ['fontSize' => 74 , 'color' => "#FFFFFF" , 'content' => "好易点新品发布会" , 'height' => 67 , 'weight' => 0, 'textStyle' =>"italic" , 'line-height' => 10 , 'width' => 610, 'zindex' => 5 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 803 , 'left' => 70 , 'bottom' => -464]
            ],
            ['fontSize' => 40 , 'color' => "#FFFFFF" , 'content' => "诚邀莅临" , 'height' => 100 , 'weight' => 4 , 'textStyle' =>"bold", 'line-height' => 10 , 'width' => 610, 'zindex' => 1 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 117 , 'left' => 70 , 'bottom' => -1117]
            ]
        ];

        $data = [];
        for($i = 1; $i < 6 ; $i ++){
            $all['id'] = $i;
            $new_all =  $all;
            $data[] = $new_all;
        }
        return $this->response->array(ApiHelper::success('Success', 200, $data));


    }

    /**
     * @api {get} /saasApi/poster 海报详情
     * @apiVersion 1.0.0
     * @apiName Poster Poster
     * @apiGroup Poster
     *
     * @apiParam {string} token token
     * @apiSuccessExample 成功响应:
    {
        "meta": {
            "message": "Success",
            "status_code": 200
        },
        "data": {
            "id": 1,
            "type": "2",
            "background_color": "#FFFFFF",
            "size": {
                "width": 750,
                "height": 1334
            },
            "image": [
                {
                    "height": 1334,
                    "zindex": 11,
                    "width": 750,
                    "type": 97,
                    "name": "photo",
                    "imageUrl": "",
                    "position": {
                        "right": 0,
                        "top": 0,
                        "left": 0,
                        "bottom": 0
                    }
                },
                {
                    "height": 150,
                    "zindex": 9,
                    "width": 150,
                    "type": 99,
                    "name": "qr",
                    "imageUrl": "",
                    "position": {
                        "right": -210,
                        "top": 1084,
                        "left": 390,
                        "bottom": 100
                    }
                },
                {
                    "height": 150,
                    "zindex": 10,
                    "width": 150,
                    "type": 98,
                    "name": "logo",
                    "imageUrl": "",
                    "position": {
                        "right": -390,
                        "top": 1084,
                        "left": 210,
                        "bottom": -100
                    }
                }
            ],
            "text": [
                {
                    "fontSize": 72,
                    "color": "#FFFFFF",
                    "content": "2017 HOOEASY",
                    "height": 100,
                    "weight": 4,
                    "width": 610,
                    "zindex": 1,
                    "align": 1,
                    "background": "#",
                    "textStyle": "normal",
                    "line-height": 10,
                    "position": {
                        "right": -70,
                        "top": 117,
                        "left": 70,
                        "bottom": -1117
                    }
                },
                {
                    "fontSize": 58,
                    "color": "#FFFFFF",
                    "content": "NEW PEODUCT",
                    "height": 81,
                    "weight": 4,
                    "width": 610,
                    "zindex": 2,
                    "align": 1,
                    "textStyle": "normal",
                    "line-height": 10,
                    "background": "#",
                    "position": {
                        "right": -70,
                        "top": 196,
                        "left": 70,
                        "bottom": -1057
                    }
                }
            ]
        }
    }
     */
    public function poster()
    {
        $all['id'] = 1;
        $all['background_color'] = "#FFFFFF";
        $all['size'] = ['width' => 750 , 'height' => 1334];
        $all['image'] = [
            ['height' => 1334 , 'zindex' => 11 , 'width' => 750 , 'type' => 97 , 'name' => 'photo' , 'imageUrl' => '',
                'position' => [ 'right' => 0 , 'top' => 0 , 'left' => 0 , 'bottom' => 0]
            ],
            ['height' => 150 , 'zindex' => 9 , 'width' => 150 , 'type' => 99 , 'name' => 'qr' , 'imageUrl' => '',
                'position' => [ 'right' => -210 , 'top' => 1084 , 'left' => 390 , 'bottom' => 100]
            ],
            ['height' => 150 , 'zindex' => 10 , 'width' => 150 , 'type' => 98 , 'name' => 'logo' , 'imageUrl' => '',
                'position' => [ 'right' => -390 , 'top' => 1084 , 'left' => 210 , 'bottom' => -100]
            ]
        ];
        $all['text'] = [
            ['fontSize' => 72 , 'color' => "#FFFFFF" , 'content' => "2017 HOOEASY" , 'height' => 100 , 'weight' => 4 , 'textStyle' =>"normal" , 'line-height' => 10 ,'width' => 610, 'zindex' => 1 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 117 , 'left' => 70 , 'bottom' => -1117]
            ],
            ['fontSize' => 58 , 'color' => "#FFFFFF" , 'content' => "NEW PEODUCT" , 'height' => 81 , 'weight' => 4 , 'textStyle' =>"italic", 'line-height' => 10 , 'width' => 610, 'zindex' => 2 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 196 , 'left' => 70 , 'bottom' => -1057]
            ],
            ['fontSize' => 48 , 'color' => "#FFFFFF" , 'content' => "LAUNCH德智衣护无界" , 'height' => 67 , 'weight' => 0 , 'textStyle' =>"bold", 'line-height' => 10 , 'width' => 610, 'zindex' => 3 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 264 , 'left' => 70 , 'bottom' => -1003]
            ],
            ['fontSize' => 74 , 'color' => "#FFFFFF" , 'content' => "好易点新品发布会" , 'height' => 67 , 'weight' => 0, 'textStyle' =>"italic" , 'line-height' => 10 , 'width' => 610, 'zindex' => 5 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 803 , 'left' => 70 , 'bottom' => -464]
            ],
            ['fontSize' => 40 , 'color' => "#FFFFFF" , 'content' => "诚邀莅临" , 'height' => 100 , 'weight' => 4 , 'textStyle' =>"bold", 'line-height' => 10 , 'width' => 610, 'zindex' => 1 , 'align' => 1, 'background' => "#",
                'position' => [ 'right' => -70 , 'top' => 117 , 'left' => 70 , 'bottom' => -1117]
            ]
        ];

        return $this->response->array(ApiHelper::success('Success', 200, $all));

    }
}