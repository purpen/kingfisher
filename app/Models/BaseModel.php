<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * 应该被转换成原生类型的属性。
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];
    /**
     * 添加创建时间create_at格式化的create_at_val
     * @return string
     */
    public function getCreatedAtValAttribute()
    {
        $datetime = \DateTime::createFromFormat('Y-m-d H:i:s', $this->created_at);
        return $datetime->format('Y-m-d H:i');
    }
    
    /**
     * Laravel 的关联查询中，经常使用 with 方法来避免 N+1 查询，但是 with 会将目标关联的所有字段全部查询出来
     * withOnly 方法则可以指定返回字段，用法与with相同
     *
     * @example Topic::limit(2)->withOnly('user', ['username'])->get();
     */
    public function scopeWithOnly($query, $relation, Array $columns)
    {
        return $query->with([$relation => function ($query) use ($columns) {
            $query->select(array_merge(['id'], $columns));
        }]);
    }
    
}
