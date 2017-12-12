<?php

namespace App\Console\Commands;


use App\Models\SiteModel;
use App\Models\StoreModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Libraries\WxPay\lib\WxPayConfig;


class SyncWxAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:WxAccessToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新微信token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".WxPayConfig::APPID."&secret=".WxPayConfig::APPSECRET;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $dataBlock = curl_exec($ch);//这是json数据
        curl_close($ch);
        $res = json_decode($dataBlock, true); //接受一个json格式的字符串并且把它转换为 PHP 变量

        $WxAccessToken = $res['access_token'];
        if(!empty($WxAccessToken)){
            Redis::set('wx_access_token' , $WxAccessToken);

            //更新jsapi_ticket
            $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".Redis::get('wx_access_token')."&type=jsapi";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $dataBlock = curl_exec($ch);//这是json数据
            curl_close($ch);
            $res = json_decode($dataBlock, true);
            Redis::set('wx_ticket' , $res['ticket']);

        }


    }
}
