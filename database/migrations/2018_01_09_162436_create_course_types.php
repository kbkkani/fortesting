<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('code');
            $table->string('delivery');
            $table->string('instance_id');
            $table->tinyInteger('is_active');
            $table->text('short_desc');
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
        Schema::drop('course_types');
    }
}
