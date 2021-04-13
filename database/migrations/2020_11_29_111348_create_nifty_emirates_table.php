<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyEmiratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nifty_emirates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nifty_assistant_id')->references('id')->on('nifty_assistants')->cascadeOnDelete();
            $table->foreignId('emirate_id')->references('id')->on('emirates')->cascadeOnDelete();
            $table->timestamps();
        });
        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->dropColumn('emirate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nifty_emirates');
    }
}
