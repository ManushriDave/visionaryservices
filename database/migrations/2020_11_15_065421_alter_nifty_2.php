<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNifty2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->decimal('cost_per_hour', 9, 2)->after('long');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->dropColumn('cost_per_hour');
        });
    }
}
