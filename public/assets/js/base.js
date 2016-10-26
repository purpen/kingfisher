<<<<<<< HEAD
var kingfisher={visitor:{},url:{}};kingfisher.initial=function(){$.ajaxSetup({cache:!1}),$("a.confirm-request").livequery(function(){$(this).click(function(){return confirm("确认执行这个操作吗?")&&$.get($(this).attr("href")),!1})}),$("a.ajax").livequery(function(){$(this).click(function(){var e=$(this).attr("href");return $.get(e),!1})}),$("a.delete-btn").click(function(){var e=$(this).data("ids"),i=$("#_token").val(),t=$(this).attr("href");return!!confirm("确认执行此操作?")&&($.post(t,{ids:e,_token:i},function(e){if(1==e.status)for(var i=0;i<e.data.length;i++)$("#item-"+e.data[i]).remove();else alert(e.message)},"json"),!1)})},kingfisher.create_cookie=function(e,i,t,r,n){var a="",o="";if(t){var s=new Date;s.setTime(s.getTime()+24*t*60*60*1e3),o="; expires="+s.toGMTString()}r=r?"; domain="+r:"",n="; path="+(n?n:"/"),document.cookie=e+"="+i+o+n+r+a},kingfisher.read_cookie=function(e){for(var i=e+"=",t=document.cookie.split(";"),r=0;r<t.length;r++){var n=t[r].replace(/^\s+/,"");if(0==n.indexOf(i))return n.substring(i.length)}return null},kingfisher.erase_cookie=function(e,i,t){create_cookie(e,"",-1,i,t)},kingfisher.record_asset_id=function(e,i){var t=$("#"+e).val();0==t.length?t=i:t.indexOf(i)==-1&&(t+=","+i),$("#"+e).val(t)},kingfisher.remove_asset_id=function(e,i){var t=$("#"+e).val(),r=t.split(","),n=kingfisher.in_array(r,i);r.splice(n,1),t=r.join(","),$("#"+e).val(t)},kingfisher.in_array=function(e,i){var t;for(t=0;t<e.length;t++)if(i===e[t])return t;return-1};
=======
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
kingfisher.initial = function(){

  // 全局去掉ajax cache
  $.ajaxSetup({cache:false});
	
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

>>>>>>> cbd00582f3bd39ae9ea634f6a8872735d2d7f87d
