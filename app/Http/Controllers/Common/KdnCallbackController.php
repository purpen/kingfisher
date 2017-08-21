<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KdnCallbackController extends Controller
{
    /**
     * 快递鸟物流回调方法
     */
    public function callback(Request $request)
    {
        $success = true;
        $content = '成功';

//        $json_str = file_get_contents('php://input');
        $json_str = $request->input('RequestData');
        Log::info($json_str);
        $data = json_decode($json_str, true);

        $EBusinessID = config('express.parter_id');

        foreach ($data['Data'] as $v) {
            if ($v['EBusinessID'] != $EBusinessID) {
                $success = false;
                $content = '用户ID不正确';
                break;
            } else {
                $order = OrderModel::where('id', $v['CallBack'])->first();
                if (!$order) {
                    $success = false;
                    $content = '订单ID不存在';
                }

                $express_content_array = [];
                foreach ($v['Traces'] as $k) {
                    $express_content_array[] = $k['AcceptTime'] . ',' . $k['AcceptStation'];
                }

                $order->express_state = $v['State'];
                $order->express_content = implode('&', $express_content_array);
                if (!$order->save()) {
                    $success = false;
                    $content = '保存失败';
                }
            }
        }

        if ($success) {
            $response = [
                'EBusinessID' => $EBusinessID,
                'UpdateTime' => date("Y-m-d H:i:s"),
                'Success' => true,
                'Reason' => $content,
            ];
            echo json_encode($response);
        } else {
            $response = [
                'EBusinessID' => $EBusinessID,
                'UpdateTime' => date("Y-m-d H:i:s"),
                'Success' => false,
                'Reason' => $content,
            ];
            echo json_encode($response);
        }
    }

}