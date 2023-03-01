<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceAttachmentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_attachments', function (Blueprint $table) {
            $table->id();
            $table->integer('object_id');
            $table->string('object_class');
            $table->integer('media_id');
            $table->string('salesforce_id')->nullable();
            $table->string('user_id');
        });
    }

    public function down(): void
    {
    }
}
