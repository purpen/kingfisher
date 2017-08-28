<?php
/**
 * 七牛云上传服务配置
 */

return [
    /**
     * 生产环境上传地址
     */
    'upload_url' => env('QINIU_UPLOAD_URL', 'https://up.qbox.me'),

    'access_key' => 'AWTEpwVNmNcVjsIL-vS1hOabJ0NgIfNDzvTbDb4i',      //用户公钥
    'secret_key' => 'F_g7diVuv1X4elNctf3o3bNjhEAe5MR3hoCk7bY6',     //私钥
    'bucket_name' => 'frking',
    'call_back_url' => env('QINIU_CALL_BACK_URL', 'https://erp.taihuoniao.com/asset/callback'),  //服务器回调url
    'domain' => 'erp',                                              //存储域
    'url' => env('QINIU_URL', 'https://kg.erp.taihuoniao.com/'),                    //图片服务器
    'small' => '-sm',              //缩略图

    'material_call_back_url' => 'http://k.taihuoniao.com/material/callback',  //测试服务器回调url
    'material_persistent_url' => 'http://k.taihuoniao.com/material/qiniuNotify',
    'material_upload_url' => 'http://up-z1.qiniu.com',
    'material_bucket_name' => 'frmaterial', // 存储素材的空间
    'material_url' => 'http://orrrmkk87.bkt.clouddn.com/', // 存储素材的图片服务器
    'saas_domain' => 'saas_erp',                                              //存储域
];
