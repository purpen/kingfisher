<?php

namespace App\Http\Controllers\Home;

use App\Models\SiteModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function siteIndex()
    {
        $sites = SiteModel::paginate(15);
        return view('home/site.site',[
            'sites' => $sites,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function siteCreate()
    {
        $users = UserModel::where('type' , 1)->get();
        $site = new SiteModel();
        $site->items = array();
        return view('home/site.submit' ,[
          'users' => $users,
          'site' => $site,
          'mode' => 'create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function siteStore(Request $request)
    {
        $data = array();
        $data['name'] = $request->input('name') ? $request->input('name') : '';
        $data['mark'] = $request->input('mark') ? $request->input('mark') : '';
        $data['url'] = $request->input('url') ?  $request->input('url') : '';
        $data['grap_url'] = $request->input('grap_url') ?  $request->input('grap_url') : '';
        $data['user_id'] = $request->input('user_id') ?  $request->input('user_id') : 0;
        $data['site_type'] = $request->input('site_type');
        $data['remark'] = $request->input('remark') ? $request->input('remark') : '';
        $item_arr = $request->input('item') ? $request->input('item') : array();

        // 转换配置参数toJSON
        $items = array();
        if ($item_arr) {
            for($i=0;$i<count($item_arr);$i++) {
                $d = explode('@!@', $item_arr[$i]);
                $item = array(
                  'field' => isset($d[0]) ? $d[0] : '',
                  'name' => isset($d[1]) ? $d[1] : '',
                  'code' => isset($d[2]) ? $d[2] : '',
                );
                array_push($items, $item);
            }
        }
        $data['items'] = $items;

        $id = (int)$request->input('id');
        if (empty($id)){
            $ok = SiteModel::create($data);
        } else {
            $site = SiteModel::find($id);
            $ok = $site->update($data);
        }
        if ($ok) {
            return redirect('/saas/site');
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
    public function siteEdit($id)
    {
        $site = SiteModel::where('id' , $id)->first();
        $users = UserModel::where('type' , 1)->get();
        $sep = '@!@';
        $items = array();
        for($i=0;$i<count($site->items);$i++) {
            $item = $site->items[$i];
            $item['temp'] = $item['field'].$sep.$item['name'].$sep.$item['code'];
            array_push($items, $item);
        }
        $site->items = $items;
        return view('home/site.submit',[
            'site' => $site,
            'users' => $users,
            'mode' => 'edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function siteUpdate(Request $request)
    {
        $id = (int)$request->input('site_id');
        $site = SiteModel::find($id);
        if($site->update($request->all())){
            return redirect('/saas/site');
        }
    }

    /*
    * 状态
    */
    public function status(Request $request, $id)
    {
        $ok = SiteModel::okStatus($id, 1);
        return redirect('/saas/site');
    }

    public function unStatus(Request $request, $id)
    {
        $ok = SiteModel::okStatus($id, 0);
        return redirect('/saas/site');
    }

    //删除
    public function delete($id)
    {
        if(SiteModel::destroy($id)){
            return back()->withInput();
        }
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
