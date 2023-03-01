<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceAccountsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->index();
            $table->string('salesforce_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_accounts');
    }
}
