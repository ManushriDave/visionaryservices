<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssistantTypeToNiftyServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('nifty_services', function (Blueprint $table) {
            $table->foreignId('assistant_type_id')
                ->after('nifty_assistant_id')
                ->references('id')
                ->on('assistant_types')
                ->cascadeOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nifty_services', function (Blueprint $table) {
            $table->dropForeign(['assistant_type_id']);
            $table->dropColumn('assistant_type_id');
        });
    }
}
