<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageTypeToMaterialLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_libraries', function (Blueprint $table) {
            $table->tinyInteger('image_type')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_libraries', function (Blueprint $table) {
            $table->dropColumn(['image_type']);
        });
    }
}
