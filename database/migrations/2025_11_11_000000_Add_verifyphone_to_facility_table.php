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
         Schema::table('edu_facilities', function($table) {
        $table->string('phone_verify')->default("");
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('edu_facilities', function($table) {
        $table->dropColumn('phone_verify');
    });
    }
};