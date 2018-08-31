<?php
/**
 * 分类模型
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class CategoriesModel extends BaseModel
{
    /**
     * 关联模型到数据表
     *
     * @var string
     */
    protected $table = 'categories';

    //一对多关联商品表
    public function ProductsModel()
    {
        return $this->hasMany('App\Models\ProductsModel', 'category_id');
    }
    //一对多关联经销商表
    public function DistributorsModel()
    {
        return $this->hasMany('App\Models\DistributorModel', 'category_id');
    }

    /**
     * 获取分类列表
     * @param integer $id
     * @param integer $n
     *
     * @return array
     */
    public function lists($id=0,$type=null)
    {
        if($type === null){
            $categories = self::where('status',1)->get();
        }else{
            $categories = self::where('type',$type)->where('status',1)->get()->toArray();
        }
        return $this->getSons($categories,$id);
    }

    /**
     * 递归获取全部子分类
     * @param array $categories
     * @param int $id
     * @param int $n
     * @return array
     */
    protected function getSons($categories,$id=0,$n=0)
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


    public function getOne($condition,$cloum)
    {//字段名 值
       $arr = DB::table('categories')->where($condition,$cloum)->get();
        return $arr;
    }
}
