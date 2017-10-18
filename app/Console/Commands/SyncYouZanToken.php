<?php

namespace App\Console\Commands;


use App\Models\SiteModel;
use App\Models\StoreModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SyncYouZanToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:yzToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步有赞token';

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
        $store = StoreModel::where('platform',6)->first();
        $authorize_overtime = $store->authorize_overtime;
        $day = (strtotime($authorize_overtime)-strtotime(date('Y-m-d h:i:s')))/(60*60*24);
        //检查有赞的token过期时间，如果小于2天的话就更新token和过期时间
        if((int)$day <= 2){
            $yzToken =  $store->yzToken();

            $store->access_token = $yzToken['access_token'];
            $store->authorize_overtime = date("Y-m-d H:i:s",time() + $yzToken['expires_in']);
            $store->save();
        }else{
            return;
        }
    }
}
