<?php

use App\Models\NiftyAssistant;
use App\Models\NiftyGig;
use App\Models\NiftyService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGigsWithServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        $services = NiftyService::all();
        foreach ($services as $service) {
            if ($service->assistant_type_id == 0) {
                continue;
            }
            if (!NiftyGig::where([
                'nifty_assistant_id' => $service->nifty_assistant_id,
                'assistant_type_id'  => $service->assistant_type_id,
            ])->exists()) {
                NiftyGig::create([
                    'nifty_assistant_id' => $service->nifty_assistant_id,
                    'assistant_type_id'  => $service->assistant_type_id,
                ]);
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nifty_gigs', function (Blueprint $table) {
            //
        });
    }
}
