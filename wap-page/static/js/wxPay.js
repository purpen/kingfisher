export function onBridgeReady (config) {
  WeixinJSBridge.invoke(
    'getBrandWCPayRequest', config,
    function (res) {
      if (res.err_msg === 'get_brand_wcpay_request:ok') {}
    }
  )
}
