<?php
/**
 * 系统常用工具类
 *
 * @author purpen
 */
namespace App\Helper;

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
    
}