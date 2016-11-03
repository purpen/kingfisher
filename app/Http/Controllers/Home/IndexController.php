<?php

namespace App\Http\Controllers\Home;

use App\Models\PromptMessageModel;
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
        $messages = PromptMessageModel::select('message', 'id')->paginate(10);
        
        return view('home.index', [
            'content' => $content,
            'messages' => $messages
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $user = UserModel::find($id);
        if($user->update($request->all())){
            return redirect('/home');
        }else{
            return back()->withInput();
        }
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
