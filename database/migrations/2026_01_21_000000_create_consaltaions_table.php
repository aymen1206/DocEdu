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
        Schema::create('consaltaions', function (Blueprint $table) {
        $table->increments('id')->unsigned();
        $table->integer('st_id')->default(0);
        $table->text('st_name');
        $table->text('time');
        $table->text('amount');
        $table->text('st_phone');
        $table->enum('status',['new','done','canceled'])->default(null)->nullable();
        $table->text('note');
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
         Schema::dropIfExists('consaltaions');
       
    }
};