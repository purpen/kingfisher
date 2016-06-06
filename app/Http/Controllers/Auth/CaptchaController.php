<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\CaptchaModel;
use App\Http\Controllers\Controller;
use App\Libraries\YunPianSdk\Yunpian;

class CaptchaController extends Controller
{
    
    /**
     * 发送手机验证码
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string json
     */
    public function postSendCaptcha(Request $request)
    {
        $rules = ['phone' => 'regex:/^1[34578][0-9]{9}$/'];
        $request = $request->all();
        $validator = Validator::make($request, $rules);
        
        if ($validator->fails())
        {
            return ajax_json(0, '输入手机号码格式错误！');
        }
        
        $code = (string)mt_rand(100000,999999);
        
        $yunpian = new Yunpian();
        $data['mobile'] = $request['phone'];
        $data['text'] = '【太火鸟】验证码：'.$code.'，切勿泄露给他人，如非本人操作，建议及时修改账户密码。';
        $yunpian = $yunpian->sendOneSms($data);
        $result = $yunpian->responseData;
        
        if(isset($result['http_status_code']) && $result['http_status_code'] == 400)
        {
            return ajax_json(0, $result['msg']);
        }
        
        $captcha = new CaptchaModel;
        $captcha->phone = $request['phone'];
        $captcha->code = $code;
        $result = $captcha->save();
        
        if(!$result)
        {
            return ajax_json(0, '验证码创建失败！');
        }
        
        return ajax_json(1, '发送手机验证码成功！');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
