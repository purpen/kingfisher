<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Libraries\YunPianSdk\Yunpian;

class SendVerifySMS extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $yunpian = new Yunpian();
        $yunpian->sendOneSms($this->data);
    }
    
    /**
     * 处理失败任务
     *
     * @return void
     */
    public function failed()
    {
        
    }
}
