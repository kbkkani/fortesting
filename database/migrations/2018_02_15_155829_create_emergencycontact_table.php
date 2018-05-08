<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmergencycontactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergencycontact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emfname');
            $table->string('emsname');
            $table->string('emrelation');
            $table->string('emcontno');
            $table->longText('emsig');
            $table->string('eminst');
            $table->string('emContact');
            $table->timestamp('emdate');
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
        Schema::drop('emergencycontact');
    }
}
