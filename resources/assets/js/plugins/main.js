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

    //点击一行可选中 最后一个操作元素点击不可选中
    for (var i=0; i<$(".scroll tbody tr td").length-1;i++){
        var forclick = $(".scroll tbody tr td").eq(i);
        forclick.click(function(){
            if( forclick.siblings().find("input[name='Order']").attr('active') == 0 ){
                forclick.siblings().find("input[name='Order']").prop("checked", "checked").attr('active','1');
            }else{
                forclick.siblings().find("input[name='Order']").prop("checked", "").attr('active','0');
            }
        })
    }
})(jQuery);