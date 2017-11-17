<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierMonthModel extends BaseModel
{
    protected $table = 'supplier_month';

    /**
     * 允许批量赋值的字段
     */
    protected  $fillable = ['supplier_name' , 'year_month' , 'total_price' , 'status'];

    /**
     * 更改供应商统计的总额状态
     */
    static public function status($id, $status=0)
    {
        $supplier_month = self::findOrFail($id);
        $supplier_month->status = $status;
        return $supplier_month->save();
    }

    static public function noStatus($id, $status=1)
    {
        $supplier_month = self::findOrFail($id);
        $supplier_month->status = $status;
        return $supplier_month->save();
    }
}
