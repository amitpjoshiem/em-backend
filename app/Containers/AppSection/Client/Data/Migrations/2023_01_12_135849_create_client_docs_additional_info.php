<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDocsAdditionalInfo extends Migration
{
    public function up(): void
    {
        Schema::create('client_docs_additional_info', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('media_id');
            $table->bigInteger('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('description')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('client_docs_additional_info');
    }
}
