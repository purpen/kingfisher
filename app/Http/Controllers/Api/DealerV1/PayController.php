<?php
namespace App\Http\Controllers\Api\DealerV1;

use App\Http\ApiHelper;
use App\Libraries\Alipay\AopSdk;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradePagePayContentBuilder;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradeQueryContentBuilder;
use App\Libraries\Alipay\pagepay\buildermodel\AlipayTradeRefundContentBuilder;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

//require_once(app_path().'/Libraries/Alipay/config.php');
//require_once(app_path().'/Libraries/Alipay/pagepay/service/AlipayTradeService.php');
//require_once(app_path().'/Libraries/Alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');
class PayController extends BaseController
{
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
        $subject = '商品明细';//作为订单名称
        $out_trade_no = $request->input('number');//订单号
        $pay_money = $request->input('pay_money');
        $user_id = $this->auth_user_id;
        if (!$out_trade_no && !$subject && !$pay_money) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        $order = OrderModel::where('user_id', $user_id)->where('number',$out_trade_no)->first();
        if (!$order) {
            return $this->response->array(ApiHelper::error('没有找到该笔订单', 403));
        }
        $total_amount = $order->pay_money?$order->pay_money:$order->total_money;

        //构造参数
        $payRequestBuilder = new AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTotalAmount($total_amount);

        /**
         * return_url 电脑网站支付请求
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @param $return_url 同步跳转地址，公网可以访问
         * @param $notify_url 异步通知地址，公网可以访问
         * @return $response 支付宝返回的信息
         */

        $aop = new \AlipayTradeService(config('alipay.app_id','alipay.merchant_private_key','alipay.notify_url','alipay.return_url','alipay.charset','alipay.sign_type','alipay.gatewayUrl','alipay.alipay_public_key'));
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
        $alipaySevice = new \AlipayTradeService(config('alipay.app_id','alipay.merchant_private_key','alipay.notify_url','alipay.return_url','alipay.charset','alipay.sign_type','alipay.gatewayUrl','alipay.alipay_public_key'));

        $alipaySevice->writeLog(var_export($request->all(), true));
        $result = $alipaySevice->check($arr);

        if ($result) {
            //获取相关数据
            $out_trade_no = $arr['out_trade_no'];//订单号
            $total_amount = $arr['buyer_pay_amount'];//付款金额
            $trade_status = $arr['trade_status'];//交易状态
            $notify_time = $arr['gmt_payment'];//交易付款时间
        $order = OrderModel::where('number',$out_trade_no)->first();
        if (!$order) {
            Log::info('没有找到该笔订单，订单号：'.$out_trade_no);
            echo "fail";
            return;
        }

//            判断数据是否做过处理，如果做过处理，return，没有做过处理，执行支付成功代码
            if ($trade_status == 'TRADE_FINISHED' OR $trade_status == 'TRADE_SUCCESS') {
                $money = $order->total_money;
                if ($total_amount != $money) {
                    Log::info('支付金额有误，订单号：'.$out_trade_no.','.'交易金额:'.$total_amount);
                    echo "fail";
                    return;
                }
                $status = $order->status;
                if ($status != 1){
                    Log::info('该订单不是待支付订单，订单号：'.$out_trade_no.','.'交易状态:'.$trade_status);
                    echo "fail";
                    return;
                }
//                修改订单状态
                $orders = OrderModel::
                where('user_id', '=', $this->auth_user_id)
                    ->where('number', '=', $out_trade_no)
                    ->update(['status' => 5,'payment_time' => $notify_time,'payment_type'=>1]);
                if (!$orders){
                    Log::info('订单状态更新失败！，订单号：'.$out_trade_no);
                    echo "fail";
                    return;
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
     * alipayReturn 验证签名 同步通知回调
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @param $return_url 同步跳转地址，公网可以访问
     * @param $notify_url 异步通知地址，公网可以访问
     * @return $response 支付宝返回的信息
     */

    public function alipayReturn(Request $request)
    {
        $arr=$_GET;

        $alipaySevice = new \AlipayTradeService(config('alipay.app_id','alipay.merchant_private_key','alipay.notify_url','alipay.return_url','alipay.charset','alipay.sign_type','alipay.gatewayUrl','alipay.alipay_public_key'));
        $result = $alipaySevice->check($arr);

        if ($result){
            $total_amount = htmlspecialchars($arr['total_amount']);//交易金额
            $out_trade_no = htmlspecialchars($arr['out_trade_no']);//订单号
            $trade_no = htmlspecialchars($arr['trade_no']);//支付宝流水号
            $order = OrderModel::where('user_id', $this->auth_user_id)->where('number',$out_trade_no)->first();
            if (!$order) {
                Log::info('没有找到该笔订单，订单号：'.$out_trade_no);
                echo "fail";
                return;
            }
            $money = $order->total_money;
            if ($total_amount != $money) {
                Log::info('支付金额有误，订单号：'.$out_trade_no.','.'交易金额:'.$total_amount);
                echo "fail";
                return;
            }

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
     * @apiParam {integer} number 订单号
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
        $out_trade_no = $request->input('number');
        $trade_no = $request->input('trade_no');
        if (!$out_trade_no && !$trade_no) {
            return $this->response->array(ApiHelper::error('缺少必要参数', 403));
        }
        //请二选一设置
        //构造参数
        $RequestBuilder = new AlipayTradeQueryContentBuilder();
//        $RequestBuilder->setOutTradeNo($out_trade_no);
        $RequestBuilder->setTradeNo($trade_no);

        $aop = new \AlipayTradeService(config('alipay.app_id','alipay.merchant_private_key','alipay.notify_url','alipay.return_url','alipay.charset','alipay.sign_type','alipay.gatewayUrl','alipay.alipay_public_key'));


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
     * @apiParam {integer} number 订单号
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
        $out_trade_no = $request->input('number');
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

        $aop = new \AlipayTradeService(config('alipay.app_id','alipay.merchant_private_key','alipay.notify_url','alipay.return_url','alipay.charset','alipay.sign_type','alipay.gatewayUrl','alipay.alipay_public_key'));

        /**
         * Alipay.trade.refund (统一收单交易退款接口)
         * @param $builder 业务参数，使用buildmodel中的对象生成。
         * @return $response 支付宝返回的信息
         */
        $response = $aop->Refund($RequestBuilder);

        return $this->response->array(ApiHelper::success('Success', 200, $response));

    }


}