<?php
/**
 * 供应商信息
 */
namespace App\Models;

use App\Http\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierModel extends BaseModel
{
    use SoftDeletes;

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'suppliers';

    //软删除属性
    protected $dates = ['deleted_at'];
    
    /**
     * 允许批量赋值的字段
     */
    protected  $fillable = ['name','address','legal_person','tel','ein','bank_number','bank_address','general_taxpayer','contact_user','contact_number','contact_email','contact_qq','contact_wx','summary','cover_id','discount','tax_rate','type','nam','start_time','end_time','relation_user_id' , 'random_id','msg','status'];

    //供应商列表
    public function lists(){
        $suppliers = self::where('status',2)->select('id','name','nam')->get();
        return $suppliers;
    }

    /**
     * 商品分类一对多远程关联sku
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     *
     */
    public function productsSku(){
        return $this->hasManyThrough('App\Models\ProductsSkuModel', 'App\Models\ProductsModel','supplier_id','product_id');
    }

    //一对多关联采购订单
    public function purchases(){
        return $this->hasMany('App\Models\PurchasesModel','supplier_id');
    }

    //一对多关联采购退货订单
    public function returned(){
        return $this->hasMany('App\Models\ReturnedPurchasesModel','supplier_id');
    }

    //一对一关联附件表
    public function assets()
    {
        return $this->belongsTo('App\Models\AssetsModel','cover_id');
    }

    //相对关联user表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    /**
     * 添加是否上传合作
     *
     * @return string 是|否
     */
    public function getAgreementsAttribute()
    {
        if(empty($this->cover_id)){
            return '否';
        }
        return '是';
    }

    /**
     * 关联人名称
     */
    public function getRelationUserNameAttribute()
    {
        $user = UserModel::find($this->relation_user_id);
        if($user){
            return $user->realname;
        }
        return '';
    }

    /**
     * 供应商审核
     */
    public function verify($id)
    {
        $model = SupplierModel::find($id);
        $model->status = 2;
        if(!$model->save()){
            return false;
        }

        return true;
    }

    /**
     * 审核通过供应商列表
     */
    public function supplierList()
    {
        $list = self::where('status', 2)->select('id', 'nam', 'name')->get();
        return $list;
    }
    
    /**
     * 供应商关闭使用
     * @param $id
     * @return bool
     */
    public function close($id)
    {
        $model = self::find($id);
//        var_dump($supplier_id_array);die;
        $model->status = 3;
        if(!$model->save()){
            return false;
        }

        return true;
    }

    /**
     * 待审核供应商数量
     */
    public static function verifySupplierCount()
    {
        return SupplierModel::where('status',1)->count();
    }

    /**
     * 供应商类型 访问修改器 1.采购 2.代销 3.代发
     *
     */
    public function getTypeValAttribute()
    {
        $val = '';
        switch ($this->type){
            case 1:
                $val = '采购';
                break;
            case 2:
                $val = '代销';
                break;
            case 3:
                $val = '代发';
                break;
        }
        return $val;
    }

    public static function boot(){
        parent::boot();
        self::created(function ($obj){
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 1, 5,$remark);
        });

        self::updated(function ($obj){
            $remark = $obj->getDirty();

            RecordsModel::addRecord($obj, 2, 5,$remark);
        });

        self::deleted(function ($obj){
            $remark = $obj->name;
            RecordsModel::addRecord($obj, 3, 5,$remark);
        });
    }



}
