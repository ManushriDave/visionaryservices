<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNiftyPrivates1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nifty_privates', function (Blueprint $table) {
            $table->string('source')->nullable()->change();
            $table->string('highest_education')->nullable()->change();
            $table->string('graduation_year')->nullable()->change();
            $table->string('college_name')->nullable()->change();
            $table->string('college_city')->nullable()->change();
            $table->string('college_country')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nifty_privates', function (Blueprint $table) {
            //
        });
    }
}
