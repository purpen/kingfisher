<<<<<<< HEAD
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
    $('.selectpicker').livequery(function() {
        $('.selectpicker').selectpicker({
            noneSelectedText: "==请选择==",
        });
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

kingfisher.upload_headpic = function() {
    new qq.FineUploader({
        element: document.getElementById('fine-user-uploader'),
        autoUpload: true, //不自动上传则调用uploadStoredFiless方法 手动上传
        // 远程请求地址（相对或者绝对地址）
        request: {
            endpoint: 'https://up.qbox.me',
            params:  {
                "token": token,
                "x:user_id":'{{ Auth::user()->id }}'
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
            console.log(responseJSON);
                if (responseJSON.success) {
                    console.log(responseJSON.success);
                    $("#cover_id").val(responseJSON.asset_id);
                    $('.user-pic').prepend('<div class="col-md-2 mb-3r"><img src="'+responseJSON.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+responseJSON.asset_id+'">删除</a></div>');
                    $('.removeimg').click(function(){
                        var id = $(this).attr("value");
                        var img = $(this);
                        $.post('{{url('/asset/ajaxDelete')}}',{'id':id,'_token':_token},function (e) {
                            if(e.status){
                                img.parent().remove();
                            }else{
                                console.log(e.message);
                            }
                        },'json');

                    });
                } else {
                    alert('上传图片失败');
                }
            }
        }
    });
}
=======
var kingfisher={visitor:{},url:{}};kingfisher.initial=function(){$.ajaxSetup({cache:!1}),$("a.confirm-request").livequery(function(){$(this).click(function(){return confirm("确认执行这个操作吗?")&&$.get($(this).attr("href")),!1})}),$("a.ajax").livequery(function(){$(this).click(function(){var e=$(this).attr("href");return $.get(e),!1})}),$("a.delete-btn").click(function(){var e=$(this).data("ids"),t=$("#_token").val(),i=$(this).attr("href");return!!confirm("确认执行此操作?")&&($.post(i,{ids:e,_token:t},function(e){if(1==e.status)for(var t=0;t<e.data.length;t++)$("#item-"+e.data[t]).remove();else alert(e.message)},"json"),!1)}),$(".close").click(function(){$("#warning").hide()}),$("input.price").livequery(function(){$(this).css("ime-mode","disabled").keypress(function(){46!=event.keyCode&&(event.keyCode<48||event.keyCode>57)&&(event.returnValue=!1)})}),$("#checkAll").livequery(function(){$(this).click(function(){$("input[name='Order']:checkbox").prop("checked",this.checked)})}),$(".scrollt tbody tr").livequery(function(){$(this).click(function(){0==$(this).find("input[name='Order']").attr("active")?$(this).find("input[name='Order']").prop("checked","checked").attr("active","1"):$(this).find("input[name='Order']").prop("checked","").attr("active","0")})}),$(".scrolltt tbody tr").livequery(function(){$(this).click(function(){0==$(this).find("input[name='Order']").attr("active")?($(".scrolltt").find("input[name='Order']").prop("checked","").attr("active","0"),$(this).find("input[name='Order']").prop("checked","checked").attr("active","1")):($(".scrolltt").find("input[name='Order']").prop("checked","").attr("active","0"),$(this).find("input[name='Order']").prop("checked","").attr("active","0"))})}),$(".scroll tbody tr td").click(function(){var e=($(this).parent().children().length-1,$(this).attr("tdr"));"nochect"==e?0==$(this).siblings().find("input[name='Order']").attr("active")?$(this).siblings().find("input[name='Order']").prop("checked","").attr("active","0"):$(this).siblings().find("input[name='Order']").prop("checked","checked").attr("active","1"):1==$(this).siblings().find("input[name='Order']").attr("active")?$(this).siblings().find("input[name='Order']").prop("checked","").attr("active","0"):$(this).siblings().find("input[name='Order']").prop("checked","checked").attr("active","1")}),$(".order-list #label-user").livequery(function(){$(this).click(function(){$(".order-list #form-user").removeAttr("style"),$(".order-list #form-product,.order-list #form-jyi,.order-list #form-beiz").css("display","none")})}),$(".order-list #label-product").livequery(function(){$(this).click(function(){$(".order-list #form-product").removeAttr("style"),$(".order-list #form-user,.order-list #form-jyi,.order-list #form-beiz").css("display","none")})}),$(".order-list #label-jyi").livequery(function(){$(this).click(function(){$(".order-list #form-jyi").removeAttr("style"),$(".order-list #form-product,.order-list #form-user,.order-list #form-beiz").css("display","none")})}),$(".order-list #label-beiz").livequery(function(){$(this).click(function(){$(".order-list #form-beiz").removeAttr("style"),$(".order-list #form-user,.order-list #form-jyi,.order-list #form-product").css("display","none")})}),$(".selectpicker").livequery(function(){$(".selectpicker").selectpicker({noneSelectedText:"==请选择=="})})},kingfisher.create_cookie=function(e,t,i,r,n){var c="",o="";if(i){var s=new Date;s.setTime(s.getTime()+24*i*60*60*1e3),o="; expires="+s.toGMTString()}r=r?"; domain="+r:"",n="; path="+(n?n:"/"),document.cookie=e+"="+t+o+n+r+c},kingfisher.read_cookie=function(e){for(var t=e+"=",i=document.cookie.split(";"),r=0;r<i.length;r++){var n=i[r].replace(/^\s+/,"");if(0==n.indexOf(t))return n.substring(t.length)}return null},kingfisher.erase_cookie=function(e,t,i){create_cookie(e,"",-1,t,i)},kingfisher.record_asset_id=function(e,t){var i=$("#"+e).val();0==i.length?i=t:i.indexOf(t)==-1&&(i+=","+t),$("#"+e).val(i)},kingfisher.remove_asset_id=function(e,t){var i=$("#"+e).val(),r=i.split(","),n=kingfisher.in_array(r,t);r.splice(n,1),i=r.join(","),$("#"+e).val(i)},kingfisher.in_array=function(e,t){var i;for(i=0;i<e.length;i++)if(t===e[i])return i;return-1},kingfisher.header_user_upload=function(){var e=$("#_token").val(),t=$("#tokens").val(),i=$("#user_cover_id").val(),r=$("#delete_user_upload").val();$(document).ready(function(){new qq.FineUploader({element:document.getElementById("fine-user-uploader"),autoUpload:!0,request:{endpoint:"https://up.qbox.me",params:{token:t,"x:user_id":i},inputName:"file"},validation:{allowedExtensions:["jpeg","jpg","png"],sizeLimit:3145728},callbacks:{onComplete:function(t,i,n){n.success?($("#cover_id").val(n.asset_id),$(".user-pic").prepend('<div class="col-md-2 mb-3r"><img src="'+n.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+n.asset_id+'">删除</a></div>'),$(".removeimg").click(function(){var t=$(this).attr("value"),i=$(this);$.ajax({type:"post",url:r,data:{id:t,_token:e},dataType:"json",success:function(e){e.status&&i.parent().remove()}})})):alert("上传图片失败")}}})})};
>>>>>>> origin/clg
