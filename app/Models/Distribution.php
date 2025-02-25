<?php

namespace App\Models;
//分销商表
class Distribution extends BaseModel
{
    protected $table = 'distribution';

    protected $appends = [
        'document_type_value',
        'company_type_value',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'company',
        'introduction',
        'main',
        'create_time',
        'contact_name',
        'contact_phone',
        'contact_qq',
        'distribution',
        'company_type',
        'registration_number',
        'legal_person',
        'document_type',
        'document_number',
        'email',
        'status',
        'position',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id');
    }

    //证件类型
    public function getDocumentTypeValueAttribute()
    {
        $key = $this->attributes['document_type'];
        if(array_key_exists($key,config('constant.document_type'))){
            $document_type_val = config('constant.document_type')[$key];
            return $document_type_val;

        }
        return '';
    }

    //企业类型
    public function getCompanyTypeValueAttribute()
    {
        switch ($this->attributes['company_type']){
            case 1:
                $company_type_val = '普通';
                break;
            case 2:
                $company_type_val = '多证合一(不含信用代码)';
                break;
            case 3:
                $company_type_val = '多证合一(含信用代码)';
                break;
            default:
                $company_type_val = '';
        }
        return $company_type_val;
    }

    /**
     * 企业执照图片
     * @param $key
     */
    public function getLicenseImageAttribute()
    {
        $assets = AssetsModel
            ::where(['target_id' => $this->user->id, 'type' => 6])
            ->orderBy('id','desc')
            ->get();
        $data = [];
        foreach ($assets as $v){
            $data[] = $v->file;
        }

        return $data;
    }

    public function getDocumentImageAttribute()
    {
        $assets = AssetsModel
            ::where(['target_id' => $this->user->id, 'type' => 7])
            ->orderBy('id','desc')
            ->get();
        $data = [];
        foreach ($assets as $v){
            $data[] = $v->file;
        }

        return $data;
    }

}
