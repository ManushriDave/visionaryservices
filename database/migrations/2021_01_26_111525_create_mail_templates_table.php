<?php

use App\Enums\MailType;
use App\Models\MailTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('mail_type');
            $table->text('content');
            $table->string('heading_text');
            $table->string('btn_text')->nullable();
            $table->string('btn_link')->nullable();
            $table->timestamps();
        });

        foreach (MailType::asArray() as $template) {
            MailTemplate::create([
                'mail_type'      => $template,
                'content'        => '',
                'heading_text'   => '',
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
        Schema::dropIfExists('mail_templates');
    }
}
