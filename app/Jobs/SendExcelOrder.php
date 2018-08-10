<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\FileRecordsModel;
use App\Models\OrderModel;
use App\Models\OrderMould;
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

    protected $type;

    protected $mould_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data , $user_id , $excel_type , $mime , $file_records_id , $type , $mould_id , $distributor_id)
    {
        $this->data = $data;
        $this->user_id = $user_id;
        $this->excel_type = $excel_type;
        $this->mime = $mime;
        $this->file_records_id = $file_records_id;
        $this->type = $type;
        $this->mould_id = $mould_id;
        $this->distributor_id = $distributor_id;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if($this->type == 1){
                $order = new OrderModel();
                if ($this->excel_type == 1) {
                    $order->zyInOrder($this->data, $this->user_id, $this->mime, $this->file_records_id);
                }
                if ($this->excel_type == 2) {
                    $order->jdInOrder($this->data, $this->user_id, $this->mime, $this->file_records_id);
                }
                if ($this->excel_type == 3) {
                    $order->tbInOrder($this->data, $this->user_id, $this->mime, $this->file_records_id);
                }
            }else{
                $mould = new OrderMould();
                $mould->mould($this->data, $this->user_id, $this->mime, $this->file_records_id , $this->mould_id , $this->distributor_id);
            }

        }
        catch (\Exception $e){
            $fileRecord = FileRecordsModel::where('id' , $this->file_records_id)->first();
            $file_record['status'] = 2;
            $fileRecord->update($file_record);
            Log::error($e);
        }
    }
}
