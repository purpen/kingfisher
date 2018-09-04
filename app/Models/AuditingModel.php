<?php

namespace App\Models;
use App\Libraries\YunPianSdk\Yunpian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditingModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到审核管理表
     * @var string
     */
    protected $table = 'auditing';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */
    protected $fillable = ['type','user_id','status'];

//    批量发送短信
    public function datas($type)
    {
        $id = AuditingModel::where('type',$type)->select('user_id')->first();
        $user_id = explode(",",$id->user_id);
        $phone = UserModel::whereIn('id',$user_id)->select('phone')->get();
        $phones = $phone->toArray();

        $newArr = array();
        for ($i = 0, $len = count($phones); $i < $len; $i++) {
            $newArr[] = $phones[$i]['phone'];
        }
        $data = array();
        $data['mobile'] = implode($newArr, ',');
        $data['text'] = '【太火鸟】您有需要审核的信息，请及时登录ERP后台处理。如已处理完成，请忽略此短信。';
        $yunpian = new Yunpian();
        $yunpian->sendManySms($data);
    }
}
