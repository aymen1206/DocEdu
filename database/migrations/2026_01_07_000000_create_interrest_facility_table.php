<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('interrsted_facilities', function (Blueprint $table) {
        $table->increments('id')->unsigned();
        $table->text('facility_name');
        $table->text('responseble');
        $table->text('guardian_phone'); 
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
         Schema::dropIfExists('interrsted_facilities');
       
    }
};