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
                vertical-align: middle;
            }

            .content {
                margin: 20px auto;
                width: 100%;
            }
            
            #shoplist {
                width: 980px;
                margin: 20px auto;
                padding: 20px;
                background-color: #fff;
                border: 5px solid #ccc;
            }
            #shoplist .table {
                width: 100%;
            }
        </style>
        <!-- JavaScripts -->
        <script src="{{ asset('/assets/js/jquery.js') }}"></script> 
        <script>
            $(function(){
                var ids = new Array();
                var exp_index = function(cid) {
                    var l = ids.length;
                    for(var i=0;i<l-1;i++){
                        if (ids[i] == cid) return i;
                    }
                }
                $(".express_no").each(function(){
                    ids.push(this.id);
                }).keydown(function(event) {
                    var indx = exp_index(this.id);
                    if (event.keyCode == 13) {
                        // skip, do something
                        $(".express_no").eq(indx+1).focus();
                    }
                });
                
                $('#back').click(function(){
                    window.history.go(-1); 
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <button class="btn btn-default btn-lg" id="back">返回</button>
                <div id="shoplist">
                    <h4>开始发货</h4>
                    
                    <table class="table table-bordered">
                        <tr>
                            <td>
                                订单号：2016101200092
                            </td>
                            <td>
                                发货单号：<input type="text" name="express_no" class="express_no" id="2016101200092" >
                            </td>
                            <td>
                                <button class="btn btn-default">发货</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                订单号：2016101200094
                            </td>
                            <td>
                                发货单号：<input type="text" name="express_no" class="express_no" id="2016101200094" > 
                            </td>
                            <td>
                                <button class="btn btn-default">发货</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                订单号：2016101200095
                            </td>
                            <td>
                                发货单号：<input type="text" name="express_no" class="express_no" id="2016101200095" > 
                            </td>
                            <td>
                                <button class="btn btn-default">发货</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                订单号：2016101200097
                            </td>
                            <td>
                                发货单号：<input type="text" name="express_no" class="express_no" id="2016101200097" > 
                            </td>
                            <td>
                                <button class="btn btn-default">发货</button>
                            </td>
                        </tr>
                    </table>
                    
                    <img src="/buildcode?codebar=BCGcode39&codetext=20161012000094">
                </div>
            </div>
        </div>
    </body>
</html>
