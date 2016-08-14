;(function(){
	//input 输入价格 只能为number
	$("input.price").livequery(function(){
		$(this)
		.css("ime-mode", "disabled")
		.keypress(function(){  
			if (event.keyCode!=46 && (event.keyCode<48 || event.keyCode>57)){
				event.returnValue=false;
			}
		})
	});
	//checkbox 全选
	$("#checkAll").livequery(function () {
		$(this).click(function(){
			$("input[name='Order']:checkbox").prop("checked", this.checked);
		})
    });
    //checkbox 可多选
    $('.scrollt tbody tr').livequery(function(){
    	$(this).click(function(){
    		if( $(this).find("input[name='Order']").attr('active') == 0 ){
	    		$(this).find("input[name='Order']").prop("checked", "checked").attr('active','1');
	    	}else{
	    		$(this).find("input[name='Order']").prop("checked", "").attr('active','0');
	    	}
    	})
    });
    //checkbox 不可多选，只能单选
    $('.scrolltt tbody tr').livequery(function(){
        $(this).click(function(){
            if( $(this).find("input[name='Order']").attr('active') == 0 ){
                $('.scrolltt').find("input[name='Order']").prop("checked", "").attr('active','0');
                $(this).find("input[name='Order']").prop("checked", "checked").attr('active','1');
            }else{
                $('.scrolltt').find("input[name='Order']").prop("checked", "").attr('active','0');
                $(this).find("input[name='Order']").prop("checked", "").attr('active','0');
            }
        })
    });

    //点击一行可选中 最后一个操作元素点击不可选中 最后一个元素加参数 tdr="nochect"
    $(".scroll tbody tr td").click(function(){
        var tdl = $(this).parent().children().length-1;
        var tdr = $(this).attr('tdr');
        if( tdr == 'nochect' ){
            if( $(this).siblings().find("input[name='Order']").attr('active') == 0 ){
                $(this).siblings().find("input[name='Order']").prop("checked", "").attr('active','0');
            }else{
                $(this).siblings().find("input[name='Order']").prop("checked", "checked").attr('active','1');
            }
        }else{
            if( $(this).siblings().find("input[name='Order']").attr('active') == 1 ){
                $(this).siblings().find("input[name='Order']").prop("checked", "").attr('active','0');
            }else{
                $(this).siblings().find("input[name='Order']").prop("checked", "checked").attr('active','1');
            }
        }
    });

    //订单查询的tab切换
    $('.order-list #label-user').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-user').removeAttr('style');
            $('.order-list #form-product,.order-list #form-jyi,.order-list #form-beiz').css('display','none');
        })
    })
    $('.order-list #label-product').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-product').removeAttr('style');
            $('.order-list #form-user,.order-list #form-jyi,.order-list #form-beiz').css('display','none');
        })
    })
    $('.order-list #label-jyi').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-jyi').removeAttr('style');
            $('.order-list #form-product,.order-list #form-user,.order-list #form-beiz').css('display','none');
        })
    })
    $('.order-list #label-beiz').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-beiz').removeAttr('style');
            $('.order-list #form-user,.order-list #form-jyi,.order-list #form-product').css('display','none');
        })
    });

    //ajax 加载之后的下拉插件
    $('.selectpicker').livequery(function(){
        $('.selectpicker').selectpicker({
            noneSelectedText: "==请选择==",
        });
    })

})(jQuery);