<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nifty_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nifty_assistant_id')->references('id')->on('nifty_assistants')->cascadeOnDelete();
            $table->string('name');
            $table->string('path');
            $table->timestamps();
        });
        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->dropColumn('freelance_licence', 'cv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nifty_files');
    }
}
