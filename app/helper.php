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
