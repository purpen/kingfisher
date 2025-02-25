<?php
/**
 * 商品的SKU
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductsSkuModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     *   id
     *   product_id
     *   product_number
     *   number
     *   mode
     *   bid_price
     *   cost_price
     *   price
     *   weight
     *   quantity
     *   user_id
     *   min_count
     *   max_count
     *   storage_place_id
     *   cover_id
     *   status
     *   summary
     *   unique_number
     *   created_at,updated_at
     * @var string
     */
    protected $table = 'products_sku';

    /**
     * 相对关联到product表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Models\ProductsModel', 'product_id');
    }

    /**
     * 一对多关联StorageSkuCount表
     */
    public function StorageSkuCount()
    {
        return $this->hasMany('App\Models\StorageSkuCountModel', 'sku_id');
    }

    /**
     * 一对多关联assets表单
     */
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel', 'cover_id');
    }

    /**
     * sku一对多关联采购单明细
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseSkuRelationModel()
    {
        return $this->hasMany('App\Models\PurchaseSkuRelationModel', 'sku_id');
    }

    /**
     *
     * 一对多关联库存表
     *
     */
    public function storageSkuCounts()
    {
        return $this->hasMany('App\Models\StorageSkuCountModel', 'sku_id');
    }

    /**
     * 一对多关联采购退货单明细表
     */
    public function returnedSku()
    {
        return $this->hasMany('App\Models\ReturnedSkuRelationModel', 'sku_id');
    }

    /**
     * 一对多关联调拨单明细表
     */
    public function changeWarehouseSku()
    {
        return $this->hasMany('App\Models\ChangeWarehouseSkuRelationModel', 'sku_id');
    }

    /**
     * sku一对多关联订单明细
     */
    public function OrderSku()
    {
        return $this->hasMany('App\Models\OrderSkuRelationModel', 'sku_id');
    }

    /**
     * sku 一对多关联 分销商-SKU关联标 ProductSkuRelation
     */
    public function ProductSkuRelation()
    {
        return $this->hasMany('App\Models\ProductSkuRelation', 'sku_id');
    }

    /**
     * 一对多关联sku_region 商品价格区间表
     */
    public function SkuRegion()
    {
        return $this->hasMany('App\Models\SkuRegionModel', 'sku_id');
    }

    /**
     * SKU封面图为空时,获取商品图
     */
    public function getFirstProductsImgAttribute()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 4])
            ->orderBy('id', 'desc')
            ->first();
        if (empty($asset)) {
            $result = AssetsModel::where(['target_id' => $this->product_id, 'type' => 1])
                ->orderBy('id', 'desc')
                ->first();

            return $result->file->p500;
        }

        return $asset->file->small;
    }

    /**
     * 获取SKU封面图
     */
    public function getFirstImgAttribute()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 4])
            ->orderBy('id', 'desc')
            ->first();
        if (empty($asset)) {
            return url('images/default/erp_product.png');
        }
        return $asset->file->small;
    }


    /**
     * 分发saas sku信息返回图片
     */
    public function getSaasImgAttribute()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 4])
            ->orderBy('id', 'desc')
            ->first();
        if (empty($asset)) {
            return url('images/default/erp_product1.png');
        }

        return $asset->file->p500;
    }

    //获取sku可售库存
    public function getCountNumAttribute()
    {
        $sell_count = $this->quantity - $this->reserve_count - $this->pay_count;

        return $sell_count;
    }


    /**
     *sku列表
     * @param $where <模糊搜索查询参数>
     * @param $supplier_id <供应商id>
     * @return mixed
     */
    public function listOf($where = null)
    {
        if ($where) {
          $skus = self
              ::where('number', 'like', "%$where%")
              ->where('status', '!=', 3)
              ->get();
          if ($skus->isEmpty()) {
              $skus_id = ProductsModel
                  ::where('status', '!=', 3)
                  ->where('title', 'like', "%$where%")
                  ->get()->pluck('id')->all();
                if ($skus) {
                    $skus = ProductsSkuModel
                        ::whereIn('product_id', $skus_id)
                        ->get();
                }
            }
        } else {
            $id_array = ProductsModel
                ::where('status', '!=', 3)->select('id')
                ->get()
                ->pluck('id')->all();
            $skus = ProductsSkuModel::whereIn('product_id', $id_array)->get();
        }
        foreach ($skus as $sku) {
            if ($sku->assets) {
                $sku->path = $sku->assets->file->small;
            } else {
                $sku->path = url('images/default/erp_product.png');
            }
            if ($sku->product) {
                $sku->name = $sku->product->title;
                $sku->sale_price = $sku->product->sale_price;
            }

        }
        return $skus;
    }

    /**
     *sku列表
     * @param $where <模糊搜索查询参数>
     * @param $supplier_id <供应商id>
     * @return mixed
     */
    public function lists($where = null, $supplier_id = null)
    {
        if ($where && $supplier_id) {
            $id_array = ProductsModel
                ::where('supplier_id', '=', $supplier_id)
                ->where('status', '!=', 3)->select('id')
                ->get()
                ->pluck('id')->all();
            $skus = ProductsSkuModel::whereIn('product_id', $id_array)->where('number', 'like', "%$where%")->get();
        } else if ($where) {
            $skus = self
                ::where('number', 'like', "%$where%")
                ->where('status', '!=', 3)
                ->get();
            if ($skus->isEmpty()) {
                $skus_id = ProductsModel
                    ::where('status', '!=', 3)
                    ->where('supplier_id', '=', $supplier_id)
                    ->where('title', 'like', "%$where%")
                    ->get()->pluck('id')->all();
                if ($skus) {
                    $skus = ProductsSkuModel
                        ::whereIn('product_id', $skus_id)
                        ->get();
                }
            }
        } else {
            $id_array = ProductsModel
                ::where('supplier_id', '=', $supplier_id)
                ->where('status', '!=', 3)->select('id')
                ->get()
                ->pluck('id')->all();
            $skus = ProductsSkuModel::whereIn('product_id', $id_array)->get();
        }
        foreach ($skus as $sku) {
            if ($sku->assets) {
                $sku->path = $sku->assets->file->small;
            } else {
                $sku->path = url('images/default/erp_product.png');
            }
            if ($sku->product) {
                $sku->name = $sku->product->title;
                $sku->sale_price = $sku->product->sale_price;
            }

        }
        return $skus;
    }

    /**
     * 为含有sku_id的数组对象添加该sku的详细信息2
     * @param  $purchase_sku_relation
     * @return array
     */
    public function detailedSuks($purchase_sku_relation)
    {
        foreach ($purchase_sku_relation as $k => $purchase_sku) {
            if (!$sku = ProductsSkuModel::find($purchase_sku->sku_id)) {
                return $purchase_sku_relation;
            };
            $purchase_sku_relation[$k]['product_number'] = $sku->product['number'];
            $purchase_sku_relation[$k]->number = $sku->number;
            $purchase_sku_relation[$k]->name = $sku->product['title'];
            $purchase_sku_relation[$k]->mode = $sku->mode;
            $purchase_sku_relation[$k]->sku_price = $sku->price;
            $purchase_sku_relation[$k]->sale_price = $sku->product['sale_price'];

            if ($sku->assets) {
                $purchase_sku_relation[$k]->path = $sku->assets->file->small;
            } else {
                $purchase_sku_relation[$k]->path = url('images/default/erp_product.png');
            }
        }
        return $purchase_sku_relation;
    }

    /**
     * 为含有sku_id的数组对象添加该sku的详细信息
     * @param  $purchase_sku_relation
     * @return array
     */
    public function detailedSku($purchase_sku_relation)
    {
        foreach ($purchase_sku_relation as $purchase_sku) {
            if (!$sku = ProductsSkuModel::find($purchase_sku->sku_id)) {
                return $purchase_sku_relation;
            };
            $purchase_sku->product_number = $sku->product->number;
            $purchase_sku->number = $sku->number;
            $purchase_sku->name = $sku->product->title;
            $purchase_sku->mode = $sku->mode;
            $purchase_sku->sku_price = $sku->price;
            $purchase_sku->sale_price = $sku->product->sale_price;
            if ($sku->assets) {
                $purchase_sku->path = $sku->assets->file->small;
            } else {
                $purchase_sku->path = url('images/default/erp_product.png');
            }
        }
        return $purchase_sku_relation;
    }

    /**
     * 增加sku总库存
     *
     * @param int $id sku_id
     * @param int $number 增加数量
     * @return bool
     */
    public function addInventory($id, $number)
    {
        if (!$skuModel = self::find($id)) {
            return false;
        } else {
            $skuModel->quantity = $skuModel->quantity + (int)$number;
            if (!$skuModel->save()) {
                return false;
            }
            $productModel = $skuModel->product;
            $productModel->inventory = $productModel->inventory + (int)$number;
            if (!$productModel->save()) {
                return false;
            }
        }
        return true;
    }

    /**
     * 减少sku库存
     *
     * @param $id
     * @param $number
     * @return bool
     */
    public function reduceInventory($id, $number)
    {
        if (!$skuModel = self::find($id)) {
            return false;
        } else {
            $skuModel->quantity = $skuModel->quantity - (int)$number;
            if (!$skuModel->save()) {
                return false;
            }
            $productModel = $skuModel->product;
            $productModel->inventory = $productModel->inventory - (int)$number;
            if (!$productModel->save()) {
                return false;
            }
        }
        return true;
    }

    /**
     * 增加 付款订单占货
     *
     * @param int $id sku_id
     * @param int $number 数量
     * @return bool
     */
    public function increasePayCount($id, $number)
    {
        if (!$sku_model = self::find($id)) {
            return false;
        }
        $sku_model->pay_count += (int)$number;
        if (!$sku_model->save()) {
            return false;
        }

        return true;
    }

    /**
     * 减少 付款订单占货
     *
     * @param integer $id sku_id
     * @param integer $number 数量
     * @return bool
     */
    public function decreasePayCount($id, $number)
    {
        if (!$sku_model = self::find($id)) {
            return false;
        }
        $sku_model->pay_count = $sku_model->pay_count - (int)$number;
        if (!$sku_model->save()) {
            return false;
        }

        return true;
    }


    /**
     * 增加 待付款订单占货
     *
     * @param integer $id sku_id
     * @param integer $number 数量
     * @return bool
     */
    public function increaseReserveCount($id, $number)
    {
        if (!$sku_model = self::find($id)) {
            return false;
        }
        $sku_model->reserve_count += (int)$number;
        if (!$sku_model->save()) {
            return false;
        }

        return true;
    }

    /**
     * 减少 待付款订单占货
     *
     * @param integer $id sku_id
     * @param integer $number 数量
     * @return bool
     */
    public function decreaseReserveCount($id, $number)
    {
        if (!$sku_model = self::find($id)) {
            return false;
        }
        $sku_model->reserve_count = $sku_model->reserve_count - (int)$number;
        if (!$sku_model->save()) {
            return false;
        }

        return true;
    }

    /**
     * sku可售库存
     *
     * @param $sku_id
     * @return bool
     */
    public function sellCount($sku_id)
    {
        if (!$sku_model = self::find($sku_id)) {
            return false;
        }
        $sell_count = $sku_model->quantity - $sku_model->reserve_count - $sku_model->pay_count;

        return $sell_count;
    }

    /**
     * 删除付款待审核订单，减少仓库付款占货
     * @param $order_id
     * @return bool
     */
    public function orderDecreasePayCount($order_id)
    {
        $order_id = (int)$order_id;
        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();
        if (!$order_sku) {
            return false;
        }
        foreach ($order_sku as $sku) {
            if (!$this->decreasePayCount($sku->sku_id, $sku->quantity)) {
                return false;
            };
        }
        return true;
    }

    /**
     * 删除待付款待订单 或 订单付款时，减少仓库拍下占货数量
     * @param $order_id
     * @return bool
     */
    public function orderDecreaseReserveCount($order_id)
    {
        $order_id = (int)$order_id;
        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();
        if (!$order_sku) {
            return false;
        }
        foreach ($order_sku as $sku) {
            if (!$this->decreaseReserveCount($sku->sku_id, $sku->quantity)) {
                return false;
            };
        }
        return true;
    }

    /**
     * 订单付款时，增加仓库付款占货数量
     * @param $order_id
     * @return bool
     */
    public function orderIncreasePayCount($order_id)
    {
        $order_id = (int)$order_id;
        $order_sku = OrderSkuRelationModel::where('order_id', $order_id)->get();
        if (!$order_sku) {
            return false;
        }
        foreach ($order_sku as $sku) {
            if (!$this->increasePayCount($sku->sku_id, $sku->quantity)) {
                return false;
            };
        }
        return true;
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($obj) {
            RecordsModel::addRecord($obj, 1, 14);
        });

        self::deleted(function ($obj) {
            RecordsModel::addRecord($obj, 3, 14);
        });

        self::updated(function ($obj) {
            $remark = $obj->getDirty();
            RecordsModel::addRecord($obj, 2, 14, $remark);
        });
    }

    // 获取分发SaaS中 sku扩展信息对象实例
    public function saasSkuInfo()
    {
        $saas_sku = ProductSkuRelation::where(['sku_id' => $this->id, 'user_id' => 0])->first();
        if (!$saas_sku) {
            return null;
        } else {
            return $saas_sku;
        }
    }

    /**
     * 微商城 sku信息返回图片
     */
    public function getMicroImgAttribute()
    {
        $asset = AssetsModel
            ::where(['target_id' => $this->id, 'type' => 4])
            ->orderBy('id', 'desc')
            ->first();
        if (empty($asset)) {
            return '';
        }

        return $asset->file->p500;
    }
}


