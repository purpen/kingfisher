<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Models\PositiveEnergyModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 显示短语
        $date = date('H');
        if ($date > 0 and $date < 8) {
            $date = 1;
        } elseif ($date > 8 and $date < 12) {
            $date = 2;
        }elseif($date > 12 and $date < 18){
            $date = 3;
        }elseif($date > 18 and $date < 24){
            $date = 4;
        }

        $sex = Auth::user()->sex;
        if (!$sex) {
            $positiveEnergys = PositiveEnergyModel::orderBy('id','desc')->get();
        }else{
            $positiveEnergys = PositiveEnergyModel::where('type',$date)->where('sex',$sex)->get();
        }

        $contents = [];
        foreach($positiveEnergys as $positiveEnergy){
            $contents[] = $positiveEnergy->content;
        }
        
        $k = array_rand($contents);

        return view('home.index', ['content'=>$contents[$k]]);
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
