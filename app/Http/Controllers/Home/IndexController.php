<?php

namespace App\Http\Controllers\Home;

use App\Models\EnterWarehousesModel;
use App\Models\OrderModel;
use App\Models\OutWarehousesModel;
use App\Models\ProductsModel;
use App\Models\PromptMessageModel;
use App\Models\PurchaseModel;
use App\Models\RefundMoneyOrderModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use App\Models\PositiveEnergyModel;
use App\Models\UserModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\AssetController;
use App\Models\AssetsModel;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content = '';
        
        // 显示短语
        $date = date('H');
        if ($date >= 0 and $date < 8) {
            $date = 1;
        } elseif ($date >= 8 and $date < 12) {
            $date = 2;
        } elseif ($date >= 12 and $date < 18) {
            $date = 3;
        } elseif ($date >= 18 and $date < 24) {
            $date = 4;
        }

        $sex = Auth::user()->sex;
        if (!$sex) {
            $positiveEnergys = PositiveEnergyModel::orderBy('id', 'desc')->get();
        }else{
            $positiveEnergys = PositiveEnergyModel::where('type', $date)->where('sex',$sex)->get();
        }
        
        $contents = [];
        foreach ($positiveEnergys as $positiveEnergy) {
            $contents[] = $positiveEnergy->content;
        }
                
        if (!empty($contents)) {
            $k = array_rand($contents);
            $content = $contents[$k];
        }

        // 错误日志提示
        $messages = PromptMessageModel::select('message', 'id')->where('status','=',0)->paginate(10);

        /**
         * 待处理提示
         */
        $prompt = $this->prompt();

        return view('home.index', [
            'content' => $content,
            'messages' => $messages,
            'prompt' => $prompt,
        ]);
    }

    /**
     * 待处理失误提示
     * 待发货订单 0  售后订单 0  待审供应商 0  待上架商品 0  待审采购单 0  待审入库单 0 待审出库单 0
     */
    protected function prompt()
    {
        $prompt = [];
        //待发货订单
        $prompt['sendOrderCount'] = OrderModel::sendOrderCount();
        //售后订单
        $prompt['servicingOrderCount'] = RefundMoneyOrderModel::refundMoneyOrderCount();
        //待审核供应商
        $prompt['verifySupplierCount'] = SupplierModel::verifySupplierCount();
        //待上架商品
        $prompt['verifyProductCount'] = ProductsModel::verifyProductCount();
        //待审采购单
        $prompt['verifyPurchaseCount'] = PurchaseModel::verifyCount();
        //出库单
        $prompt['outWarehouseCount'] = OutWarehousesModel::outWarehouseCount();
        //入库单
        $prompt['enterWarehouseCount'] = EnterWarehousesModel::enterWarehouseCount();

        return $prompt;
        
    }

    /**
     * 警告信息确认阅读
     */
    public function ajaxConfirm(Request $request)
    {
        $id = (int)$request->input('id');
        $message_model = PromptMessageModel::find($id);
        if (!$message_model) {
            return ajax_json(0,'参数错误');
        }
        $message_model->status = 1;
        $message_model->user_id = Auth::user()->id;
        if (!$message_model->save()) {
            return ajax_json(0,'确认失败');
        }
        
        return ajax_json(1,'ok');
    }
    
    
    public function test()
    {
        return view('welcome');
    }
    
    function is_pjax(){
        return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
    }
    
    public function test_next()
    {
        $data =  [
            array('name' => 'xiaoli'),
            array('name' => 'xiaoming'),
            array('name' => 'xiaotian'),
        ];
        // pjax请求返回json
        if ($this->is_pjax()) {
            return ajax_json(1, '请求数据成功！', $data);
        }
        
        // 正常访问
        return view('welcome', ['html' => json_encode($data)]);
    }
}
