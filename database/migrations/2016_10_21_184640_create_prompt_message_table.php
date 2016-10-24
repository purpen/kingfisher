<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromptMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prompt_message', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->tinyInteger('type')->default(0);
            $table->string('message',50);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prompt_message');
    }
}
