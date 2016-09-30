<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Log;
class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jdCalllback(Request $request)
    {
        Log::write('info', 'Test jd_callback!!!!');
        Log::write('info', json_encode($request->input()));
        echo "123";
        //return view('home.index');
    }


    public function ceShi()
    {
        $suppliers=DB::table('supplier')->get();
        foreach($suppliers as $supplier){
//            $number = DB::table('products')->where('number',$product->number)->count();
//            if($number>0){
//                continue;
//            }
            DB::table('suppliers')->insert(
                [
                    'name'=>$supplier->name,
                    'nam'=>$supplier->nam,
                    'summary'=>$supplier->summary,
                    'contact_user'=>$supplier->contact_user,
                    'contact_number'=>$supplier->contact_number,
                    'tel'=>$supplier->tel,
                    'address'=>$supplier->address,
                    'contact_qq'=>$supplier->contact_qq,
                    'summary'=>$supplier->summary

                ]);
        }

    }
}
