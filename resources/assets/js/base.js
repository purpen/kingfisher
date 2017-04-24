/*
 * kingfisher base js 
 */
var kingfisher = {
	    // 当前访问者用户信息
	    visitor: {},
		url : {},
};

/*
 * 初始化,设置常用的ajax hook
 */
kingfisher.initial = function() {

    // 全局去掉ajax cache
    $.ajaxSetup({ cache: false });
	
	/* 此类为确认后执行的ajax操作 */
	$('a.confirm-request').livequery(function(){
		$(this).click(function(){
			if(confirm('确认执行这个操作吗?')){
	        	$.get($(this).attr('href'));
	        }
	        return false;
		});
	});	
    
    /* 此类为ajax链接 */
	$('a.ajax').livequery(function(){
		$(this).click(function(){
			var res_url = $(this).attr('href');
			// 发送ajax请求
			$.get(res_url);
			
	        return false;
		});
	});

    // 列表删除方法
    $('a.delete-btn').click(function(){
        var ids = $(this).data('ids');
        var token = $('#_token').val();
        var url = $(this).attr('href');
        if(!confirm('确认执行此操作?')){
            return false;
        }
        $.post(url, {'ids':ids, '_token':token}, function (e) {
            if (e.status == 1){
                for(var i=0;i<e.data.length;i++){
                    $("#item-"+ e.data[i]).remove();
                }
            }else{
                alert(e.message);
            }
        }, 'json');      
        return false;
    
    });
    
    // 关闭弹出框
    $(".close").click(function () {
        $('#warning').hide();
    });
    
	//input 输入价格 只能为number
	$("input.price").livequery(function(){
		$(this)
		.css("ime-mode", "disabled")
		.keypress(function(){  
			if (event.keyCode != 46 && (event.keyCode < 48 || event.keyCode > 57)){
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

    //去除全选勾选
    $("input[name='Order']:checkbox").click(function () {
        $("#checkAll").prop("checked","");
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
        });
    });
    $('.order-list #label-product').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-product').removeAttr('style');
            $('.order-list #form-user,.order-list #form-jyi,.order-list #form-beiz').css('display','none');
        });
    });
    $('.order-list #label-jyi').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-jyi').removeAttr('style');
            $('.order-list #form-product,.order-list #form-user,.order-list #form-beiz').css('display','none');
        });
    });
    $('.order-list #label-beiz').livequery(function(){
        $(this).click(function(){
            $('.order-list #form-beiz').removeAttr('style');
            $('.order-list #form-user,.order-list #form-jyi,.order-list #form-product').css('display','none');
        });
    });

    //ajax 加载之后的下拉插件
    $('.selectpicker').livequery(function() {
        $('.selectpicker').selectpicker({
            noneSelectedText: "==请选择==",
            size:13
        });
    });


    // 截止至天
    $('.pickdatetime').datetimepicker({
        language: 'zh',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayBtn: true,
        startView: 'month',
        minView:'month',
        maxView:'decade'
    });
    
    // 截止至分
    $('.pickday').datetimepicker({
        language:  'zh',
        format: 'yyyy-mm-dd HH:ii:ss',
        autoclose: true,
        todayBtn: true,
        startView: 'day',
        minView:'hour',
        maxView:'decade'
    });
};


/**
 * 设置cookie，用于区别PC与Mobile。
 */
kingfisher.create_cookie = function(name, value, days, domain, path){
	var appload = '';
	var expires = '';
	if (days) {
		var d = new Date();
		d.setTime(d.getTime() + (days*24*60*60*1000));
		expires = '; expires=' + d.toGMTString();
	}
	domain = domain ? '; domain=' + domain : '';
	path = '; path=' + (path ? path : '/');
	document.cookie = name + '=' + value + expires + path + domain + appload;
}

/**
 * 读取cookie
 */
kingfisher.read_cookie = function(name){
	var n = name + '=';
	var cookies = document.cookie.split(';');
	for (var i = 0; i < cookies.length; i++) {
		var c = cookies[i].replace(/^\s+/, '');
		if (c.indexOf(n) == 0) {
			return c.substring(n.length);
		}
	}
	return null;
}

/**
 * 清除cookie
 */
kingfisher.erase_cookie = function(name, domain, path){
	create_cookie(name, '', -1, domain, path);
}



/**
 * 记录多个ID值
 */
kingfisher.record_asset_id = function(class_id, id){
    var ids = $('#'+class_id).val();
    if (ids.length == 0){
        ids = id;
    }else{
        if (ids.indexOf(id) == -1){
            ids += ','+id;
        }
    }
    $('#'+class_id).val(ids);
};

//移除单个ID值
kingfisher.remove_asset_id = function(class_id, id){
    var ids = $('#'+class_id).val();
    var ids_arr = ids.split(',');
    var is_index_key = kingfisher.in_array(ids_arr,id);
    ids_arr.splice(is_index_key,1);
    ids = ids_arr.join(',');
    $('#'+class_id).val(ids);
};

//查看字符串是否在数组中存在
kingfisher.in_array = function(arr, val) {
    var i;
    for (i = 0; i < arr.length; i++) {
        if (val === arr[i]) {
            return i;
        }
    }
    return -1;
}; // 返回-1表示没找到，返回其他值表示找到的索引

/*
 * 头像上传
 */
kingfisher.user_avatar_upload =　function(user_id,qiniu_token,upload_url) {
    //本地token
    var _token = $('#_token').val();
    
    new qq.FineUploader({
        element: document.getElementById('fine-user-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: upload_url,
            params:  {
                "token": qiniu_token,
                "x:user_id": user_id
            },
            inputName:'file',
        },

        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'png'],
            sizeLimit: 3145728 // 3M = 3 * 1024 * 1024 bytes
        },
        //回调函数
        callbacks: {
            //上传完成后
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#cover_id").val(responseJSON.asset_id);
                    
                    $('#upload-result').append('<div class="asset"><img src="'+responseJSON.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
                    
                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.ajax({
                            type: 'post',
                            url: '/asset/ajaxDelete',
                            data: {'id':id, '_token':_token},
                            dataType: 'json',
                            success: function(e){
                                if(e.status){
                                    img.parent().remove();
                                }else{
                                    console.log(e.message);
                                }
                            }
                        });
                    });
                    
                } else {
                    alert('上传图片失败');
                }
            }
        }
    });
};

/*城市下拉联动 选择省份  市/县联动*/
/**
 * 省份select表单ID：province_id
 * 市 select ID属性：city_id
 * 区县 select  ID属性：county_id
 * 镇     ID属性 township_id
 */
kingfisher.provinceList = function (oid) {
    $.get('/ajaxFetchCity',{'oid':oid,'layer':2},function (e) {
        if(e.status){
            var template = '{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}';
            var views = Mustache.render(template, e);
            $("#city_id")
                .html(views)
                .selectpicker('refresh');

            $.get('/ajaxFetchCity',{'oid':e.data[0].oid,'layer':3},function (e) {
                if(e.status){
                    var template = '{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}';
                    var views = Mustache.render(template, e);
                    views = '<option class="province" value="" oid="">请选择</option>' + views;
                    $("#county_id")
                        .html(views)
                        .selectpicker('refresh');

                    $.get('/ajaxFetchCity',{'oid':e.data[0].oid,'layer':4},function (e) {
                        if(e.status){
                            var template = '{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}';
                            var views = Mustache.render(template, e);
                            views = '<option class="province" value="" oid="">请选择</option>' + views;
                            $("#township_id")
                                .html(views)
                                .selectpicker('refresh');
                        }
                    },'json');
                }
            },'json');
        }
    },'json');
};

/*城市下拉联动 选择市  县联动*/
kingfisher.cityList = function (oid) {
    $.get('/ajaxFetchCity',{'oid':oid,'layer':3},function (e) {
        if(e.status){
            var template = '{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}';
            var views = Mustache.render(template, e);
            views = '<option class="province" value="" oid="">请选择</option>' + views;
            $("#county_id")
                .html(views)
                .selectpicker('refresh');

            $.get('/ajaxFetchCity',{'oid':e.data[0].oid,'layer':4},function (e) {
                if(e.status){
                    var template = '{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}';
                    var views = Mustache.render(template, e);
                    views = '<option class="province" value="" oid="">请选择</option>' + views;
                    $("#township_id")
                        .html(views)
                        .selectpicker('refresh');
                }
            },'json');
        }
    },'json');
};

/*县下拉联动 选择市  县联动*/
kingfisher.countyList = function (oid) {
    $.get('/ajaxFetchCity',{'oid':oid,'layer':4},function (e) {
        if(e.status){
            var template = '{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}';
            var views = Mustache.render(template, e);
            views = '<option class="province" value="" oid="">请选择</option>' + views;
            $("#township_id")
                .html(views)
                .selectpicker('refresh');
        }else{
            $("#township_id")
                .html('')
                .selectpicker('refresh');
        }
    },'json');
};
