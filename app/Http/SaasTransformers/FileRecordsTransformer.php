<?php

namespace App\Http\SaasTransformers;

use League\Fractal\TransformerAbstract;

class FileRecordsTransformer extends TransformerAbstract
{
    public function transform($file_records)
    {
        return [
            'id' => $file_records->id,
            'user_id' => $file_records->user_id,
            'file_name' => $file_records->file_name,
            'status' => $file_records->status,
            'total_count' => $file_records->total_count,
            'success_count' => $file_records->success_count,
            'no_sku_count' => $file_records->no_sku_count,
            'no_sku_string' => $file_records->no_sku_string,
            'repeat_outside_count' => $file_records->repeat_outside_count,
            'repeat_outside_string' => $file_records->repeat_outside_string,
            'null_field_count' => $file_records->null_field_count,
            'null_field_string' => $file_records->null_field_string,
            'sku_storage_quantity_count' => $file_records->sku_storage_quantity_count,
            'sku_storage_quantity_string' => $file_records->sku_storage_quantity_string,
        ];
    }


}
