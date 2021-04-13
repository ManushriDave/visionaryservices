<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAppointments4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign('appointments_nifty_assistant_id_foreign');
            $table->dropColumn('nifty_assistant_id');
            $table->dropForeign('appointments_assistant_type_id_foreign');
            $table->dropColumn('assistant_type_id');
            $table->boolean('vehicle_needed')->default(0)->after('time');
            $table->time('approx_duration')->after('vehicle_needed');
            $table->time('actual_duration')->after('approx_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('nifty_assistant_id');
            $table->string('assistant_type_id');
            $table->dropColumn('vehicle_needed', 'approx_duration', 'actual_duration');
        });
    }
}
