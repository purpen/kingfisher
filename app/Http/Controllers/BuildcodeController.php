<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// 引用class文件夹对应的类
require_once(dirname(__FILE__) . '/../../Libraries/Barcodegen/class/BCGFontFile.php');
require_once(dirname(__FILE__) . '/../../Libraries/Barcodegen/class/BCGColor.php');
require_once(dirname(__FILE__) . '/../../Libraries/Barcodegen/class/BCGDrawing.php'); 

class BuildcodeController extends Controller
{
    // 字体格式
    protected $font;
    
    /**
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        // 加载字体大小
        $this->font = new \BCGFontFile(dirname(__FILE__) . '/../../Libraries/Barcodegen/font/Arial.ttf', 18);
    }
    
    /**
     * 生成器
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $codebar = $request->input('codebar', 'BCGcode39');
        $codetext = $request->input('codetext', 'Taihuoniao404');
        
        // 条形码的编码格式  
        require_once(dirname(__FILE__) . '/../../Libraries/Barcodegen/class/'.$codebar.'.barcode.php'); 
        
        // 颜色条形码  
        $color_black = new \BCGColor(0, 0, 0);  
        $color_white = new \BCGColor(255, 255, 255);  
 
        $drawException = null;
        try {  
            $code = new $codebar();  
            $code->setScale(2);  
            $code->setThickness(30); // 条形码的厚度  
            $code->setForegroundColor($color_black); // 条形码颜色  
            $code->setBackgroundColor($color_white); // 空白间隙颜色  
            $code->setFont($this->font);  
            $code->parse($codetext); // 条形码需要的数据内容  
        } catch(Exception $exception) {  
            $drawException = $exception;
        }
        
        // 根据以上条件绘制条形码  
        $drawing = new \BCGDrawing('', $color_white);  
        if ($drawException) {  
            $drawing->drawException($drawException);  
        } else {  
            $drawing->setBarcode($code);  
            $drawing->draw();  
        }
        
        // 生成PNG格式的图片  
        header('Content-Type: image/png');  
        
        $drawing->finish(\BCGDrawing::IMG_FORMAT_PNG);
    }
    
}
