<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceContactsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('salesforce_id');
            $table->foreignId('salesforce_account_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_contacts');
    }
}
