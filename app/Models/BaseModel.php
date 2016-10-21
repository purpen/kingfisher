<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 添加创建时间create_at格式化的create_at_val
     * @return string
     */
    public function getCreatedAtValAttribute()
    {
        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
        return $datetime->format('y-m-d H:i');
    }
    
}
