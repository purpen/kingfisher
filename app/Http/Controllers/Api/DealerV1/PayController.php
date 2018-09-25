<?php
namespace App\Http\Controllers\Api\DealerV1;


use App\Http\ApiHelper;
use App\Libraries\Alipay\AopSdk;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradePagePayContentBuilder;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradeQueryContentBuilder;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradeRefundContentBuilder;
//use App\Libraries\Alipay\pagepay\service\AlipayTradeService;
use App\Models\OrderModel;
use Illuminate\Http\Request;

//require_once (__DIR__.'../../../../Libraries/Alipay/config.php');
//require_once (__DIR__.'../../../../Libraries/Alipay/pagepay/service/AlipayTradeService.php');
//require_once (__DIR__.'../../../../Libraries/Alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');

class PayController extends BaseController
{
//    public function __construct(Request $request)
//    {
//        parent::__construct($request);
//            $this->aopSdkObj=new AopSdk();
//            $this->aopSdkObj->run();
//    }

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
//var_dump(__DIR__.'/Api/Controllers/Http/../Libraries/Alipay/config.php');die;
var_dump(dirname(dirname(dirname ( __FILE__ ))).'/AopSdk.php');die;
//        $out_trade_no = $request->input('order_id');
        $out_trade_no = 26;
//        $number = $request->input('number');
        $number='DD2018091900005';
//        $total_amount = $request->input('pay_money');
        $total_amount =300;
        $user_id = $this->auth_user_id;
        if (!$out_trade_no && !$number && !$total_amount) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        $order = OrderModel::where('user_id', $user_id)->where('id',$out_trade_no)->first();
        if (!$order) {
            return $this->response->array(ApiHelper::error('没有找到该笔订单', 403));
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

        $aop = new \AlipayTradeService($config);
        $response = $aop->pagePay($payRequestBuilder, config('alipay.return_url'),config('alipay.notify_url'));

        //输出表单
        return $this->response->array(ApiHelper::success('Success', 200, $response));
    }


    /**
     * make_sure 验证签名 异步通知回调
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @param $return_url 同步跳转地址，公网可以访问
     * @param $notify_url 异步通知地址，公网可以访问
     * @return $response 支付宝返回的信息
     */
    public function make_sure(Request $request)
    {
        $arr=$_POST;

        $alipaySevice = new \AlipayTradeService($config);
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
        $alipaySevice = new \AlipayTradeService($config);
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

        $aop = new \AlipayTradeService($config);

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

        $aop = new \AlipayTradeService($config);

        /**
         * Alipay.trade.refund (统一收单交易退款接口)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Refund($RequestBuilder);

        return $this->response->array(ApiHelper::success('Success', 200, $response));

    }


}