<?php
namespace App\Http\Controllers\Api\DealerV1;


use App\Http\ApiHelper;
use App\Libraries\Alipay\AopSdk;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradePagePayContentBuilder;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradeQueryContentBuilder;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradeRefundContentBuilder;
use App\Libraries\Alipay\pagepay\service\AlipayTradeService;
use App\Models\OrderModel;
use App\Models\ProductsSkuModel;
use Illuminate\Http\Request;

class PayController extends BaseController
{
//
//    protected $config = [
//        'app_id' => "2018091761417220",
//        'notify_url' => "http://192.168.33.122/alipay2/notify_url.php",
//        'return_url' => "http://192.168.33.122/alipay2/return_url.php",
//        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkv38C0QphhzPV5BksZfwFkrxot8JmGp8n3LOdOhUxbxmer9rqAT0gVba2cUhmvNdB93EL/OA+Pb12MvckOsu9N0V4qWD99bFCO5CWoDMrKyaEPICS6Etaj8trVdTZrEJxzmAYNRojAx8Lyc+Nt+8Ndjh8hFQ3hFJuIUDxarHt7MUSgvSOh6oEshsBOJLOs78PSOVmRr6HzFdReBDoMveXkPxC2Nt0s/+wQUi2CuEyvGTrH9MZNGWWU05ycdFCCuotyoyWChkkDMqmMhOPW947gcCt6CvHXehClfOJO9SfZs05Srucl9oJ1hKc4oHUqGciUc5TFiZ9lempQTebegdKwIDAQAB",
//        'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCLqatB7bFRI4BF2YjTDbllzWfuZw4XH6ZL/J5lM4gDvQgdCbx635RrQdX7BpRvGm/ymfWMGxBq+nqWIvlnXA+P4ZH0SLoaXshjRrY5Tf+4pduuEL+uhmqPTizPRJAxwQ4LJBmzOGqMYE3W/VLxdMIcC44L3NbCUeENQPrfhU1ok51qwMeiTvaAvG38xn9nKilJqzepGkiNoMddPZAcc6HUzIarsO1/ep8obSHMQJFR/AFOFg2/q8aIOFBpdMdBDfOE63RC0APrecuydCYOLRktew2c0MyZ7zx0Xjcs9FPKhRsvgq+OinPDUWC6iUelfI3Tfz1BqeJe23Dnk/Men6hXAgMBAAECggEAfZzcqy9di9yiQjClHy340dcs4v9NbP7KUw2iaOMwMiySX4uiOeFdXBqammwQlNzyUwCmGJ0+5vjhyKcsKgpi9MWswEmpGI6nLKMswd2lYi3Kp4Po4s+Ch+GH6+N+zUEVoG+XrdnP+vGjEPpG32RkMVUzLPgzMBL0lzcabG84cBT+QmBLZDHv3Vs/eVPircRaZDpeH9pdwGlSgQyvS0zUVYPPzwFVqHoIOZKGKfLB2Z9lbIA+Luzm8yhpaBUYFvzE7JTZfU55QZVaLIXuxIInXm50MZpWFi3p3XGvGXUEAGVikrImIVnzSJKsrEtzxCvxpJMTRRXcxoA6EbZjVpO4AQKBgQDR6ML8elQbTHeUKY1Jjiqm7excndYRljdarpvhwyHJl/+ZtzfKHbAWqt5//O2lMOPt9vQ/lUw7grhYnLIHkeBemaYsJqEGbSnKysZiVqGjaOxG3UeS83ZL/FHXi0Te3NU+N5fX07z95UsIJOrgJff6zBq/uX2irxaHA3gegfHPUQKBgQCqVEYAyF+rDQdL+g26JhnhPng+cHnfA+Ok7Hsc31AKHvQ70EOcY/JZA2rGyy9ucCr7GzUTunJZZ9SfDzMLGP1fpjmUv3Mhju01JzEe15NUjJfePEbCeSXUWIT0A164hLd+fzF5sehVMjhs4UH7lQ+ZEn2KxN3+zI0KnL2maiEjJwKBgQCeV6QGysx5T0SA+ps+2kRoad+7ucCKwbL97+tc8VKifMtuDBzElYKIhtqS15v42ZmGn5x9/kRkO+aNyZ4uQadsFSGZ+oXLkDtPY4klE06ZMwPRLQjZ3FfnV+3w13jbWOBvL4aWY34UVIw2F4sqDNo0URT4fZc9SjCHJmHNOZ7MEQKBgAMOcBMjhVP0b+UVH5nvhRddn5q/OfCeiT80XyEtgKot1AQewJfV00t1nDzk+Hzq1lqbKmCoP9UK3+3av/e7AxDsUqwwo0g+4FLL2T3McIBb5X2/ZyWmNt+QlxIp3VFCUGicr66XWqvsssaBZEW3bwg4JLiQv8sKsJ04Is8RqHaRAoGAArkb9YLnMEfooayMloWkc/5BQ1/JZeI+2M4NA2TcuIK/R/BFYUdpLccrkKqtO+6DNPPW8Lgy+BCZnPoqvwneIq1Ki+X7NLIIb4xqX4wk9M/KMrTnN9z0HHAxvbReo3+HqvlX0K+DX24bD+NzNjDs5szvegnXvbozwsX9Z5Ywz5E=",
//    ];


    public function __construct(Request $request)
    {
        parent::__construct($request);
            $this->aopSdkObj=new AopSdk();
            $this->aopSdkObj->run();
    }

    /**
     * @api {get} /DealerApi/pay 上传支付信息获取返回页面
     * @apiVersion 1.0.0
     * @apiName Pay pay
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id 订单ID
     * @apiParam {string} token token
     * @apiParam {string} number 订单号
     * @apiParam {string} pay_money 支付金额
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function pay(Request $request)
    {

        $out_trade_no = $request->input('order_id');
        $number = $request->input('number');
        $total_amount = $request->input('pay_money');
        if (!$out_trade_no && !$number && !$total_amount) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }

        //构造参数
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setNumber($number);
        $payRequestBuilder->setTotalAmount($total_amount);

        /**
         * return_url 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */

        $aop = new AlipayTradeService($alipay_config);
        $response = $aop->pagePay($payRequestBuilder, config('alipay.return_url'),config('alipay.notify_url'));

        //输出表单
        return $this->response->array(ApiHelper::success('Success', 200, $response));
    }


    /**
     * make_sure 验证签名
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @param $return_url 同步跳转地址，公网可以访问
     * @param $notify_url 异步通知地址，公网可以访问
     * @return $response 支付宝返回的信息
     */

    /**
     * @api {post} /DealerApi/Pay/make_sure 验证签名 异步通知回调
     * @apiVersion 1.0.0
     * @apiName Pay make_sure
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id 订单ID
     * @apiParam {string} number 订单号
     * @apiParam {string} pay_money 支付金额
     * @apiParam {string} trade_status 交易状态： TRADE_FINISHED TRADE_SUCCESS
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function make_sure(Request $request)
    {
        $user_id = $this->auth_user_id;
        $arr = $request->all();
//        $arr=$_POST;

        if (!$arr['order_id'] && !$arr['number'] && !$arr['pay_money'] && !$arr['trade_status']) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        $order = OrderModel::where('user_id', $user_id)->where('id', $arr['order_id'])->first();
        if (!$order) {
            return $this->response->array(ApiHelper::error('没有找到该笔订单', 403));
        }

        $alipaySevice = new AlipayTradeService($alipay_config);
        $alipaySevice->writeLog(var_export($request->all(), true));
        $result = $alipaySevice->check($arr);

        if ($result) {
//            获取相关数据
            $out_trade_no = $arr['order_id'];
            $number = $arr['number'];
            $total_amount = $arr['pay_money'];
            $trade_status = $arr['trade_status'];       //交易状态
//            判断数据是否做过处理，如果做过处理，return，没有做过处理，执行支付成功代码
            if ($trade_status == 'TRADE_FINISHED' OR $trade_status == 'TRADE_SUCCESS') {
                $money = $order->total_money;
                if ($arr['pay_money'] != $money) {
                    return $this->response->array(ApiHelper::error('支付金额有误', 403));
                }
                $status = $order->status;
                if ($status != 1){
                    return $this->response->array(ApiHelper::error('该订单不是待支付订单', 403));
                }
//                修改订单状态
                $orders = OrderModel::
                where('user_id', '=', $this->auth_user_id)
                    ->where('id', '=', $arr['order_id'])
                    ->update(['status' => 5]);
                if (!$orders){
                    return $this->response->array(ApiHelper::error('订单状态更新失败！', 500));
                }

                // 创建订单收款单
//                $model = new ReceiveOrderModel();
//                if (!$model->orderCreateReceiveOrder($orders->id)) {
//                    Log::error('ID:'. $orders->id .'订单发货创建订单收款单错误');
//                }

                echo "success";
            } else {
                echo "fail";
            }
        } else {
            //验证失败
                echo "fail";
        }
    }

    /**
     * @api {get} /DealerApi/Pay/alipayReturn 验证签名 同步通知回调
     * @apiVersion 1.0.0
     * @apiName Pay alipayReturn
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id 订单ID
     * @apiParam {string} number 订单号
     * @apiParam {string} pay_money 支付金额
     * @apiParam {string} trade_no 支付宝交易号
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */

    public function alipayReturn(Request $request)
    {
        $user_id = $this->auth_user_id;
        $arr = $request->all();
//        $arr=$_GET;

        if (!$arr['order_id'] && !$arr['number'] && !$arr['pay_money'] && !$arr['trade_no']) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        $order = OrderModel::where('user_id', $user_id)->where('id', $arr['order_id'])->first();
        if (!$order) {
            return $this->response->array(ApiHelper::error('没有找到该笔订单', 403));
        }
        $money = $order->total_money;
        if ($arr['pay_money'] != $money) {
            return $this->response->array(ApiHelper::error('支付金额有误', 403));
        }
        $alipaySevice = new AlipayTradeService($alipay_config);
        $result = $alipaySevice->check($arr);

        if ($result){
            $out_trade_no = htmlspecialchars($arr['order_id']);
            $number = htmlspecialchars($arr['number']);
            $trade_no = htmlspecialchars($arr['trade_no']);

            return $this->response->array(ApiHelper::success('Success', 200,'支付宝交易号:'.$trade_no));

        }else {
            //验证失败
            echo "验证失败";
        }

    }


    /**
     * @api {get} /DealerApi/Pay/search 查询订单
     * @apiVersion 1.0.0
     * @apiName Pay search
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id 订单ID
     * @apiParam {string} token token
     * @apiParam {string} trade_no 支付宝交易号
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */

    public function search(Request $request)
    {
        $out_trade_no = $request->input('order_id');
        $trade_no = $request->input('trade_no');
        if (!$out_trade_no && !$trade_no) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        //请二选一设置
        //构造参数
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
//        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);

        $aop = new AlipayTradeService($alipay_config);

        /**
         * Alipay.trade.query (统一收单线下交易查询)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Query($RequestBuilder);

        return $this->response->array(ApiHelper::success('Success', 200, $response));
    }


    /**
     * @api {get} /DealerApi/Pay/refund 订单退款
     * @apiVersion 1.0.0
     * @apiName Pay refund
     * @apiGroup Pay
     *
     * @apiParam {integer} order_id 订单ID
     * @apiParam {string} token token
     * @apiParam {string} token token
     * @apiParam {string} refund_amount 需要退款的金额
     * @apiParam {string} refund_reason 退款原因说明
     * @apiParam {string} trade_no 支付宝交易号
     *
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "Success",
     *       "status_code": 200
     *     }
     *   }
     */
    public function refund(Request $request)
    {
        $out_trade_no = $request->input('order_id');
        $trade_no = $request->input('trade_no');
        //需要退款的金额，该金额不能大于订单金额，必填
        $refund_amount = $request->input('refund_amount');
        $refund_reason = $request->input('refund_reason');

        if (!$out_trade_no && !$trade_no && !$refund_amount && !$refund_reason) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        //构造参数
        $RequestBuilder=new AlipayTradeRefundContentBuilder();
        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);
        $RequestBuilder->setRefundAmount($refund_amount);
        $RequestBuilder->setRefundReason($refund_reason);

        $aop = new AlipayTradeService($alipay_config);

        /**
         * Alipay.trade.refund (统一收单交易退款接口)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Refund($RequestBuilder);

        return $this->response->array(ApiHelper::success('Success', 200, $response));

    }


}