<?php

use App\Models\NiftyAssistant;
use App\Models\NiftyGig;
use App\Models\NiftyResource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiftyGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('nifty_gigs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nifty_assistant_id')->references('id')->on('nifty_assistants')->cascadeOnDelete();
            $table->foreignId('assistant_type_id')->references('id')->on('assistant_types')->cascadeOnDelete();
            $table->text('about_me')->nullable();
            $table->timestamps();
        });

        Schema::table('nifty_resources', function (Blueprint $table) {
            $table->foreignId('nifty_gig_id')
                ->after('nifty_assistant_id')->references('id')->on('nifty_gigs')->cascadeOnDelete();
        });

        $niftys = NiftyAssistant::all();
        foreach ($niftys as $nifty) {
            foreach ($nifty->specialities_array() as $type) {
                $gig = $nifty->gig()->create([
                    'nifty_assistant_id' => $nifty->id,
                    'assistant_type_id'  => $type,
                    'about_me'           => $nifty->about_me,
                ]);
                foreach ($nifty->resources as $resource) {
                    $resource->update([
                        'nifty_gig_id'  => $gig->id,
                    ]);
                }
            }
        }

        Schema::table('nifty_resources', function (Blueprint $table) {
            $table->dropForeign(['nifty_assistant_id']);
            $table->dropColumn('nifty_assistant_id');
        });

        Schema::table('nifty_assistants', function (Blueprint $table) {
            $table->dropColumn('about_me');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nifty_gigs');
    }
}
