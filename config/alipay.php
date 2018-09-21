<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2018091761417220",

		//商户私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCLqatB7bFRI4BF2YjTDbllzWfuZw4XH6ZL/J5lM4gDvQgdCbx635RrQdX7BpRvGm/ymfWMGxBq+nqWIvlnXA+P4ZH0SLoaXshjRrY5Tf+4pduuEL+uhmqPTizPRJAxwQ4LJBmzOGqMYE3W/VLxdMIcC44L3NbCUeENQPrfhU1ok51qwMeiTvaAvG38xn9nKilJqzepGkiNoMddPZAcc6HUzIarsO1/ep8obSHMQJFR/AFOFg2/q8aIOFBpdMdBDfOE63RC0APrecuydCYOLRktew2c0MyZ7zx0Xjcs9FPKhRsvgq+OinPDUWC6iUelfI3Tfz1BqeJe23Dnk/Men6hXAgMBAAECggEAfZzcqy9di9yiQjClHy340dcs4v9NbP7KUw2iaOMwMiySX4uiOeFdXBqammwQlNzyUwCmGJ0+5vjhyKcsKgpi9MWswEmpGI6nLKMswd2lYi3Kp4Po4s+Ch+GH6+N+zUEVoG+XrdnP+vGjEPpG32RkMVUzLPgzMBL0lzcabG84cBT+QmBLZDHv3Vs/eVPircRaZDpeH9pdwGlSgQyvS0zUVYPPzwFVqHoIOZKGKfLB2Z9lbIA+Luzm8yhpaBUYFvzE7JTZfU55QZVaLIXuxIInXm50MZpWFi3p3XGvGXUEAGVikrImIVnzSJKsrEtzxCvxpJMTRRXcxoA6EbZjVpO4AQKBgQDR6ML8elQbTHeUKY1Jjiqm7excndYRljdarpvhwyHJl/+ZtzfKHbAWqt5//O2lMOPt9vQ/lUw7grhYnLIHkeBemaYsJqEGbSnKysZiVqGjaOxG3UeS83ZL/FHXi0Te3NU+N5fX07z95UsIJOrgJff6zBq/uX2irxaHA3gegfHPUQKBgQCqVEYAyF+rDQdL+g26JhnhPng+cHnfA+Ok7Hsc31AKHvQ70EOcY/JZA2rGyy9ucCr7GzUTunJZZ9SfDzMLGP1fpjmUv3Mhju01JzEe15NUjJfePEbCeSXUWIT0A164hLd+fzF5sehVMjhs4UH7lQ+ZEn2KxN3+zI0KnL2maiEjJwKBgQCeV6QGysx5T0SA+ps+2kRoad+7ucCKwbL97+tc8VKifMtuDBzElYKIhtqS15v42ZmGn5x9/kRkO+aNyZ4uQadsFSGZ+oXLkDtPY4klE06ZMwPRLQjZ3FfnV+3w13jbWOBvL4aWY34UVIw2F4sqDNo0URT4fZc9SjCHJmHNOZ7MEQKBgAMOcBMjhVP0b+UVH5nvhRddn5q/OfCeiT80XyEtgKot1AQewJfV00t1nDzk+Hzq1lqbKmCoP9UK3+3av/e7AxDsUqwwo0g+4FLL2T3McIBb5X2/ZyWmNt+QlxIp3VFCUGicr66XWqvsssaBZEW3bwg4JLiQv8sKsJ04Is8RqHaRAoGAArkb9YLnMEfooayMloWkc/5BQ1/JZeI+2M4NA2TcuIK/R/BFYUdpLccrkKqtO+6DNPPW8Lgy+BCZnPoqvwneIq1Ki+X7NLIIb4xqX4wk9M/KMrTnN9z0HHAxvbReo3+HqvlX0K+DX24bD+NzNjDs5szvegnXvbozwsX9Z5Ywz5E=",
		
		//异步通知地址
		'notify_url' => "http://k.taihuoniao.com/DealerApi/pay/make_sure",
		
		//同步跳转
//		'return_url' => "http://192.168.33.122/alipay2/return_url.php",
		'return_url' => "http://www.baidu.com",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.Alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkv38C0QphhzPV5BksZfwFkrxot8JmGp8n3LOdOhUxbxmer9rqAT0gVba2cUhmvNdB93EL/OA+Pb12MvckOsu9N0V4qWD99bFCO5CWoDMrKyaEPICS6Etaj8trVdTZrEJxzmAYNRojAx8Lyc+Nt+8Ndjh8hFQ3hFJuIUDxarHt7MUSgvSOh6oEshsBOJLOs78PSOVmRr6HzFdReBDoMveXkPxC2Nt0s/+wQUi2CuEyvGTrH9MZNGWWU05ycdFCCuotyoyWChkkDMqmMhOPW947gcCt6CvHXehClfOJO9SfZs05Srucl9oJ1hKc4oHUqGciUc5TFiZ9lempQTebegdKwIDAQAB",
);