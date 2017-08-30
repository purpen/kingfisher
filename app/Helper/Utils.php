<?php
/**
 * 系统常用工具类
 *
 * @author purpen
 */
namespace App\Helper;

use App\Models\AssetsModel;
use App\Helper\QiniuApi;
use App\Models\ArticleModel;
use YuanChao\Editor\EndaEditor;
use Zipper;

class Utils
{
    /**
     * 自营店铺发票信息拼接
     *
     * @param $invoice_caty
     * @param $invoice_title
     * @param $invoice_content
     * @return string
     */
    static public function invoice($invoice_caty, $invoice_title, $invoice_content)
    {
        switch ($invoice_caty) {
            case 1:
                $invoice_caty = '个人';
                break;
            case 2:
                $invoice_caty = '单位';
                break;
            default:
                $invoice_caty = '';
        }

        switch ($invoice_content) {
            case 'd':
                $invoice_content = '购买明细';
                break;
            case 'o':
                $invoice_content = '办公用品';
                break;
            case 's':
                $invoice_content = '数码配件';
                break;
            default:
                $invoice_content = '';
        }

        $str = '发票类型:' . $invoice_caty . '，' . '发票抬头：' . $invoice_title . '，' . '内容:' . $invoice_content . '。';
        
        return $str;
    }

    /**
     * 文章素材生成zip压缩包
     *
     * @param $invoice_caty
     * @param $invoice_title
     * @param $invoice_content
     * @return string
     */
    static public function genArticleZip($articleId, $options=array())
    {
        $id = (int)$articleId;
        $userId = isset($options['user_id']) ? $options['user_id'] : 0;
        $result = array();
        $result['success'] = false;
        $result['message'] = '';
        if(!$id){
            $result['message'] = '缺少请求参数';
            return $result;
        }

        // 删除原有附件
        $asset = AssetsModel::where(array('target_id'=>$id, 'type'=>11))->first();
        if ($asset) {
            // 删除原有附件
            AssetsModel::destroy($asset->id);
        }
        $article = ArticleModel::where(['id' => $id])->first();
        if(!$article){
            $result['message'] = '内容不存在';
            return $result;
        }
        $html = EndaEditor::MarkDecode($article->content);
        $preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
        preg_match_all($preg, $html, $imgArr);

        // 创建压缩包
        $tmpPath = config('app.tmp_path');
        $fileName = $article->title.'.zip';
        $fileUrl = $tmpPath.$fileName;
        $domain = 'article_pack';
        Zipper::make($fileUrl)->addString('content.txt', strip_tags($html));
        if(!empty($imgArr) && !empty($imgArr[1])){
            foreach($imgArr[1] as $k => $v){
                // 获取后缀
                $params = parse_url($v);
                preg_match_all('/ext=(jpg|jpeg|png|gif|bmp)/i', $v, $paramArr);
                if($paramArr && !empty($paramArr[1])){
                    $ext = $paramArr[1][0];
                }else{
                    $ext = 'jpg';
                }
                $downloadFile = file_get_contents($v);
                Zipper::make($fileUrl)->folder('images')->addString(($k+1).'.'.$ext, $downloadFile);
            }         
        }
        Zipper::close();

        // 上传七牛
        $qiniuParam = array(
          'bucket_type' => 2,
          'domain' => $domain,
        );
        $qiniuResult = QiniuApi::uploadFile($fileUrl, $qiniuParam);
        if(!$qiniuResult['success']) {
            unlink($fileUrl);
            $result['message'] = $qiniuResult['message'];
            return $result;
        }

        $path = $qiniuResult['data']['path'];
        $size = filesize($fileUrl);
        $mime = mime_content_type($fileUrl);

        // 删除临时文件
        unlink($fileUrl);

        $row = array(
          'user_id' => $userId,
          'name' => $fileName,
          'size' => $size,
          'mime' => $mime,
          'domain' => $domain,
          'type' => 11,
          'target_id' => $id,
          'path' => $path,
        );

        if($asset = AssetsModel::create($row)){
            $assetId = $asset->id;
            $downUrl = config('qiniu.material_url').$asset->path.'?attname='.$id.'.zip';
            $result['success'] = true;
            $result['data'] = array('asset_id'=> $assetId, 'url' => $downUrl);
            return $result;
        }else{
            $result['message'] = '创建附件表失败';
            return $result;
        }
    }
    
}
