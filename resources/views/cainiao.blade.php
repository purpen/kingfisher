<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="http://www.qysea.com/css/bootstrap.min.css">
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
            /*var re =  /^([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.([0-9]|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]):[\d]+$/;
             var printer_address = $("#printer_address").val();*/
            //if(!re.test(printer_address) && printer_address != 'localhost') {
            //    alert("ip地址格式不正确，请修改:ip:port");
            //    return false;
            //}
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
            //printTaskId = $("#printTaskId").val();
            //waybillTemplateURL = $("#waybillTemplateURL").val();
            //customAreaURL = $("#customAreaURL").val();
            //waybillNO = $("#waybillNO").val();
            printTaskId = parseInt(1000*Math.random());

            request  = {
                cmd : "print",
                requestID : "12345678901234567890",
                version : "1.0",
                task : {
                    taskID : ''+printTaskId,
                    preview : false,
                    printer : defaultPrinter,
                    documents : [
                        {
                            "documentID":waybillNO,
                            contents : [
                                //电子面单部分
                                {
                                    templateURL : waybillTemplateURL,
                                    signature : "ALIBABACAINIAOWANGLUO",
                                    "data": {
                                        "recipient": {
                                            "address": {
                                                "city": "北京市",
                                                "detail": "花家地社区卫生服务站三层楼我也不知道是哪儿了",
                                                "district": "朝阳区",
                                                "province": "北京",
                                                "town": "望京街道"
                                            },
                                            "mobile": "1326443654",
                                            "name": "张三",
                                            "phone": "057123222"
                                        },
                                        "routingInfo": {
                                            "consolidation": {
                                                "name": "杭州",
                                                "code": "hangzhou"
                                            },
                                            "origin": {
                                                "code": "POSTB"
                                            },
                                            "sortation": {
                                                "name": "杭州"
                                            },
                                            "routeCode": "380D-56-04"
                                        },
                                        "sender": {
                                            "address": {
                                                "city": "北京市",
                                                "detail": "花家地社区卫生服务站二层楼我也不知道是哪儿了",
                                                "district": "朝阳区",
                                                "province": "北京",
                                                "town": "望京街道"
                                            },
                                            "mobile": "1326443654",
                                            "name": "张三",
                                            "phone": "057123222"
                                        },
                                        "shippingOption": {
                                            "code": "COD",
                                            "services": {
                                                "SVC-COD": {
                                                    "value": "200"
                                                }
                                            },
                                            "title": "代收货款"
                                        },
                                        "waybillCode": "9890000160004"
                                    }
                                    //电子面单数据
                                },
                                //自定义区部分
                                {
                                    templateURL : customAreaURL,
                                    data : {
                                        "item_name":"我是你要的商品芭比娃娃。。。"
                                    }
                                }
                            ]
                        }
                    ]
                }
            };
            alert(JSON.stringify(request));
            socket.send(JSON.stringify(request));
        }


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