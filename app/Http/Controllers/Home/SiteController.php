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
        return view('home/site.siteCreate' ,[
            'users' => $users,
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
        $site = new SiteModel();
        $site->name = $request->input('name') ? $request->input('name') : '';
        $site->mark = $request->input('mark') ? $request->input('mark') : '';
        $site->url = $request->input('url') ?  $request->input('url') : '';
        $site->user_id = $request->input('user_id') ?  $request->input('user_id') : 0;
        $site->site_type = $request->input('site_type');
        $site->remark = $request->input('remark') ? $request->input('remark') : '';

        $sites = $site->save();
        if($sites == true){
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
        return view('home/site.siteEdit',[
            'site' => $site,
            'users' => $users,
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
