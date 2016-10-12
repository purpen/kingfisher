<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link rel="stylesheet" href="http://www.qysea.com/css/bootstrap.min.css">
        <style>
            body {
                margin: 0;
                padding: 0;
                font-weight: 100;
                font-family: 'Lato';
                background-color: #f3f3f3;
            }

            .container {
                text-align: center;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                margin: 20px auto;
                width: 100%;
            }
            
            #shoplist {
                width: 980px;
                margin: 20px auto;
                background-color: #fff;
                border: 5px solid #ccc;
            }
            #shoplist .table {
                width: 768px;
            }
            
            #start-printer {
                margin: 20px auto;
                padding: 10px 20px;
                border: 2px solid #333;
                text-align: center;
                font-weight: 600;
            }
            .title {
                font-size: 96px;
            }
        </style>
        <!-- JavaScripts -->
        <script src="{{ asset('/assets/js/jquery.js') }}"></script>
        <script src="{{ asset('/assets/Lodop/LodopFuncs.js') }}"></script>  
        <script>
            var LODOP; //声明为全局变量     
            function preview(){   
                CreateOneFormPage();  
                LODOP.PREVIEW();   
            };  
        	function startPrint() {		
        		CreateOneFormPage();
        		LODOP.PRINT();	
        	};
        	function manage() {	
        		CreateTwoFormPage();
        		LODOP.PRINT_SETUP();	
        	};
            
            function CreateOneFormPage() {  
                LODOP = getLodop();  
                LODOP.PRINT_INIT("打印控件功能演示_Lodop功能_表单一");  
                LODOP.SET_PRINT_STYLE("FontSize", 18);  
                LODOP.SET_PRINT_STYLE("Bold", 1);  
                LODOP.SET_PRINT_PAGESIZE(0, "1064", "200", "A4");//动态纸张  
                //LODOP.ADD_PRINT_TEXT(50, 231, 260, 39, "打印页面部分内容");  
                LODOP.ADD_PRINT_HTM(88, 200, 350, 600, document.getElementById("shoplist").innerHTML);  
            };
            
            $(function(){
                $('#perviewer').bind('click', function(){
                    preview();
                });
                
                $('#start-printer').bind('click', function(){
                    startPrint();
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div id="shoplist">
                    <table class="table">
                        <tr>
                            <td>
                                <img src="/images/logo.png" /> 
                            </td>
                            <td>
                                <center>显示条形码区域</center>
                                {{ $result['EBusinessID'] }}
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%;">  
                        <tr>  
                            <td colspan="3" style="height: 25px; text-align: center; font-weight: bold; font-size: 14px;">上海XX有限公司（上海旗舰店）</td>  
                        </tr>  
                        <tr>  
                            <td colspan="3" style="height: 25px; text-align: center; font-size: 14px;">定金单</td>  
                        </tr>  
                        <tr>  
                            <td style="width: 50%; height: 25px; font-size: 12px; text-align: left;" id="Print_CustomerInformation">客户:王某某    电话:13011112222    卡号:8021656090    渠道:1000000    到货通知:不通知</td>  
                            <td style="width: 10%; height: 25px;"></td>  
                            <td style="width: 40%; height: 25px; font-size: 12px; text-align: right;" id="Print_DateString">出货:14.10.10    开单:14.10.02    NO:535063</td>  
                        </tr>  
                        <tr>  
                            <td colspan="3" style="width: 100%; height: 25px; font-size: 12px;" id="Print_SendGoodsInformation">[寄货]123212  上海市上海市闸北区西藏北路9898号  （联系人：刘某某  13817489878）  
                            </td>  
                        </tr>  
                    </table>  
                    <table style="width: 100%; border: solid 1px black; border-collapse: collapse; table-layout: fixed; margin-top: 5px;" id="Print_OsaledInformation">  
                        <thead>  
                            <tr>  
                                <th style="width: 10%; font-size: 12px; text-align: center; border: 1px solid black;">条码<br />  
                                    单内ID  
                                </th>  
                                <th style="width: 15%; font-size: 12px; text-align: center; border: 1px solid black;">名称<br />  
                                    款号（镶口范围）  
                                </th>  
                                <th style="width: 10%; font-size: 12px; text-align: center; border: 1px solid black;">证书  
                                </th>  
                                <th style="width: 10%; font-size: 12px; text-align: center; border: 1px solid black;">重量  
                                </th>  
                                <th style="width: 15%; font-size: 12px; text-align: center; border: 1px solid black;">参数  
                                </th>  
                                <th style="width: 10%; font-size: 12px; text-align: center; border: 1px solid black;">原价<br />  
                                    成品价  
                                </th>  
                                <th style="width: 30%; font-size: 12px; text-align: center; border: 1px solid black;">单内备注  
                                </th>  
                            </tr>  
                        </thead>  
                        <tbody>  
                            <tr>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">00396097<br />  
                                    888852  
                                </td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">GIA  
                                </td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">GIA-17097234</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">0.6ct</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">VS1 G VG VG EX</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">19590<br />  
                                    19590</td>  
                                <td style="font-size: 12px; border: 1px solid black; word-wrap: break-word; padding-left: 4px;">保留裸钻 无内刻</td>  
                            </tr>  
                            <tr>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">26606188<br />  
                                    888853</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">铂900钻石对戒<br />  
                                    RB939</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">2014I1274123766</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">3.674 g 主:0.079ct*28</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">----</td>  
                                <td style="font-size: 12px; text-align: center; border: 1px solid black;">3250<br />  
                                    3250</td>  
                                <td style="font-size: 12px; border: 1px solid black; word-wrap: break-word; padding-left: 4px;">保留异调(成都-上海) 对戒 材质:铂900 手寸:11 无内刻 表面处理:抛光</td>  
                            </tr>  
                        </tbody>  
                        <tfoot>  
                            <tr>  
                                <td rowspan="1" colspan="7" style="font-size: 12px; height: 50px; border: 1px solid black;"></td>  
                            </tr>  
                            <tr>  
                                <td colspan="6" style="font-size: 12px; height: 30px; text-align: left; border: 1px solid black; padding-left: 20px;" id="Print_AmountName">实收金额(大写)：<b>伍佰零拾零元零角</b>（E1411-0000043  现金）</td>  
                                <td style="font-size: 12px; text-align: left; border: 1px solid black; padding-left: 20px;" id="Print_osaled_earnest">定金：500</td>  
                            </tr>  
                        </tfoot>  
                    </table>  
                    <table style="width: 100%; table-layout: fixed; margin-top: 20px;">  
                        <tr>  
                            <td style="width: 50%; height: 25px; font-size: 12px; text-align: left; font-weight: bold;">客户须知  
                                <ol>  
                                    <li>定金单作为取货的重要凭证，请您妥善保管，结单时请同时携带定单及身份证件。</li>  
                                    <li>非定制类商品订单有效期30天，即于定金单显示的出货日期30天内结单，定制类商品（刻  
                                        字属于定制类商品）订单有效期60天,即于定金单显示的出货日期60天内结单,如客户未能  
                                        按时结单，则视为合同自动解除,XXXX所收定金将视为违约金,不予返还  
                                    </li>  
                                    <li>如过出货日期仍未收到我们的到货通知，请尽快联系我们的客服中心，查询定单具体情况。  
                                    </li>  
                                </ol>  
                            </td>  
                            <td style="width: 10%; height: 25px;"></td>  
                            <td style="width: 40%; height: 25px; font-size: 12px; text-align: center; vertical-align: middle;">上海旗舰店：南京东路XXX号XX广场8层 (九江路XXX号侧门电梯直达)<br />  
                                客服电话：400-880-00XX<br />  
                                专业XX网站：www.XX.com  
                            </td>  
                        </tr>  
                    </table>  
                    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">  
                        <tr>  
                            <td style="font-size: 12px; text-align: left;">营业员：0000    收银员：0096</td>  
                            <td style="font-size: 12px; text-align: left;">销售（签字）：<input type="text" style="border: 0px; border-bottom: 1px solid black;" /></td>  
                            <td style="font-size: 12px; text-align: left;">顾客（签字）：<input type="text" style="border: 0px; border-bottom: 1px solid black;" /></td>  
                            <td style="font-size: 12px; text-align: right;">★号代表刻爱心符号<br />  
                                取货凭证自取货日起保留期一年</td>  
                        </tr>  
                        <tr>  
                            <td colspan="4" style="font-size: 12px; height: 40px; text-align: right;">1/1</td>  
                        </tr>  
                    </table>
                </div>
                <object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width="0" height="0">  
                    <embed id="LODOP_EM" type="application/x-print-lodop" width="0" height="0" pluginspage="http://c.herp.me/assets/Lodop/install_lodop.exe"></embed>  
                </object>
                
                <button id="perviewer" class="button">预览</button>
                <button id="start-printer">打印</button>
            </div>
        </div>
    </body>
</html>
