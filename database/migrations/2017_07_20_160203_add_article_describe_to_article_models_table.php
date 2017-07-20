<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArticleDescribeToArticleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_models', function (Blueprint $table) {
            $table->string('article_describe',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_models', function (Blueprint $table) {
            $table->dropColumn(['article_describe']);

        });
    }
}
