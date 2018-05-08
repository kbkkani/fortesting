<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoporateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('coporate_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('business_name');
            $table->string('contact_no');
            $table->string('email');
            $table->string('pointof_fname_and_lastname');
            $table->string('pointof_email');
            $table->string('prefix_code');
            $table->string('isage')->nullable()->default(0);
            $table->text('agreement_text');
            $table->string('logo');
            $table->string('header_color');
            $table->string('footer_color');
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
        Schema::drop('coporate_clients');
    }
}
