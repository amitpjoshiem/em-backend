<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceImportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_imports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('object');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_users');
    }
}
