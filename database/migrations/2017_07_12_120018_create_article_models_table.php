<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',50);
            $table->text('content');
            $table->string('author',20);
            $table->date('article_time',20);
            $table->tinyInteger('article_type')->default(0);
            $table->string('product_number',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_models');
    }
}
