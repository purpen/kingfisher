<?php
namespace App\Http\Controllers\Api\SaasV1;


use App\Models\SupplierModel;
use App\Models\SupplierReceiptModel;
use Illuminate\Http\Request;

class PaymentController extends BaseController{

//    品牌付款单列表
    public function payment(Request $request){
        echo 111;die;
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