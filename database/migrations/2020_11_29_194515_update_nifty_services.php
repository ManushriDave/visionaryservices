<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNiftyServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nifty_services', function (Blueprint $table) {
            $table->string('unit', 25)->after('cost_per_hour');
            $table->renameColumn('cost_per_hour', 'cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nifty_services', function (Blueprint $table) {
            //
        });
    }
}
