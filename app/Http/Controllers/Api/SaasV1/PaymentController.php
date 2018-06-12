<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Models\SupplierModel;
use App\Models\SupplierReceiptModel;
use Illuminate\Http\Request;

class PaymentController extends BaseController{

      /**
       * @api {get} /saasApi/payment 品牌付款单列表
       * @apiVersion 1.0.0
       * @apiName Payment payment
       * @apiGroup Payment
       *
       * @apiParam {integer} status 状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
       * @apiParam {string} token token
       * @apiSuccessExample 成功响应:
      {
      "data": [
      {
      "id": 2,
      "number": "PP2018061100012",  //单号
      "supplier_user_id": "魅族科技",  //供货商ID
      "start_time": "0000-00-00 00:00:00",  //开始时间
      "end_time": "0000-00-00 00:00:00",  //结束时间
      "total_price": 1000,  //总金额
      "status": 2,  //状态: 0.默认 1.待采购确认 2.待供应商确认 3.待确认付款 4.完成
      },
      ],
      "meta": {
      "message": "Success.",
      "status_code": 200,
      "pagination": {
      "total": 1,
      "count": 1,
      "per_page": 10,
      "current_page": 1,
      "total_pages": 1,
      "links": {
      "next": "http://www.work.com/saasApi/payment?page=2"
      }
      }
      }
      }
       *
       *
       */
//    品牌付款单列表
    public function payment(Request $request){
        $status = (int)$request->input('status', 0);
        $per_page = (int)$request->input('per_page', 10);
        $supplier_user_id = $request->input('supplier_user_id');
//        $supplier=SupplierModel::where('id',$supplier_user_id)->first();
//        $supplier['name'] = $supplier->nam;

        $query = array();
        $query['supplier_user_id'] = $supplier_user_id;
        if(!empty($status)){
            if ($status === -1) {
                $status = 0;
            }
            $query['status'] = $status;
            $orders = SupplierReceiptModel::where($query)->orderBy('id', 'desc')->paginate($per_page);
        }else{
            $orders = SupplierReceiptModel::orderBy('id', 'desc')->where('supplier_user_id' , $supplier_user_id)->paginate($per_page);
        }

        return $this->response->paginator($orders, new OrderTransformer())->setMeta(ApiHelper::meta());
    }



}