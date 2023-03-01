<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceExportExceptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_export_exceptions', function (Blueprint $table) {
            $table->id();
            $table->morphs('object');
            $table->json('request');
            $table->json('response');
            $table->string('method');
            $table->text('trace');
            $table->string('url');
            $table->timestamps();
        });

        Schema::table('salesforce_attachments', function (Blueprint $table) {
            $table->integer('user_id')->change();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_import_exceptions');
    }
}
