<script id="user_show_tmp" type="text-x-mustache-tmpl">
<div>
    @{{ #user }}
    <div class="row">
        <div class="col-lg-6">账户：@{{ account }}</div>
        <div class="col-lg-6">手机号：@{{ phone }}</div>
    </div>
    @{{ /user }}
    {{--<div class="row">--}}
        {{--<div class="col-lg-6">资料审核：</div>--}}
        {{--<div class="col-lg-6">账户状态：</div>--}}
    {{--</div>--}}
    <hr>
    @{{ #distributor }}
    <div class="row">
        <div class="col-lg-6">公司简称：@{{ name }}</div>
        <div class="col-lg-6">公司全称：@{{ company }}</div>
    </div>
    <div class="row">
        <div class="col-lg-10">公司简介：@{{ introduction }}</div>
        <div class="col-lg-10">主营类目：@{{ main }}</div>
        <div class="col-lg-10">创建时间：@{{ create_time }}</div>
    </div>

    <div class="row">
        <div class="col-lg-6">企业类型：@{{ company_type_value }}</div>
        <div class="col-lg-6">统一社会信用代码：@{{ registration_number }}</div>
        @{{ #document_image }}
        <div class="col-lg-3">
            <a target="_blank" href="@{{ srcfile }}">
                <img src="@{{ srcfile }}" class="img-responsive"
                     alt="Responsive image">
            </a>
        </div>
        @{{ /document_image }}

    </div>

    <hr>
    <div class="row">
        <div class="col-lg-6"><span>法人姓名：</span>@{{ legal_person }}</div>
    </div>
    <div class="row">
        <div class="col-lg-6">证件类型：@{{ document_type_value }}</div>
        <div class="col-lg-6">证件号码：@{{ document_number }}</div>

        @{{ #license_image }}
        <div class="col-lg-3">
            <a target="_blank" href="@{{ srcfile }}">
                <img src="@{{ srcfile }}" class="img-responsive"
                     alt="Responsive image">
            </a>
        </div>
        @{{ /license_image }}
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-6">职位：@{{ position }}</div>
        <div class="col-lg-6">联系人：@{{ contact_name }}</div>
    </div>
    <div class="row">
        <div class="col-lg-6">电话：@{{ contact_phone }}</div>
        <div class="col-lg-6">邮箱：@{{ email }}</div>
    </div>
    <div class="row">
        <div class="col-lg-6">qq：@{{ contact_qq }}</div>
    </div>

    @{{ /distributor }}
</div>
</script>