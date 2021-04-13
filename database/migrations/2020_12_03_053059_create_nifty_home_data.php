<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyHomeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nifty_home_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistant_type_id')->references('id')->on('assistant_types')->cascadeOnDelete();
            $table->string('bg_img', 50);
            $table->string('icon', 50);
            $table->timestamps();
        });

        $array = [
            0 => [
                'name' => 'Errand Nifty',
                'bg-img' => 'sc1.png',
                'icon' => 'icon-shopping-basket',
            ],
            1 => [
                'name' => 'Handyman Nifty',
                'bg-img' => 'handyman.jpg',
                'icon' => 'icon-paint-roller',
            ],
            2 => [
                'name' => 'Beauty & Personal Care Nifty',
                'bg-img' => 'beauty.jpg',
                'icon' => 'icon-diamond2',
            ],
            3 => [
                'name' => 'Health & Wellness Nifty',
                'bg-img' => 'gym.jpg',
                'icon' => 'icon-dumbbell',
            ],
            4 => [
                'name' => 'Elite Nifty',
                'bg-img' => 'sc3.png',
                'icon' => 'icon-plane',
            ],
            5 => [
                'name' => 'Education Nifty',
                'bg-img' => 'edu.jpg',
                'icon' => 'icon-book3',
            ],
            6 => [
                'name' => 'Entertainment Nifty',
                'bg-img' => 'gym.jpg',
                'icon' => 'icon-film',
            ],
            7 => [
                'name' => 'Name your Nifty',
                'bg-img' => 'gen.jpg',
                'icon' => 'icon-line-archive',
            ],
        ];
        foreach ($array as $i => $assistantType) {
            $nifty = \App\Models\AssistantType::where('name', '=', $assistantType['name'])->first();
            \App\Models\NiftyHomeData::create([
                'assistant_type_id' => $nifty->id,
                'bg_img'            => $assistantType['bg-img'],
                'icon'              => $assistantType['icon'],
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
        Schema::dropIfExists('nifty_home_data');
    }
}
