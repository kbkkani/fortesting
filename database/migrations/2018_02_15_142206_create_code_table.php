<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code', function (Blueprint $table) {
            $table->increments('id');
            $table->string('couponcode');
            $table->string('customer_ref');
            $table->string('max_value');
            $table->string('contact_fname');
            $table->string('contact_lname');
            $table->integer('enrolmentid')->nullable();
            $table->string('invoiceid')->nullable();
            $table->Integer('instanceid')->nullable();
            $table->integer('contactid')->nullable();
            $table->string('expires');
            $table->string('price')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->string('field1');
            $table->string('field2');
            $table->string('field3');
            $table->string('field4');
            $table->string('field5');
            $table->integer('open')->default(0);
            $table->integer('flag')->default(0);
            $table->dateTime('deleted_at');
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
        //
    }
}
