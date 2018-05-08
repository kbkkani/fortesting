<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courseinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('code');
            $table->integer('cost');
            $table->smallInteger('count');
            $table->string('delivery');
            $table->text('description');
            $table->Integer('info_id');
            $table->string('is_active');
            $table->Integer('row_id');
            $table->text('short_description');
            $table->integer('update_cost');
            $table->integer('type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courseinfo');
    }
}
