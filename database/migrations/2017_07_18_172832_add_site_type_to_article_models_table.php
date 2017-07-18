<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteTypeToArticleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_models', function (Blueprint $table) {
            $table->tinyInteger('site_type')->default(1);
            $table->renameColumn('article_source', 'site_from');

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
            $table->dropColumn(['site_type']);
            $table->renameColumn('site_from', 'article_source');

        });
    }
}
