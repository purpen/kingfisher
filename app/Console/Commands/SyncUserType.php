<?php

namespace App\Console\Commands;


use App\Models\UserModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SyncUserType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:userType';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更改用户type';

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
        $users = UserModel::get();
        foreach ($users as $user){
            if($user->type == 1){
                $user->supplier_distributor_type = 1;
                $user->type = 0;
                $user->save();
                continue;
            }
            if($user->type == 0){
                $user->type = 1;
                $user->save();
                continue;
            }

        }
    }
}
