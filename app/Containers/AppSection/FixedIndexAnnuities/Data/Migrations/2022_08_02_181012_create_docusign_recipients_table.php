<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocusignRecipientsTable extends Migration
{
    public function up(): void
    {
        Schema::create('docusign_recipients', function (Blueprint $table) {
            $table->id();
            $table->morphs('recipient');
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docusign_recipients');
    }
}
