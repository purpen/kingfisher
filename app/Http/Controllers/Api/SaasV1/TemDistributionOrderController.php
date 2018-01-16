<?php
namespace App\Http\Controllers\Api\SaasV1;

use App\Http\ApiHelper;
use App\Models\TemDistributionOrderModel;
use Illuminate\Http\Request;

class TemDistributionOrderController extends BaseController
{
    /**
     * @api {post} /saasApi/TemDistributionOrder 分销商导入订单
     * @apiVersion 1.0.0
     * @apiName TmpDistributionOrder store
     * @apiGroup TmpDistributionOrder
     *
     * @apiParam {integer} distribution_id  分销商用户ID*
     * @apiParam {string} outside_target_id  站外订单号*
     * @apiParam {string} sku_number sku编号*
     * @apiParam {integer} quantity 数量*
     * @apiParam {string} sku_name 商品名sku规格
     * @apiParam {decimal} price  单价
     * @apiParam {string} buyer_name 收货人姓名*
     * @apiParam {string} buyer_tel 收货人电话
     * @apiParam {string} buyer_phone 收货人手机*
     * @apiParam {string} buyer_zip 收货人邮编
     * @apiParam {string} buyer_address 收货人地址*
     * @apiParam {string} buyer_province  省
     * @apiParam {string} buyer_city 市
     * @apiParam {string} buyer_county 县
     * @apiParam {string} buyer_township  镇
     * @apiParam {string} summary 备注
     * @apiParam {string} buyer_summary 买家备注
     * @apiParam {string} seller_summary 卖家备注
     * @apiParam {datetime} order_start_time 下单时间
     * @apiParam {string} invoice_info 发票内容
     * @apiParam {string} invoice_type 发票类型
     * @apiParam {string} invoice_header 发票抬头
     * @apiParam {string} invoice_added_value_tax  增值税发票
     * @apiParam {string} invoice_ordinary_number 普通发票号
     * @apiParam {decimal}  discount_money 优惠金额
     *
     * @apiSuccessExample 成功响应:
     * {
     * "meta": {
     *      "message": "Success.",
     *      "status_code": 200,
     *      }
     * }
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'distribution_id' => 'required|integer',
            'outside_target_id' => 'required|max:30',
            'sku_number' => 'required|max:20',
            'quantity' => 'required|integer',
            'sku_name' => 'max:50',
            'buyer_name' => 'required',
            'buyer_phone' => 'required',
            'buyer_address' => 'required|max:200',
            'order_start_time' => 'required',
        ]);

        if ($tmp = TemDistributionOrderModel::create($request->all())) {
            return $this->response->array(ApiHelper::success('Success.', 200));
        } else {
            return $this->response->array(ApiHelper::error('Error.', 500));
        }
    }
}