<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{
    /**
     * 关联模型到数据表
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * 获取分类列表
     * @param integer $id
     * @param integer $n
     *
     * @return array
     */
    public function lists($id=0)
    {
        $categories = self::all();
        return $this->getSons($categories,$id);
    }

    /**递归获取全部子分类
     * @param array $categories
     * @param int $id
     * @param int $n
     * @return array
     */
    protected function getSons(array $categories,$id=0,$n=0)
    {
        $sons = [];
        foreach ($categories as $category) {
            if($category['pid'] == $id){
                $category['n'] = $n;
                $sons[] = $category;
                $sons = array_merge($sons,$this->getSons($categories,$category['id'],$n+1));
            }
        }
        return $sons;
    }
}
