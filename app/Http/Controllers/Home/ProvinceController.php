<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ProvinceModel;
class ProvinceController extends Controller
{
    /**
     * 列表
     *
     * @return province list
     */
    public function index()
    {
        $result = ProvinceModel::orderBy('id','desc')->paginate(100);
        return view('home.province.index', ['provinces' => $result]);
    }


    /**
     *删除仓区
     *@param Request
     *@return  resource
     */
    public function destroy(Request $request)
    {
        $id = intval($request->input('id'));
        if(StorageRackModel::destroy($id)){
            $result = ['status' => 1,'message' => '仓区删除成功'];
            return response()->json($result);
        }else{
            $result = ['status' => 0,'message' => '仓区删除失败'];
            return response()->json($result);
        }
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

}
