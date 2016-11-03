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
    'call_back_url' => 'https://erp.taihuoniao.com/asset/callback',  //服务器回调url
    'domain' => 'erp',                                              //存储域
    'url' => 'http://ck.erp.taihuoniao.com',                    //图片服务器
    'small' => '-small.jpg'              //缩略图
];