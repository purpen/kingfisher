<?php
        $config = array (
		//应用ID,您的APPID。
		'app_id' => "2018091761417220",

		//商户私钥
         'merchant_private_key' => "MIIEpQIBAAKCAQEA3u0529jwWXSWnL3Ds9LAn/L6Dl68tOju0YcZVO1J11emBvLw2sh6DnfRzFvdhVYZxkIivDVxqzh1/w/GHd55NaCz0z1Fo2KMKAe5mjOp/TsnH15GZ6DByy/gbnXQId9HqDDO8tgYvelw3h3Z0V80rZV0gL3JWI1S0QPgvTxpffeBgCptGtBULMEQlIa9Ve2qBYNOuw6DC7Y6k2dRhYtwWCuE7b5APE7ARvXpOrqP6ei/d24u9UVapYSg1k2QNssQ93YEK5QLdpYi/L2QyCiN3yecQuHAm1uL/z3YmiHA3afU666blSOxcparX7SuvZms0ZdS7rd3urskOOCTbut9yQIDAQABAoIBAQCENgVekabaJv88Ln9motODCUOsSht437zjn1AywhhNErpw3Jxj5QoekolmvgT/EzVuE8MuBDRJ685vWxeQl2UjnQ+JdIlcgRHGm+5DuehTO0XUoMD4rKrCqr5cRJsPu7Bv26Kg+/CQkWZTFTkdp21ClaTmxagoUIiRVc9v6+hUv94rY5am2A4g7UVAdyzDSYy6v9X1TPT2paqv622FRUP42AjKmobiRd4NuSi6I00xqrEkxIcBA7WpL7F0i8dnfaITd5sxzO98UrK21GrdEOp6+0/K1q+YCgJhRXYacoG24uURPo+wXs6frrwu8E3cYwKo6XTAG7TqI2RHlGKuA21BAoGBAPQ30Jps6o9BJzatjqyHDaFnoywMmDpzQo4ObUO1DXKnTBbQGzSJEuPfyGkoSl9CGKe89t4QkzGM13Rc6suZ5r0woSSmusoc5O3iDey/zvDQ2GU5bEh01LsFyFsdkf3VT2q7OqKWdyqWUXfck/a7hkSiSrUgM4qr8Gyl24TP+R1NAoGBAOmudGsmx5IenCe98jV3BhOZ0IjDXHnxgklzGbz7SQ31ZcglyDxhqbhJM59my+4Fa2GhnHb6mPueNpnpgSURn1FfOslhH4lsb5ZBtampKjiFlyWAwv0FB+TKgx1uYjWS8glDUaNg8+4Q5lum4CP3vhs0F+oRHSvn+5k7IGOR0BRtAoGBALmv7pZcFgSSP2SdlgusLDr69+A4O07F8GbepUmD0hPJDFuUI/tP9eL5dgIutk2zjdeMIBA8fg6AzhkVxRjFjeFvpjad5wxh59bPuFK4jHoh8UcV4DU/T7hb7zkIRMbBd77pWO3ihf0FijAesQo7Dx4EX9VUBJx9mzKg8UYMc5dJAoGAJhhmqkE8L7oFwwTYQ5cPyoo80M7oeIjCsK6u93wPwNLMsQBX0GArhvuICuh7PmZrxxLNqyfXYM2+IQFMKHri+iUINGQ8++5NkrVLpEkLtQMyTM7c+tqjGs1Y6qdgI1O9WX08BeJ8YccnhrGBwNtWhqDLdUEs/EdpYOWethzDS1ECgYEAtRf/Pm1AIgldPLOPNo4AjXlloJSX2rv4zD3q2YX2Yf1T+p2blhUuZpwCDf5VXN7NaxuktkqKVteBn254o5hlM/uKKgksvCSqaGf3s8ujNKf/cqQQ91NOK3qcwFDgpZygpHgMedxNAAHpW6cp62mOKMz3EAMidILl6sSkYfcw1x8=",

        //异步通知地址
        'notify_url' => "http://k.taihuoniao.com/DealerApi/pay/make_sure",

        //同步跳转
        'return_url' => "http://fiu_dev.taihuoniao.com/center/order/monthorderlist/1/0/1",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.Alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkv38C0QphhzPV5BksZfwFkrxot8JmGp8n3LOdOhUxbxmer9rqAT0gVba2cUhmvNdB93EL/OA+Pb12MvckOsu9N0V4qWD99bFCO5CWoDMrKyaEPICS6Etaj8trVdTZrEJxzmAYNRojAx8Lyc+Nt+8Ndjh8hFQ3hFJuIUDxarHt7MUSgvSOh6oEshsBOJLOs78PSOVmRr6HzFdReBDoMveXkPxC2Nt0s/+wQUi2CuEyvGTrH9MZNGWWU05ycdFCCuotyoyWChkkDMqmMhOPW947gcCt6CvHXehClfOJO9SfZs05Srucl9oJ1hKc4oHUqGciUc5TFiZ9lempQTebegdKwIDAQAB",
        );