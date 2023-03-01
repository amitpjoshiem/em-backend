<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocusignEnvelopsTable extends Migration
{
    public function up(): void
    {
        Schema::create('docusign_envelops', function (Blueprint $table) {
            $table->id();
            $table->morphs('document');
            $table->bigInteger('advisor_recipient_id');
            $table->bigInteger('client_recipient_id');
            $table->string('envelop_id');
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docusign_envelops');
    }
}
