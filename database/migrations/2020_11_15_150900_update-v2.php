<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assistant_types', function (Blueprint $table) {
            $table->dropColumn('slogan', 'cost_per_hour');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('details', 'name');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('location', 'approx_duration');
        });

        Schema::drop('nifty_types');
        Schema::drop('nifty_ranks');

        $tables = ['nifty_specialities', 'nifty_assistants', 'appointment_tasks', 'appointments',];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
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
