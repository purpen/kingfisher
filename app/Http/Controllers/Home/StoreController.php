<?php

namespace App\Http\Controllers\Home;

use App\Models\RefundMoneyOrderModel;
use App\Models\StoreModel;
use Illuminate\Http\Request;

use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = StoreModel::orderBy('id','desc')->get();
        return view('home/store.store',['stores' => $stores]);
    }

    /**
     * 添加自营店铺
     *
     */
    public function StoreShop($name)
    {
        if(StoreModel::where(['platform' => 3])->count() > 0){
            return [false,'自营店铺已添加'];
        }
        $store = new StoreModel();
        $store->name = $name;
        $store->platform = 3;
        $store->user_id = Auth::user()->id;
        $store->status = 1;
        $store->type = 1;
        if($store->save()){
            return [true,'添加成功'];
        }else{
            return [false,'添加失败'];
        }
    }

    /**
     * 添加虚拟店铺
     *
     */
    public function StoreTestShop($name)
    {
        $store = new StoreModel();
        $store->name = $name;
        $store->platform = 4;
        $store->user_id = Auth::user()->id;
        $store->status = 1;
        $store->type = 1;
        if($store->save()){
            return [true,'添加成功'];
        }else{
            return [false,'添加失败'];
        }
    }

    /**
     * 添加众筹店铺
     *
     */
    public function StoreZcShop($name)
    {
        $store = new StoreModel();
        $store->name = $name;
        $store->platform = 5;
        $store->user_id = Auth::user()->id;
        $store->status = 1;
        $store->type = 1;
        if($store->save()){
            return [true,'添加成功'];
        }else{
            return [false,'添加失败'];
        }
    }
    
    //添加授权店铺
    public function ajaxStore (StoreRequest $request){
        $platform = (int)$request->input('platform');
        $name = $request->input('name');

        switch ($platform){
            case 1: 
                $url = $this->TBUrl($platform);
                break;
            case 2:
                $url = $this->jdUrl($platform);
                break;
            case 3:
                $result = $this->StoreShop($name);
                if(!$result[0]){
                    Log::error('自营店铺添加失败');
                    return ajax_json(0,$result[1]);
                }
                return ajax_json(1,$result[1]);
            case 4:
                $result = $this->StoreTestShop($name);
                if(!$result[0]){
                    Log::error('自营店铺添加失败');
                    return ajax_json(0,$result[1]);
                }
                return ajax_json(1,$result[1]);
            case 5:
                $result = $this->StoreZcShop($name);
                if(!$result[0]){
                    Log::error('众筹店铺添加失败');
                    return ajax_json(0,$result[1]);
                }
                return ajax_json(1,$result[1]);
            case 6:
                $result = $this->StoreYzShop($name);
                if(!$result[0]){
                    Log::error('有赞店铺添加失败');
                    return ajax_json(0,$result[1]);
                }
                return ajax_json(1,$result[1]);        }

        return ajax_json(1,'ok',$url);
        
    }
    

    /**
     * 京东授权页面url
     *
     * @param $name
     * @return string
     */
    protected function jdUrl($platform){
        $app_key = config('jdsdk.app_key');
        $authorize_url = config('jdsdk.authorize_url');
        $url = config('jdsdk.url');
        $redirect_url = $authorize_url . "?response_type=code&client_id=" . $app_key . "&
redirect_uri=" . $url . "&state=" . $platform;
        return $redirect_url;
    }

    //京东授权回调处理，获取相关授权信息，转跳店铺页面
    public function jdCallUrl(Request $request){
        if ($request->has('error')){
            return redirect()->route('/store');
        }
        
        $code = $request->input('code');
        $state = $request->input('state');
        $url = config('jdsdk.url');
        $client_id = config('jdsdk.app_key');
        $client_secret = config('jdsdk.app_secret');

        $token_url = config('jdsdk.token_url');
        $ch = curl_init();
        $header = [
            "content-type: application/x-www-form-urlencoded; 
            charset=UTF-8"
        ];
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, true);
        // post的变量
        $post_data = ["grant_type" => "authorization_code","client_id" => $client_id,"redirect_uri" => $url,"code" => $code,"state" => $state, "client_secret" => $client_secret];
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        $output = curl_exec($ch);
        curl_close($ch);
        $this->jdStoreToken($output,$state);
        
    }


    //保存，处理京东授权成功返回的数据
    protected function jdStoreToken($output,$state){
        $output_arr = json_decode(iconv('GB2312', 'UTF-8', $output),true);
        if ($output_arr['code'] != 0){
            header("location:store");
            exit;
//            return redirect()->action('Home\StoreController@index');
        }
        $store = new StoreModel();
        $store->name = $output_arr['user_nick'];
        $store->number = '';
        $store->platform = $state;
        $store->target_id = $output_arr['uid'];
        $store->outside_info = $output;
        $store->summary = '';
        $store->user_id = Auth::user()->id;
        $store->status = 1;
        $store->type = 1;
        $store->access_token = $output_arr['access_token'];
        $store->refresh_token = $output_arr['refresh_token'];
        $store->authorize_overtime = date("Y-m-d H:i:s",time() + $output_arr['expires_in']);
        if($store->save()){
            header("location:store");
            exit;
//            return redirect()->route('/store');
        }else{
            header("location:store");
            exit;
//            return redirect()->route('/store');
        }
        
    }

    /**
     * 淘宝授权页面url--拼接
     *
     * @param $platform
     * @return string
     */
    protected function TBUrl($platform){
        $app_key = config('taobao.appKey');
        $authorize_url = config('taobao.authorize_url');
        $url = config('taobao.redirect_uri');
        $redirect_url = $authorize_url . "?response_type=code&client_id=" . $app_key . "&
redirect_uri=" . $url . "&state=" . $platform . '&view=web';
        return $redirect_url;
    }

    /**
     * 京东回调地址
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function TBCallUrl(Request $request){
        if ($request->has('error')){
            return redirect()->route('/store');
        }

        $code = $request->input('code');
        $state = $request->input('state');
        $url = config('taobao.redirect_uri');
        $client_id = config('taobao.appKey');
        $client_secret = config('taobao.secretKey');

        $token_url = config('taobao.token_url');
        $ch = curl_init();
        $header = [
            "content-type: application/x-www-form-urlencoded; 
            charset=UTF-8"
        ];
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, true);
        // post的变量
        $post_data = ["grant_type" => "authorization_code","client_id" => $client_id,"redirect_uri" => $url,"code" => $code,"state" => $state, "client_secret" => $client_secret, "view" => 'web'];
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        $output = curl_exec($ch);
        curl_close($ch);
        $this->TBStoreToken($output,$state);

    }

    /**
     * 保存，处理淘宝授权成功返回的数据
     *
     * @param $output
     * @param $state
     */
    protected function TBStoreToken($output,$state){
        $output_arr = json_decode($output,true);
        if (!isset($output_arr['access_token'])){
            header("location:store");
            exit;
//            return redirect()->action('Home\StoreController@index');
        }
        $store = new StoreModel();
        $store->name = urldecode($output_arr['taobao_user_nick']);
        $store->number = '';
        $store->platform = $state;
        $store->target_id = $output_arr['taobao_user_id'];
        $store->outside_info = $output;
        $store->summary = '';
        $store->user_id = Auth::user()->id;
        $store->status = 1;
        $store->type = 1;
        $store->access_token = $output_arr['access_token'];
        $store->refresh_token = $output_arr['refresh_token'];
        $store->authorize_overtime = date("Y-m-d H:i:s",time() + $output_arr['expires_in']);
        if($store->save()){
            header("location:store");
            exit;
//            return redirect()->route('/store');
        }else{
            header("location:store");
            exit;
//            return redirect()->route('/store');
        }

    }

    /*获取更新店铺信息*/
    public function ajaxEdit(Request $request)
    {
        $id = $request->input('id');
        $store = StoreModel::find($id);
        if ($store){
            return ajax_json(1,'获取成功',$store);
        }else{
            return ajax_json(0,'数据不存在');
        }
    }

    /*更新店铺信息*/
    public function ajaxUpdate(Request $request)
    {
        $store = StoreModel::find($request->input('id'));
        if($store->update($request->all())){
            return ajax_json(1,'更改成功');
        }else{
            return ajax_json(0,'更改失败');
        }
    }

    /*删除店铺*/
    public function ajaxDestroy(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        if(StoreModel::destroy($id)){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }

    /**
     * 添加有赞店铺
     *
     */
    public function StoreYzShop($name)
    {
        if(StoreModel::where(['platform' => 6])->count() > 0){
            return [false,'有赞店铺已添加'];
        }
        $store = new StoreModel();
        $yzToken =  $store->yzToken();
        $store->name = $name;
        $store->platform = 6;
        $store->target_id = config('youzan.kdt_id');
        $store->user_id = Auth::user()->id;
        $store->status = 1;
        $store->type = 1;
        $store->access_token = $yzToken['access_token'];
        $store->authorize_overtime = date("Y-m-d H:i:s",time() + $yzToken['expires_in']);
        if($store->save()){
            return [true,'添加成功'];
        }else{
            return [false,'添加失败'];
        }
    }

}
