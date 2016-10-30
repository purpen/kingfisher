<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

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
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                
				<div class="form-group mr-2r">
					<a href="{{ url('/order/create') }}" class="btn btn-white">
						<i class="glyphicon glyphicon-edit"></i> 创建订单
					</a>
                    <button type="button" id="batch-verify" class="btn btn-white mlr-2r">
                        <i class="glyphicon glyphicon-ok"></i> 批量审批
                    </button>
                    <button type="button" id="batch-reversed" class="btn btn-white mlr-2r">
                        <i class="glyphicon glyphicon-arrow-left"></i> 批量反审
                    </button>
                    <button type="button" class="btn btn-white" id="send-order">
                        <i class="glyphicon glyphicon-print"></i> 打印发货
                    </button>
				</div>
            </div>
        </div>
    </body>
</html>
