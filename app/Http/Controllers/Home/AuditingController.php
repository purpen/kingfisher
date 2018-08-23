<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\AuditingModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class AuditingController extends Controller
{

    public function index(Request $request)
    {
        $auditing = new AuditingModel();
        $auditing_list = $auditing::get();
        foreach ($auditing_list as $k=>$v) {
            $users = explode(",", $v->user_id);
            $user_ids = UserModel::whereIn('id', $users)->select('realname')->get();
            $arrays = $user_ids->toArray();

            $nArr = array();
            for ($i = 0, $len = count($arrays); $i < $len; $i++) {
                $nArr[] = $arrays[$i]['realname'];
            }
            $auditing_list[$k]['user_id'] = implode($nArr, ',');
        }
        $user = new UserModel();
        $realname = UserModel::where('type',1)->select('id','realname')->get();

       return view('home.auditing.auditing',['auditing_list' => $auditing_list,'realname' => $realname]);
    }

    public function store(Request $request)
    {
        $auditing = new AuditingModel();
        $type = $request->input('type');
        if(AuditingModel::where('type',$type)->count() > 0){//已有的审核名不能重复添加
            return ajax_json(1,'该审核模块已存在！如需修改请删除原有模块');
        }
        $auditing->type = $request->input('type');
        $auditing->user_id = $request->input('user_id');
        $auditing->status = (int)$request->input('status',1);

        if ($auditing->save()) {
            return ajax_json(0,'添加成功！');
        }else{
            return ajax_json(1,'添加失败！');
        }
    }

//    编辑（暂未使用）
    public function edit(Request $request)
    {
        $user = new UserModel();
        $realname = UserModel::where('type',1)->select('id','realname')->get();
        $id = (int)$request->input('id');
        $auditing = AuditingModel::find($id);
        $auditing['realname'] = $realname->toArray();
        if ($auditing){
            return ajax_json(1,'获取成功',$auditing);
        }else{
            return ajax_json(0,'数据不存在');
        }
    }

    public function destroy(Request $request)
    {
        $res = AuditingModel::where('id',$request->input('id'))->delete();
        if($res){
            return ajax_json(1,'删除成功');
        }else{
            return ajax_json(0,'删除失败 ');
        }
    }
}