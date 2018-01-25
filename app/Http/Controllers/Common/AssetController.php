<?php

namespace App\Http\Controllers\Common;

use App\Models\AssetsModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

class AssetController extends Controller
{

    //七牛回调方法
    public function callback(Request $request)
    {
        $post = $request->all();
            $domain = config('qiniu.domain');
            $imageData = [];
            $imageData['user_id'] = $post['user_id'];
            $imageData['name'] = $post['name'];
            $imageData['random'] = $post['random'];
            $imageData['size'] = $post['size'];
            $imageData['width'] = $post['width'];
            $imageData['height'] = $post['height'];
            $imageData['mime'] = $post['mime'];
            $imageData['domain'] = $domain;
            $imageData['target_id'] = $post['target_id'];
            $imageData['type'] = isset($post['type']) ? (int)$post['type'] : 0;
            $key = uniqid();
            $imageData['path'] = $domain . '/' .date("Ymd") . '/' . $key;
            
            if($asset = AssetsModel::create($imageData)){
                $id = $asset->id;
                $callBackDate = [
                    'key' => $asset->path,
                    'payload' => [
                        'success' => 1,
                        'name' => config('qiniu.url').$asset->path,
                        'small' => config('qiniu.url').$asset->path.config('qiniu.small'),
                        'asset_id' => $id
                    ]
                ];
                return response()->json($callBackDate);
            }else{
                $callBackDate = [
                    'key' => '',
                    'payload' => [
                        'success' => 0,
                        'name' => '',
                        'small' => '',
                        'asset_id' => ''
                    ]
                ];
                return response()->json($callBackDate);
            }
    }

    //安全的url编码 urlsafe_base64_encode函数
    function urlsafe_base64_encode($data) 
    {
        $data = base64_encode($data);
        $data = str_replace(array('+','/'),array('-','_'),$data);
        return $data;
    }

    //删除图片
    public function ajaxDelete(Request $request)
    {
        $id = $request->input('id');
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');

        //初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);

        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);

        //你要测试的空间， 并且这个key在你空间中存在
        $bucket = config('qiniu.bucket_name');

        if($asset = AssetsModel::find($id)){
            $key = $asset->path;
        }else{
            return ajax_json(0,'图片不存在');
        }


        //删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        if ($err !== null) {
            Log::error($err);
        } else {
            if(AssetsModel::destroy($id)){
                return ajax_json(1,'图片删除成功');
            }else{
                return ajax_json(0,'图片删除失败');
            }
        }
    }

    /**
     * 七牛图片copy
     *
     * @param $url
     * @param $target_id
     * @param int $type
     * @return bool
     */
    static public function copyImg($url,$target_id,$type=1)
    {
        $accessKey = config('qiniu.access_key');
        $secretKey = config('qiniu.secret_key');

        //初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);

        //初始化BucketManager
        $bucketMgr = new BucketManager($auth);

        //from 数据
        $bucket1 = 'frbird';
        $arr = explode('/',$url);
        unset($arr[0],$arr[1],$arr[2]);
        $key1 = implode('/',$arr);

        //to 数据
        $bucket2 = config('qiniu.bucket_name');
        $key = uniqid();
        $key2 = config('qiniu.domain') . '/' .date("Ymd") . '/' . $key;

        //将文件从文件$key1复制到文件$key2。可以在不同bucket复制
        $err = $bucketMgr->copy($bucket1, $key1, $bucket2, $key2);
        if ($err !== null) {
            return false;
        }

        $imageData = [];
        $imageData['user_id'] = '';
        $imageData['name'] = '';
        $imageData['random'] = '';
        $imageData['size'] = '';
        $imageData['width'] = '';
        $imageData['height'] = '';
        $imageData['mime'] = '';
        $imageData['domain'] = config('qiniu.domain');
        $imageData['target_id'] = $target_id;
        $imageData['path'] = $key2;
        $imageData['type'] = $type;

        if(!AssetsModel::create($imageData)){
            return false;
        }

        return true;
    }

    /**
     *  附件下载
     */
    public function download(Request $request)
    {
      $asset_id = $request->input('asset_id');
      if(!$asset_id) {
                return ajax_json(0,'警告：审核失败');    
      }
    }

}
