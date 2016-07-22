<?php

namespace App\Http\Controllers\Home;

use App\Models\EnterWarehousesModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EnterWarehouseController extends Controller
{
    //入库首页---采购入库
    public function home(){
        $enter_warehouses = EnterWarehousesModel::where('type',1)->paginate(20);
        foreach ($enter_warehouses as $enter_warehouse){
            $enter_warehouse->purchase_number = $enter_warehouse->purchase->number;
            $enter_warehouse->storage_name = $enter_warehouse->storage->name;
            $enter_warehouse->user_name = $enter_warehouse->user->realname;
        }

        return view('home/storage.purchaseEnterWarehouse',['enter_warehouses' => $enter_warehouses]);
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
