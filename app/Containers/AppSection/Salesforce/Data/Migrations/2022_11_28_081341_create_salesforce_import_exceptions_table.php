<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceImportExceptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_import_exceptions', function (Blueprint $table) {
            $table->id();
            $table->string('salesforce_id')->nullable();
            $table->string('object')->nullable();
            $table->json('salesforce_data')->nullable();
            $table->text('trace');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_import_exceptions');
    }
}
