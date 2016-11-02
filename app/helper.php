<?php

    /**
     * Author: caowei<caoyuanlianni@foxmail.com>
     * Time: 2016.05.22
     * Use: 自定义函数库
     * Load: composer.json->"app/helper.php"
     */
    
    if (!function_exists('my_test'))
    {
        /**
        * 自定义测试函数
        * @author caowei<caoyuanlianni@foxmail.com>
        * @param  null
        * @return string
        */
        function my_test()
        {
            return 'It is ok!';
        }
    }
    
    if (!function_exists('ajax_json'))
    {
        /**
        * ajax返回信息
        * @author caowei<caoyuanlianni@foxmail.com>
        * @param  int 返回状态 1为成功, 0为失败
        * @param  string 错误信息
        * @param  array 响应信息
        * @return string json
        */
        function ajax_json($status = 0, $message = '', $data = [])
        {
            $result = array(
                'status' => $status,
                'message' => $message,
                'data' => $data
            );
            return json_encode($result);
        }
    }
    
    if (!function_exists('arrayToObject'))
    {
        /**
        * 数组转化成对象
        * @author caowei<caoyuanlianni@foxmail.com>
        * @param  array $e
        * @return object
        */
        function arrayToObject($e)
        {
            if( gettype($e)!='array' ) return;
            foreach($e as $k=>$v){
                if( gettype($v)=='array' || getType($v)=='object' )
                    $e[$k]=(object)arrayToObject($v);
            }
            return (object)$e;
        }
    }
    
    if (!function_exists('objectToArray'))
    {
        /**
        * 对象转化成数组
        * @author caowei<caoyuanlianni@foxmail.com>
        * @param  object $e
        * @return array
        */
        function objectToArray($e){
            $e=(array)$e;
            foreach($e as $k=>$v){
                if( gettype($v)=='resource' ) return;
                if( gettype($v)=='object' || gettype($v)=='array' )
                    $e[$k]=(array)objectToArray($v);
            }
            return $e;
        }
    }

    /**
     * 生成11位数字
     */
    if(!function_exists('getNumber'))
    {
        function getNumber($prefix=1)
        {
            $sku  = $prefix;
            $sku .= date('ymd');
            $sku .= sprintf("%04d", rand(1,9999));
            return $sku;
        }
    }
   