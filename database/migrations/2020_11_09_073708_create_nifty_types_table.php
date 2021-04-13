<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nifty_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nifty_assistant_id')->references('id')->on('nifty_assistants')->cascadeOnDelete();
            $table->foreignId('assistant_type_id')->references('id')->on('assistant_types')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nifty_types');
    }
}
