<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNiftyAssistants3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->integer('is_approved')->change();
            $table->renameColumn('is_approved', 'status');
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
            $table->renameColumn('status', 'is_approved');
        });
    }
}
