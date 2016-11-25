<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="{{ elixir('assets/css/bootstrap.css') }}">
    <script src="{{ elixir('assets/js/jquery.js') }}"></script>
    <script>
        var socket;
        var printers;
        var defaultPrinter;
        var printTaskId;
        var taskers;
        var waybillPrintStatus;
        var waybillNO = '9890000076011';
        var waybillTemplateURL = 'http://cloudprint.cainiao.com/cloudprint/template/getStandardTemplate.json?template_id=801';
        var customAreaURL = 'http://cloudprint.cainiao.com/cloudprint/customArea/queryCustomAreaList4Top.json?custom_area_id=2201&user_id=2066393830';
        function doConnect()
        {
            var printer_address = '127.0.0.1:13528';
            socket = new WebSocket('ws://' + printer_address);
            //if (socket.readyState == 0) {
            //    alert('WebSocket连接中...');
            //}
            // 打开Socket
            socket.onopen = function(event)
            {
                alert("Websocket准备就绪,连接到客户端成功");
            };
            // 监听消息
            socket.onmessage = function(event)
            {
                console.log('Client received a message',event);
                var data = JSON.parse(event.data);
                if ("getPrinters" == data.cmd) {
                    alert('打印机列表:' + JSON.stringify(data.printers));

                    defaultPrinter = data.defaultPrinter;
                    alert('默认打印机为:' + defaultPrinter);
                } else {
                    alert("返回数据:" + JSON.stringify(data));
                }
            };

            // 监听Socket的关闭
            socket.onclose = function(event)
            {
                console.log('Client notified socket has closed',event);
            };

            socket.onerror = function(event) {
                alert('无法连接到:' + printer_address);
            };
        }

        /***
         * 请求打印机列表协议
         */
        function doGetPrinters() {
            var request  = {
                requestID : "12345678901234567890",
                version : "1.0",
                cmd : "getPrinters"
            };
            socket.send(JSON.stringify(request));
        }

        /***
         * 配置打印机协议
         */
        function doPrinterConfig() {
            var request  = {
                requestID : '12345678901234567890',
                version : '1.0',
                cmd : 'printerConfig'
            };
            socket.send(JSON.stringify(request));
        }
        /***
         * 打印机配置
         */
        function doSetPrinterConfig() {
            var request  = {
                requetid : '12345678901234567890',
                version : '1.0',
                cmd : 'setPrinterConfig',
                printer : {
                    name : defaultPrinter,
                    needUpLogo : true,
                    needDownLogo: false
                }
            };
            socket.send(JSON.stringify(request));
        }
        /***
         * 请求打印任务状态协议
         */
        function doGetTaskStatus() {
            //var taskId = $("#taskId").val();
            //var taskId = printTaskId;
            var request  = {
                requestID : "12345678901234567890",
                version : "1.0",
                cmd : "getTaskStatus",
                taskID : [
                    ''+printTaskId
                ]
            };
            socket.send(JSON.stringify(request));
        }
        /***
         * 请求打印任务状态协议
         */
        function doGetDocumentStatus() {
            var waybillNO = $("#waybillNO").val();
            var request  = {
                requestID : "12345678901234567890",
                version : "1.0",
                cmd : "getDocumentStatus",
                documentIDs : [
                    waybillNO
                ]
            };
            socket.send(JSON.stringify(request));
        }
        /***
         * 打印
         */

        function doPrint()
        {
            var waybillNO = '3318995212106';
            var data = '{"data":{"cpCode":"STO","recipient":{"address":{"city":"顺义区","detail":"光明大道收","district":"光明街道","province":"北京"},"mobile":"15678654567","name":"111","phone":"334234"},"routingInfo":{"consolidation":{"name":"北京昌平包"},"origin":{"code":"100021","name":"北京望京公司"},"routeCode":"130","sortation":{"name":"北京顺义"}},"sender":{"address":{"city":"北京市","detail":"酒仙桥街道751时尚设计广场B7栋南楼西侧","district":"朝阳区","province":"北京"},"mobile":"18629493221","name":"太火鸟"},"shippingOption":{"code":"STANDARD_EXPRESS","title":"标准快递"},"waybillCode":"3318995212106"},"signature":"MD:xsTE4ze2Y0CYaP7RR6NN7A==","templateURL":"http://cloudprint.cainiao.com/template/standard/75402/13"}';
            //printTaskId = $("#printTaskId").val();
            //waybillTemplateURL = $("#waybillTemplateURL").val();
            //customAreaURL = $("#customAreaURL").val();
            //waybillNO = $("#waybillNO").val();
            printTaskId = parseInt(1000*Math.random());

            request  = {
                cmd : "print",
                requestID : ''+waybillNO,
                version : "1.0",
                task : {
                    taskID : ''+printTaskId,
                    preview : false,
                    printer : '',
                    documents : [
                        {
                            "documentID":''+waybillNO,
                            contents : [
                                //电子面单部分
                                $.parseJSON(data)
                                    //电子面单数据
                            ]
                        }
                    ]
                }
            };
            alert(JSON.stringify(request));
            socket.send(JSON.stringify(request));
        }

        $("#doPrint").click(function () {
            alert(111);
                    waybillNO = '3318995212106';
                    var data = '{"data":{"cpCode":"STO","recipient":{"address":{"city":"顺义区","detail":"光明大道收","district":"光明街道","province":"北京"},"mobile":"15678654567","name":"111","phone":"334234"},"routingInfo":{"consolidation":{"name":"北京昌平包"},"origin":{"code":"100021","name":"北京望京公司"},"routeCode":"130","sortation":{"name":"北京顺义"}},"sender":{"address":{"city":"北京市","detail":"酒仙桥街道751时尚设计广场B7栋南楼西侧","district":"朝阳区","province":"北京"},"mobile":"18629493221","name":"太火鸟"},"shippingOption":{"code":"STANDARD_EXPRESS","title":"标准快递"},"waybillCode":"3318995212106"},"signature":"MD:xsTE4ze2Y0CYaP7RR6NN7A==","templateURL":"http://cloudprint.cainiao.com/template/standard/75402/13"}';
                    doPrint(waybillNO, data);
                });

    </script>
</head>
<body>
<div class="container">
    <h1>111</h1>
    <div>
        <button type="button" class="btn btn-default" onclick="doConnect()">连接websocket</button>
    </div>

    <div>
        <button type="button" class="btn btn-default" onclick="doPrint()">打印</button>
    </div>
</div>


</body>
</html>