var kingfisher={visitor:{},url:{}};kingfisher.initial=function(){$.ajaxSetup({cache:!1}),$("a.confirm-request").livequery(function(){$(this).click(function(){return confirm("确认执行这个操作吗?")&&$.get($(this).attr("href")),!1})}),$("a.ajax").livequery(function(){$(this).click(function(){var e=$(this).attr("href");return $.get(e),!1})}),$("a.delete-btn").click(function(){var e=$(this).data("ids"),t=$("#_token").val(),i=$(this).attr("href");return!!confirm("确认执行此操作?")&&($.post(i,{ids:e,_token:t},function(e){if(1==e.status)for(var t=0;t<e.data.length;t++)$("#item-"+e.data[t]).remove();else alert(e.message)},"json"),!1)}),$(".close").click(function(){$("#warning").hide()}),$("input.price").livequery(function(){$(this).css("ime-mode","disabled").keypress(function(){46!=event.keyCode&&(event.keyCode<48||event.keyCode>57)&&(event.returnValue=!1)})}),$("#checkAll").livequery(function(){$(this).click(function(){$("input[name='Order']:checkbox").prop("checked",this.checked)})}),$("input[name='Order']:checkbox").click(function(){$("#checkAll").prop("checked","")}),$(".scrollt tbody tr").livequery(function(){$(this).click(function(){0==$(this).find("input[name='Order']").attr("active")?$(this).find("input[name='Order']").prop("checked","checked").attr("active","1"):$(this).find("input[name='Order']").prop("checked","").attr("active","0")})}),$(".scrolltt tbody tr").livequery(function(){$(this).click(function(){0==$(this).find("input[name='Order']").attr("active")?($(".scrolltt").find("input[name='Order']").prop("checked","").attr("active","0"),$(this).find("input[name='Order']").prop("checked","checked").attr("active","1")):($(".scrolltt").find("input[name='Order']").prop("checked","").attr("active","0"),$(this).find("input[name='Order']").prop("checked","").attr("active","0"))})}),$(".scroll tbody tr td").click(function(){var e=($(this).parent().children().length-1,$(this).attr("tdr"));"nochect"==e?0==$(this).siblings().find("input[name='Order']").attr("active")?$(this).siblings().find("input[name='Order']").prop("checked","").attr("active","0"):$(this).siblings().find("input[name='Order']").prop("checked","checked").attr("active","1"):1==$(this).siblings().find("input[name='Order']").attr("active")?$(this).siblings().find("input[name='Order']").prop("checked","").attr("active","0"):$(this).siblings().find("input[name='Order']").prop("checked","checked").attr("active","1")}),$(".order-list #label-user").livequery(function(){$(this).click(function(){$(".order-list #form-user").removeAttr("style"),$(".order-list #form-product,.order-list #form-jyi,.order-list #form-beiz").css("display","none")})}),$(".order-list #label-product").livequery(function(){$(this).click(function(){$(".order-list #form-product").removeAttr("style"),$(".order-list #form-user,.order-list #form-jyi,.order-list #form-beiz").css("display","none")})}),$(".order-list #label-jyi").livequery(function(){$(this).click(function(){$(".order-list #form-jyi").removeAttr("style"),$(".order-list #form-product,.order-list #form-user,.order-list #form-beiz").css("display","none")})}),$(".order-list #label-beiz").livequery(function(){$(this).click(function(){$(".order-list #form-beiz").removeAttr("style"),$(".order-list #form-user,.order-list #form-jyi,.order-list #form-product").css("display","none")})}),$(".selectpicker").livequery(function(){$(".selectpicker").selectpicker({noneSelectedText:"==请选择=="})}),$(".pickdatetime").datetimepicker({format:"yyyy-mm-dd",autoclose:!0,todayBtn:!0,startView:"month",minView:"month",maxView:"decade"})},kingfisher.create_cookie=function(e,t,i,r,n){var a="",o="";if(i){var c=new Date;c.setTime(c.getTime()+24*i*60*60*1e3),o="; expires="+c.toGMTString()}r=r?"; domain="+r:"",n="; path="+(n?n:"/"),document.cookie=e+"="+t+o+n+r+a},kingfisher.read_cookie=function(e){for(var t=e+"=",i=document.cookie.split(";"),r=0;r<i.length;r++){var n=i[r].replace(/^\s+/,"");if(0==n.indexOf(t))return n.substring(t.length)}return null},kingfisher.erase_cookie=function(e,t,i){create_cookie(e,"",-1,t,i)},kingfisher.record_asset_id=function(e,t){var i=$("#"+e).val();0==i.length?i=t:i.indexOf(t)==-1&&(i+=","+t),$("#"+e).val(i)},kingfisher.remove_asset_id=function(e,t){var i=$("#"+e).val(),r=i.split(","),n=kingfisher.in_array(r,t);r.splice(n,1),i=r.join(","),$("#"+e).val(i)},kingfisher.in_array=function(e,t){var i;for(i=0;i<e.length;i++)if(t===e[i])return i;return-1},kingfisher.user_avatar_upload=function(e,t,i){var r=$("#_token").val();new qq.FineUploader({element:document.getElementById("fine-user-uploader"),autoUpload:!0,request:{endpoint:i,params:{token:t,"x:user_id":e},inputName:"file"},validation:{allowedExtensions:["jpeg","jpg","png"],sizeLimit:3145728},callbacks:{onComplete:function(e,t,i){i.success?($("#cover_id").val(i.asset_id),$("#upload-result").append('<div class="asset"><img src="'+i.name+'" style="width: 100px;" class="img-thumbnail"><a class="removeimg" value="'+i.asset_id+'">删除</a></div>'),$(".removeimg").click(function(){var e=$(this).attr("value"),t=$(this);$.ajax({type:"post",url:"/asset/ajaxDelete",data:{id:e,_token:r},dataType:"json",success:function(e){e.status&&t.parent().remove()}})})):alert("上传图片失败")}}})},kingfisher.provinceList=function(e){$.get("/ajaxFetchCity",{oid:e,layer:2},function(e){if(e.status){var t='{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}',i=Mustache.render(t,e);$("#city_id").html(i).selectpicker("refresh"),$.get("/ajaxFetchCity",{oid:e.data[0].oid,layer:3},function(e){if(e.status){var t='{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}',i=Mustache.render(t,e);$("#county_id").html(i).selectpicker("refresh"),$.get("/ajaxFetchCity",{oid:e.data[0].oid,layer:4},function(e){if(e.status){var t='{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}',i=Mustache.render(t,e);$("#township_id").html(i).selectpicker("refresh")}},"json")}},"json")}},"json")},kingfisher.cityList=function(e){$.get("/ajaxFetchCity",{oid:e,layer:3},function(e){if(e.status){var t='{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}',i=Mustache.render(t,e);$("#county_id").html(i).selectpicker("refresh"),$.get("/ajaxFetchCity",{oid:e.data[0].oid,layer:4},function(e){if(e.status){var t='{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}',i=Mustache.render(t,e);$("#township_id").html(i).selectpicker("refresh")}},"json")}},"json")},kingfisher.countyList=function(e){$.get("/ajaxFetchCity",{oid:e,layer:4},function(e){if(e.status){var t='{{ #data }}<option class="province" value="{{name}}" oid="{{oid}}">{{name}}</option>{{ /data }}',i=Mustache.render(t,e);$("#township_id").html(i).selectpicker("refresh")}else $("#township_id").html("").selectpicker("refresh")},"json")};