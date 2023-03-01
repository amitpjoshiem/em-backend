<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceTemporaryImportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_temporary_imports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('owner_id')->nullable();
            $table->string('salesforce_id')->nullable();
            $table->string('object');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_users');
    }
}
