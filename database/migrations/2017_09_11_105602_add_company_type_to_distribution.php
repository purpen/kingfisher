<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyTypeToDistribution extends Migration
{

//    企业证件类型   company_type  企业类型：1.普通；2.多证合一（不含社会统一信用代码）；3.多证合一
//    统一社会信用代码 20  registration_number
//    法人姓名 20   legal_person
//    法人证件类型 document_type  法人证件类型：1.身份证；2.港澳通行证；3.台胞证；4.护照；
//    证件号码 20 document_number
//    邮箱 50 email
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution', function (Blueprint $table) {
            $table->tinyInteger('company_type')->default(0);
            $table->string('registration_number', 20)->default('');
            $table->string('legal_person', 20)->default('');
            $table->tinyInteger('document_type')->default(0);
            $table->string('document_number', 20)->default('');
            $table->string('email', 50)->default('');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution', function (Blueprint $table) {
            $table->dropColumn(['distribution', 'company_type', 'registration_number', 'legal_person', 'document_type', 'document_number', 'email']);
        });
    }
}
