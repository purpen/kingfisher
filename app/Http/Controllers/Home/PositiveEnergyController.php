<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Models\PositiveEnergyModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PositiveEnergyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positiveEnergys= PositiveEnergyModel::orderBy('id','desc')->paginate(20);
        return view('home/positiveEnergy.positiveEnergy',['positiveEnergys'=>$positiveEnergys]);
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
        $positiveEnergys = new PositiveEnergyModel();
        $positiveEnergys->content = $request->input('content');
        $positiveEnergys->type = $request->input('type');
        $positiveEnergys->sex = $request->input('sex');
        if($positiveEnergys->save()){
            return back()->withInput();
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
        $id = $request->input('id');
        $positiveEnergys = PositiveEnergyModel::find($id);
        if($positiveEnergys){
            return ajax_json(1,'获取数据成功',$positiveEnergys);
        }else{
            return ajax_json(0,'获取数据失败');
        }
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
        if(!empty($id)){
            $positiveEnergys = PositiveEnergyModel::find($id);
            if($positiveEnergys->update($request->all())) {
                return back()->withInput();
            }
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
        $id = $request->input('id');
        $id = intval($id);
        if(PositiveEnergyModel::destroy($id)){
            return ajax_json(1,'删除成功');

        }else{
            return ajax_json(0,'删除失败 ');

        }
    }


}
