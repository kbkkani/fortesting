<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('instance_id');
            $table->date('start_date');
            $table->string('type');
            $table->text('timing');
            $table->text('location');
            $table->string('delivery_mothod');
            $table->string('price');
            $table->string('space_available');
            $table->text('enrol_now');
            $table->integer('type_id');
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
        Schema::drop('courses');
    }
}
