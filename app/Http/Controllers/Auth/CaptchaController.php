<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\CaptchaModel;
use App\Http\Controllers\Controller;
use App\Libraries\YunPianSdk\Yunpian;
use App\Jobs\SendVerifySMS;

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
        $requests = $request->all();
        $validator = Validator::make($requests, $rules);
        
        if ((int)$request['phone_verify_key'] !== session('phone_verify_key')){
            return ajax_json(0, '通过非法路径提交的数据，请通过正确途径提交数据！');
        }
        
        if ($validator->fails()){
            return ajax_json(0, '输入手机号码格式错误！');
        }

        $code = (string)mt_rand(100000,999999);
        $captcha = new CaptchaModel();
        if($captcha_find = $captcha::where('phone', $request['phone'])->first()){
            $captcha_find->code = $code;
            $captcha_find->type = 1;
            $result = $captcha_find->save();
        }else{
            $captcha->phone = $request['phone'];
            $captcha->code = $code;
            $captcha->type = $request['type'];
            $result = $captcha->save();
        }
        
        if(!$result){
            return ajax_json(0, '验证码创建失败！');
        }
        
        $data = array();
        $data['mobile'] = $request['phone'];
        $data['text'] = '【太火鸟】验证码：'.$code.'，切勿泄露给他人，如非本人操作，建议及时修改账户密码。';
        // 发送短信到队列
        //$this->dispatch(new SendVerifySMS($data));

        $yunpian = new Yunpian();
        $yunpian->sendOneSms($data);
        
        return ajax_json(1, '发送手机验证码成功！');
    }
    
    /**
     * 判断数据库是否存在手机验证码
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string json
     */
    public function isExistCode(Request $request)
    {

        $result = CaptchaModel::where('phone', $request['phone'])->where('code', $request['code'])->first();
        if(!$result){
            return ajax_json(0, '该验证码不存在！');
        }
        return ajax_json(1, '该验证码存在！');
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
