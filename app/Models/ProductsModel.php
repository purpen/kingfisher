<?php
/**
 * 商品表
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'products';
    /**
     * 可被批量赋值的字段
     * @var array
     */
    protected $fillable = ['title','tit','category_id','brand_id','brand_id','authorization_id','supplier_id','market_price','sale_price','inventory','cover_id','unit','published','weight','cost_price','summary' , 'product_type','product_details','sales_number'];

    /**
     * 一对多关联products_sku表
     */
    public function productsSku()
    {
        return $this->hasMany('App\Models\ProductsSkuModel','product_id');
    }
    
    /**
     * 获取所属的供应商
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function supplier()
    {
        return $this->belongsTo('App\Models\SupplierModel', 'supplier_id');
    }
    
    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','cover_id');
    }
    /**
     * 一对多关联assets表商品详情介绍图
     */
    public function assetsProductDetails()
    {
        return $this->belongsTo('App\Models\AssetsModel','product_details');
    }

    /**
     * 一对多关联StorageSkuCount表
     */
    public function StorageSkuCount()
    {
        return $this->hasMany('App\Models\StorageSkuCountModel','product_id');
    }

    /**
     * 一对多关联订单明细表
     */
    public function OrderSku()
    {
        return $this->hasMany('App\Models\OrderSkuRelationModel','product_id');
    }

    /**
     * 一对多关联material_libraries 表
     */
    public function MaterialLibraries()
    {
        return $this->hasMany('App\Models\MaterialLibrariesModel','product_number','number');

    }

    /**
     * 一对多关联ProductUserRelation 表
     */
    public function ProductUserRelation()
    {
        return $this->hasMany('App\Models\ProductUserRelation','product_id');

    }

    // 一对多相对关联 分类表
    public function CategoriesModel()
    {
        return $this->belongsTo('App\Models\CategoriesModel', 'category_id');
    }
    /**
     * 一对多关联article_models 表
     */
    public function ArticleModels()
    {
        return $this->hasMany('App\Models\ArticleModel','product_number','number');

    }

    /**
     * 增加库存
     * @param $product
     * @param array $sku
     * @return bool
     */
    public function addInventory($product,array $sku){
        $sum = 0;
        foreach ($sku as $key=>$value){
            if($skuModel = ProductsSkuModel::find($key)){
                $skuModel->count = $skuModel->count + (int)$value;
                if(!$skuModel->save()){
                    return false;
                }
            }else{
                return false;
            }
            $sum += (int)$value;
        }
        if(!$productModel = self::find($product)){
            return false;
        }
        $productModel->count = $productModel->count + $sum;
        if(!$productModel->save()){
            return false;
        }
        return true;
    }

    /**
     * 更改商品状态
     * @param int $status 1|2|3
     */
    public function changeProduct($status)
    {
        if(!in_array($status, [1,2,3])){
            return false;
        }
        $this->status = $status;

        if(!$this->save()){
            return false;
        }

        return true;
    }

    /**
     * 待上架商品数量
     * 
     * @return mixed
     */
    public static function verifyProductCount()
    {
        return ProductsModel::where('status',1)->count();
    }

    /**
     * 获取商品封面图
     */
    public function getFirstImgAttribute()
    {
//        $asset = AssetsModel
//            ::where(['target_id' => $this->id, 'type' => 1])
//            ->orderBy('id','desc')
//            ->first();
//        if(empty($asset)){
//            return url('images/default/erp_product.png');
//        }
        $result = $this->imageFile();
        if(is_object($result)){
            return $result->small;
        }
        return $result;
    }

    /**
     * 商品详情介绍大图
     */
    public function getDetialImgAttribute()
    {
        $result = $this->getProductDetailAttribute();
        if(is_object($result)){
            return $result->small;
        }
        return $result;
    }
    /**
     * 商品中图
     */
    public function getMiddleImgAttribute()
    {
        $result = $this->imageFile();
        if(is_object($result)){
            return $result->p500;
        }
        return $result;
    }

    /**
     * 商品大图
     */
    public function getBigImgAttribute()
    {
        $result = $this->imageFile();
        if(is_object($result)){
            return $result->p500;
        }
        return $result;
    }

    /**
     * 分发saas 商品信息返回图片
     */
    public function getSaasImgAttribute()
    {
        $result = $this->imageFile();
        if(is_object($result)){
            return $result->p500;
        }
        return url('images/default/erp_product1.png');
    }

    /**
     * 获取商品图片信息对象
     */
    public function imageFile()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 1])
            ->orderBy('id','desc')
            ->first();
        if(empty($asset)){
            return url('images/default/erp_product.png');
        }
        return $asset->file;
    }


    /**
     * 获取商品详情图片
     */
    public function getProductDetailAttribute()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 22])
            ->orderBy('id', 'desc')
            ->first();
        if (empty($asset)) {
            return url('images/default/erp_product1.png');
        }

        return $asset->file;
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj)
        {
            RecordsModel::addRecord($obj, 1, 13);
        });

        self::deleted(function ($obj)
        {
            RecordsModel::addRecord($obj, 3, 13);
        });

        self::updated(function ($obj)
        {
            $remark = $obj->getDirty();
            RecordsModel::addRecord($obj, 2, 13,$remark);
        });
    }


    /**
     * 更改商品开发状态
     */
    static public function saasType($id, $saasType=1)
    {
        $product = self::findOrFail($id);
        $product->saas_type = $saasType;
        return $product->save();
    }

    /**
     * 获取SaaS公开的商品及下属sku信息
     *
     * @param $user_id
     * @return array
     */
//    public function saasProductInfo($user_id)
//    {
//        $all = [];
//        $skus = $this->productsSku;
//        foreach ($skus as $sku){
//            $all[] = [
//                'sku_id' => $sku->id,
//                'number' => $sku->number,
//                'mode' => $sku->mode,
//                'price' => $sku->cost_price,
//                'image' => $sku->saas_img,
//                'inventory' => $sku->quantity,
//            ];
//        }
//
//        return [
//            'id' => $this->id,
//            'product_id' => $this->id,
//            'number' => $this->number,
//            'category' => $this->CategoriesModel ? $this->CategoriesModel->title : '',
//            'name' => $this->title,
//            'short_name' => $this->tit,
//            'price' => $this->cost_price,
//            'weight' => $this->weight,
//            'summary' => $this->summary,
//            'inventory' => $this->inventory,
//            'image' => $this->saas_img,
//            'status' => $this->isCooperation($user_id), //是否合作
//            'skus' => $all,
//            'slaes_number' => $this->slaes_number,
//        ];
//    }

    /**
     * 获取SaaS公开的商品列表展示信息
     *
     * @param $user_id
     * @return array
     */
//    public function saasProductListInfo($user_id)
//    {
//        return [
//            'id' => $this->id,
//            'product_id' => $this->id,
//            'number' => $this->number,
//            'category' => $this->CategoriesModel ? $this->CategoriesModel->title : '',
//            'name' => $this->title,
//            'short_name' => $this->tit,
//            'price' => $this->cost_price,
//            'weight' => $this->weight,
//            'summary' => $this->summary,
//            'inventory' => $this->inventory,
//            'image' => $this->saas_img,
//            'status' => $this->isCooperation($user_id), //是否合作
//        ];
//    }

    // 判断SaaS开放商品是否与请求的用户合作
    public function isCooperation($user_id)
    {
        return (int)CooperationRelation::isCooperation($user_id, $this->id);
    }

    // fiu 基础商品信息扩展信息
    public function saasInfo()
    {
        $saas_product = ProductUserRelation::where(['product_id' => $this->id, 'user_id' => 0])->first();
        if(!$saas_product){
            return null;
        }else{
            return $saas_product;
        }
    }
}
