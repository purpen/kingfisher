<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\OrderModel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendExcelOrder extends Job implements SelfHandling, ShouldQueue
{
    protected $user_id;

    protected $data;

    protected $excel_type;

    protected $mime;

    protected $file_records_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data , $user_id , $excel_type , $mime , $file_records_id)
    {
        $this->data = $data;
        $this->user_id = $user_id;
        $this->excel_type = $excel_type;
        $this->mime = $mime;
        $this->file_records_id = $file_records_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = new OrderModel();
        if($this->excel_type == 1){
            $order->zyInOrder($this->data , $this->user_id , $this->mime , $this->file_records_id);
        }
        if($this->excel_type == 2){
        }
    }
}
