<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables_to_drop = ['nifty_packages', 'package_types',];
        foreach ($tables_to_drop as $table) {
            Schema::drop($table);
        }

        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->decimal('lat', 10, 8)->after('nationality');
            $table->decimal('long', 10, 8)->after('lat');
            $table->foreignId('nifty_rank_id')->after('long')->references('id')->on('nifty_ranks');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('advance_payment', 10, 8)->after('appointment_id');
            $table->dropColumn('nifty_commission');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->decimal('lat', 10, 8)->after('time');
            $table->decimal('long', 10, 8)->after('lat');
            $table->renameColumn('extra_details', 'details');
            $table->dropColumn('documents', 'total');
            $table->integer('emirate_id')->nullable()->change();
            $table->foreignId('nifty_service_id')->after('nifty_assistant_id')->references('id')->on('nifty_services');
        });

        Schema::rename('nifty_files', 'nifty_documents');
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
