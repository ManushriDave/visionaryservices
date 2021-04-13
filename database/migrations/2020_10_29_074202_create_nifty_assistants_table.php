<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nifty_assistants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->boolean('gender');
            $table->date('dob');
            $table->string('nationality', 25);
            $table->string('known_languages');
            $table->string('phone', 25);
            $table->boolean('has_driving_licence')->default(0);
            $table->boolean('has_own_transportation')->default(0);
            $table->mediumText('availability');
            $table->string('experience', 25);
            $table->string('email')->unique();
            $table->string('pa');
            $table->string('cv');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_approved')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('nifty_assistants');
    }
}
