<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nifty_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nifty_assistant_id')->references('id')->on('nifty_assistants')->cascadeOnDelete();
            $table->foreignId('package_type_id')->references('id')->on('package_types')->cascadeOnDelete();
            $table->decimal('cost', 9, 2);
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
        Schema::dropIfExists('nifty_packages');
    }
}
