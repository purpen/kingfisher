<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests\AddOrderUserRequest;
use App\Helper\JdApi;
use App\Helper\ShopApi;
use App\Http\Requests;
use App\Models\OrderUserModel;
use App\Models\OrderModel;
use App\Models\ChinaCityModel;
use App\Models\ShippingAddressModel;
use App\Models\StoreModel;
use App\Http\Controllers\Controller;

class OrderUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderUsers = OrderUserModel::orderBy('id','desc')->paginate($this->per_page);

        return view('home/orderUser.orderUser',['orderUsers' => $orderUsers ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $china_city = ChinaCityModel::where('layer',1)->get();
        $store_list = StoreModel::select('id','name')->get();
        return view('home/orderUser.createOrderUser',[
            'china_city' => $china_city,
            'store_list' => $store_list
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddOrderUserRequest $request)
    {
        $username = OrderUserModel::where('username' , $request->input('username'))->first();
        $phone = OrderUserModel::where('phone' , $request->input('phone'))->first();
        if(($username && $phone) !=null){
            return redirect('/orderUser/create')->with('error_message',"该会员已经存在");
        }
        $orderUser = new OrderUserModel();
        $orderUser->username = $request->input('username');
        $orderUser->phone = $request->input('phone');
        $orderUser->store_id = $request->input('store_id');
        $orderUser->type = $request->input('type');
        $orderUser->from_to = $request->input('from_to');
        $orderUser->account = $request->input('account');
        $orderUser->email = $request->input('email');
        $orderUser->qq = $request->input('qq');
        $orderUser->ww = $request->input('ww');
        $orderUser->sex = $request->input('sex');
        $orderUser->tel = $request->input('tel');
        $orderUser->zip = $request->input('zip');
        $orderUser->buyer_address = $request->input('buyer_address');
        $orderUser->buyer_province = ChinaCityModel::where('oid', $request->input('province_id'))->first()->name;
        $orderUser->buyer_city = ChinaCityModel::where('oid', $request->input('city_id'))->first()->name;
        $orderUser->buyer_county = ChinaCityModel::where('oid', $request->input('county_id'))->first()->name;
        if ($request->input('township_id')){
            $orderUser->buyer_township = ChinaCityModel::where('oid', $request->input('township_id'))->first()->name;
        }
        $orderUsers = $orderUser->save();
        if($orderUsers == true ) {
            return redirect('/orderUser');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $order_user_id = (int)$request->input('id');
        $orderUser = OrderUserModel::where('id',$order_user_id)->first();
        $china_city = ChinaCityModel::where('layer',1)->get();
        $store_list = StoreModel::select('id','name')->get();
        return view('home/orderUser.editOrderUser',[
            'orderUser' => $orderUser,
            'china_city' => $china_city,
            'store_list' => $store_list
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

        $orderUserId = (int)$request->input('id');

        $orderUser = OrderUserModel::find($orderUserId);
        $orderUser->username = $request->input('username');
        $orderUser->phone = $request->input('phone');
        $orderUser->store_id = $request->input('store_id');
        $orderUser->type = $request->input('type');
        $orderUser->from_to = $request->input('from_to');
        $orderUser->account = $request->input('account');
        $orderUser->email = $request->input('email');
        $orderUser->qq = $request->input('qq');
        $orderUser->ww = $request->input('ww');
        $orderUser->sex = $request->input('sex');
        $orderUser->tel = $request->input('tel');
        $orderUser->zip = $request->input('zip');
        $orderUser->buyer_address = $request->input('buyer_address');
        $orderUser->buyer_province = $request->input('province_id');
        $orderUser->buyer_city = $request->input('city_id');
        $orderUser->buyer_county = $request->input('county_id');
        $orderUser->buyer_township = $request->input('township_id');
        $orderUsers = $orderUser->update();

        if($orderUsers == true){
            return redirect('/orderUser');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = (int)$request->input('id');
        if(OrderUserModel::destroy($id)){
            return redirect('/orderUser');
        }

    }


    /*
     * 搜索
     */
    public function search(Request $request)
    {
        $search = $request->input('usernamePhone');
        $orderUsers = OrderUserModel::where('username','like','%'.$search.'%')->orWhere('phone','like','%'.$search.'%')->paginate(20);
        if($orderUsers){
            return view('home/orderUser.orderUser',['orderUsers' => $orderUsers ]);
        }
    }

    /**
     * 获取渠道用户信息列表
     *
     * @return string
     */
    public function ajaxOrderUser()
    {
        $user_list = OrderUserModel
            ::where('type', "=", '2')
            ->orderBy('id', 'desc')
            ->take(20)->get();
        return ajax_json(1,'ok', $user_list);
    }

    /**
     * 搜索渠道用户
     *
     * @param Request $request
     * @return string
     */
    public function ajaxSearch(Request $request)
    {
        $option = $request->input('option');
        if(empty($option)){
            return ajax_json(0, '输入不能为空');
        }
        $orderUsers = OrderUserModel
            ::where('type', "=", '2')
            ->where('username','like','%'.$option.'%')
            ->orWhere('phone','like','%'.$option.'%')
            ->orWhere('account', 'like', '%'.$option.'%')
            ->get();
        return ajax_json(1,'ok',$orderUsers);
    }

}
