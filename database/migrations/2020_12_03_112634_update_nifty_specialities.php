<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNiftySpecialities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\NiftySpeciality::truncate();
        Schema::table('nifty_specialities', function (Blueprint $table) {
            $table->dropColumn('assistant_type_id');
            $table->foreignId('task_id')->after('nifty_assistant_id')->references('id')->on('tasks')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nifty_specialities', function (Blueprint $table) {
            //
        });
    }
}
