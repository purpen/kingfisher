<!DOCTYPE html>
<html>
    <head>
        <title>太火鸟REP系统</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ elixir('assets/css/bootstrap.css') }}">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
        <!-- JavaScripts -->
        <script src="{{ elixir('assets/js/jquery.js') }}"></script>
        <script src="{{ elixir('assets/js/plugins.js') }}"></script>
        <script type="text/javascript">
            $(function(){
                var token = $('#_token').val();
                
                $(document)
                    .pjax('a.pjax', '#container')
                    .on('pjax:beforeReplace', function(contents, options){
                        console.log(contents.target.innerHtml);
                        
                    });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                <input type="hidden" id="_token" value="<?php echo csrf_token(); ?>">
				<div class="form-group mr-2r">
                    <a href="/test_next?type=1&page=1" id="batch-verify" class="btn pjax btn-white mlr-2r">
                        <i class="glyphicon glyphicon-ok"></i> 订单列表
                    </a>
                    <a href="/test_next?type=2&page=3" id="batch-verify" class="btn pjax btn-white mlr-2r">
                        <i class="glyphicon glyphicon-ok"></i> 待付款
                    </a>
                    <a href="{{ url('/scanner')}}" class="btn btn-white" id="send-order">
                        <i class="glyphicon glyphicon-print"></i> 打印发货
                    </a>
				</div>
                
                <div id="container">
                    {{ $html or ''}}
                </div>
            </div>
        </div>
    </body>
</html>
