<?php

    /**
     * Author: caowei<caoyuanlianni@foxmail.com>
     * Time: 2016.05.22
     * Use: 自定义函数库
     * Load: composer.json->"app/helper.php"
     */
    
    if (!function_exists('my_test')) {
        /**
        * 自定义测试函数
        * @author caowei<caoyuanlianni@foxmail.com>
        * @param  null
        * @return string
        */
        function my_test(){
            return 'It is ok!';
        }
    }
    
    if (!function_exists('ajax_json')) {
        /**
        * ajax返回信息
        * @author caowei<caoyuanlianni@foxmail.com>
        * @param  int 返回状态 1为成功, 0为失败
        * @param  string 错误信息
        * @param  array 响应信息
        * @return string json
        */
        function ajax_json($status = 0, $message = '', $data = []){
            $result = array(
                'status' => $status,
                'message' => $message,
                'data' => $data
            );
            return json_encode($result);
        }
    }
