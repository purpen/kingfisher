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

        $user = new UserModel();
        $realname = UserModel::where('type',1)->select('id','realname')->get();
       return view('home.auditing.auditing',['auditing_list' => $auditing_list,'realname' => $realname]);
    }

    public function store(Request $request)
    {
        var_dump($request->all());die;
    }
}