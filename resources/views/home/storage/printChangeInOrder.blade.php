<script id="print-change-in-order-tmp" type="text-x-mustache-tmpl">
<head>
    <style type="text/css">
        .modal-body {
            position: relative;
            padding: 20px;
        }

        *,
        *::after,
        *::before {
            box-sizing: border-box;
        }

        body {
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.428571429;
            color: #333;
        }

        .row,
        .table {
            margin-bottom: 10px;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .col-lg-10 {
            width: 83.3333333333%;
        }

        .col-lg-offset-4 {
            margin-left: 33.3333333333%;
        }

        .col-lg-3 {
            width: 25%;
        }
        .col-lg-4 {
            width: 33.3333333333%;
        }

        .col-lg-1,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12 {
            float: left;
        }

        .col-lg-1,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-md-1,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-sm-1,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-xs-1,
        .col-xs-2,
        .col-xs-3,
        .col-xs-4,
        .col-xs-5,
        .col-xs-6,
        .col-xs-7,
        .col-xs-8,
        .col-xs-9,
        .col-xs-10,
        .col-xs-11,
        .col-xs-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .table-bordered,
        .table-bordered > tbody > tr > td,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > td,
        .table-bordered > tfoot > tr > th,
        .table-bordered > thead > tr > td,
        .table-bordered > thead > tr > th {
            border: 1px solid #ddd;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        tr th {
            font-size: 12px;
        }

        .table > tbody > tr > td,
        .table > tbody > tr > th,
        .table > tfoot > tr > td,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > thead > tr > th {
            padding: 8px;
            line-height: 1.42857143;
            border-top: 1px solid #ddd;
            height: 24px;
            vertical-align: middle;
        }

    </style>
</head>
{{--打印调拨入库单模板--}}
<div id="">

    <h3 class="" style="text-align: center;">太火鸟调拨入库单</h3>
    <br>
    {{--@{{ #out_warehouse }}--}}
    {{--<div class="row">--}}
        {{--<div class="col-lg-3">出仓库: @{{storage_name}}</div>--}}
        {{--<div class="col-lg-3">出部门: @{{department_val}}</div>--}}
        {{--<div class="col-lg-3">单号: @{{ number }}</div>--}}
        {{--<div class="col-lg-3">时间: @{{ created_at }}</div>--}}
    {{--</div>--}}
    {{--@{{ /out_warehouse }}--}}
    @{{ #enter_warehouse }}
    <div class="row">
        <div class="col-lg-3">入仓库: @{{ storage_name }}</div>
        <div class="col-lg-3">入部门: @{{ department_val }}</div>
        <div class="col-lg-3">单号: @{{ number }}</div>
        <div class="col-lg-3">时间: @{{ created_at }}</div>
    </div>
    @{{ /enter_warehouse }}
    <br>
    <table class="table table-bordered">
        <tr>
            <td>ID</td>
            <td>商品编号</td>
            <td>商品型号</td>
            <td>商品名称</td>
            <td>商品型号</td>
            <td>数量</td>
        </tr>
        @{{ #enter_sku }}
        <tr>
            <td></td>
            <td>@{{ product_number }}</td>
            <td>@{{ number }}</td>
            <td>@{{ name }}</td>
            <td>@{{ mode }}</td>
            <td>@{{ count }}</td>
        </tr>
        @{{ /enter_sku }}
    </table>
    <div class="row">
        @{{ #enter_warehouse }}
        <div class="col-lg-10">备注: @{{ summary }}</div>
        @{{ /enter_warehouse }}
    </div>
</div>
</script>