<?php
/**
 * 为会员账户字段添加唯一索引
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueIndexToOrderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_users', function (Blueprint $table) {
            $table->unique('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_users', function (Blueprint $table) {
            $table->dropUnique('account');
        });
    }
}
