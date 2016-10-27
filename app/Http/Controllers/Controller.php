<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * 默认页数
     */
    public $page = 1;
    
    /**
     * 默认每页数量
     */
    public $per_page = 10;
    
    /**
     * 子菜单状态
     */
    public $tab_menu = 'default';
    
}
