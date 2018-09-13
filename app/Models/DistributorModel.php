<?php

namespace App\Models;
//经销商表
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistributorModel extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * 关联模型到数据表
     * @var string
     */
    protected $table = 'distributor';

    /**
     * 可被批量赋值的属性。
     *
     * @var array
     */

    protected $fillable = ['front_id','Inside_id','portrait_id','national_emblem_id','number','phone', 'store_name', 'name', 'operation_situation', 'bank_number', 'cover_id', 'bank_name','business_license_number','taxpayer','area_id','province_id','authorization_id','city_id','county_id','status','category_id','user_id','position','full_name','legal_person','legal_phone','legal_number','ein','enter_phone','enter_province','enter_city','enter_county'];


    //一对一关联附件表门店正面照片
    public function assetsFront()
    {
        return $this->belongsTo('App\Models\AssetsModel','front_id');
    }
    //一对一关联附件表门店内部照片
    public function assetsInside()
    {
        return $this->belongsTo('App\Models\AssetsModel','Inside_id');
    }
    //一对一关联附件表身份证人像面照片
    public function assetsPortrait()
    {
        return $this->belongsTo('App\Models\AssetsModel','portrait_id');
    }
    //一对一关联附件表身份证国徽面照片
    public function assetsNationalEmblem()
    {
        return $this->belongsTo('App\Models\AssetsModel','national_emblem_id');
    }
    //一对一关联附件表电子版合同照片
    public function assetsContract()
    {
        return $this->belongsTo('App\Models\AssetsModel','contract_id');
    }

    //相对关联user表
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }


    /**
     * 一对多关联分类表
     */

    public function CategoriesModel()
    {
        return $this->belongsTo('App\Models\CategoriesModel', 'category_id');
    }

    /**
     * 获取门店正面照片
     */
    public function getFirstFrontAttribute()
    {
        $asset = AssetsModel
            ::find($this->front_id);
//            ::where(['target_id' => $this->id, 'type' => 17])
//            ->orderBy('id','desc')
//            ->first();

        if($asset){
            return $asset->file->p500;
        }else{
            return '';
        }
    }

    /**
     * 获取门店内部照片
     */
    public function getFirstInsideAttribute()
    {
        $asset = AssetsModel
            ::find($this->Inside_id);
//            ::where(['target_id' => $this->id, 'type' => 18])
//            ->orderBy('id','desc')
//            ->first();
        if($asset){
            return $asset->file->p500;
        }else{
            return '';
        }
    }
    /**
     * 获取电子版合同照片
     */
    public function getFirstContractAttribute()
    {
        $asset = AssetsModel
            ::find($this->contract_id);
//            ::where(['target_id' => $this->id, 'type' => 19])
//            ->orderBy('id','desc')
//            ->first();
        if($asset){
            return $asset->file->small;
        }else{
            return '';
        }
    }

    /**
     * 获取身份证人像面照片
     */
    public function getFirstPortraitAttribute()
    {
        $asset = AssetsModel
            ::find($this->portrait_id);
//            ::where(['target_id' => $this->id, 'type' => 20])
//            ->orderBy('id','desc')
//            ->first();
        if($asset){
            return $asset->file->p500;
        }else{
            return '';
        }
    }

    /**
     * 获取身份证国徽面照片
     */
    public function getFirstNationalEmblemAttribute()
    {
        $asset = AssetsModel
            ::find($this->national_emblem_id);
//            ::where(['target_id' => $this->id, 'type' => 21])
//            ->orderBy('id','desc')
//            ->first();
        if($asset){
            return $asset->file->p500;
        }else{
            return '';
        }
    }

    /**
     * 经销商审核
     */
    public function verify($id)
    {
        $model = DistributorModel::find($id);
        $model->status = 2;
        if(!$model->save()){
            return false;
        }

        return true;
    }

    /**经销商关闭使用
     * @param $id
     * @return bool
     */
    public function close($id)
    {
        $model = self::find($id);
        $model->status = 3;
        if(!$model->save()){
            return false;
        }

        return true;
    }







}
