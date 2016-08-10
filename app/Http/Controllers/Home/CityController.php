<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\CityModel;
use App\Models\ProvinceModel;
use App\Http\Requests\CityRequest;
class CityController extends Controller
{
    /**
     * 列表
     *
     * @return city list
     */
    public function index()
    {
        $result = CityModel::orderBy('id','desc')->paginate(100);
        $provinces = ProvinceModel::where('status', 1)->get();
        return view('home.city.index', ['cities' => $result, 'provinces'=>$provinces]);
    }

    /**
     *删除
     *@param Request
     *@return  resource
     */
    public function destroy(Request $request)
    {
        $ids = $request->input('ids');
        $id_arr = explode(',', $ids);
        $arr = array();
        for($i=0;$i<count($id_arr);$i++){
            $id = (int)$id_arr[$i];
            $ok = CityModel::destroy($id);
            if($ok){
                array_push($arr, $id);
            }
        }
        $result = ['status' => 1, 'message' => '删除成功!', 'data'=>$arr];
        return response()->json($result);

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        if($city = CityModel::find($id))
        {
            $result = ['status' => 1,'data' => $city];
            return response()->json($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $province = new CityModel();
        $province->name = $request->input('name');
        $province->number = (int)$request->input('number');
        $province->p_number = (int)$request->input('p_number');
        $province->city_py = $request->input('city_py');
        $province->status = 1;
        if($province->save()){
            return back()->withInput();
        }
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
    public function ajaxEdit(Request $request)
    {
            $id = $request->input('id');
            $city = CityModel::find($id);
            if ($city){
                return ajax_json(1,'获取成功',$city);
            }else{
                return ajax_json(0,'数据不存在');
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
        $row = array(
            'number' => (int)$request->input('number'),
            'name' => $request->input('name'),
            'p_number' => (int)$request->input('p_number'),
            'city_py' => $request->input('city_py'),
        );
        $province = CityModel::find((int)$request->input('id'));
        if($province->update($row)){
            return back()->withInput();
        }
        
    }

}
