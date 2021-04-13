<?php

namespace Database\Seeders;

use App\Models\Emirate;
use Illuminate\Database\Seeder;

class EmirateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emirates = array("Abu Dhabi","Ajman","Dubai","Fujairah","Ras Al Khaimah","Sharjah","Umm Al Quwain");
        foreach ($emirates as $emirate) {
            Emirate::create([
                'name' => $emirate,
            ]);
        }
        //
    }
}
