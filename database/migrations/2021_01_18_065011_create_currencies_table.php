<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        $codes = ['INR', 'GBP', 'EUR'];
        $countries = ['UAE', 'United Kingdom', 'Spain'];
        $names = ['Dirhams', 'British Pound', 'Euro'];
        foreach ($codes as $i => $code) {
            \App\Models\Currency::create([
                'code'    => $code,
                'name'    => $names[$i],
                'country' => $countries[$i],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
