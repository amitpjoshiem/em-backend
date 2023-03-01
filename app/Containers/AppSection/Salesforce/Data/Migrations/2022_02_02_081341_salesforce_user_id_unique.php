<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SalesforceUserIdUnique extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_users', function (Blueprint $table) {
            $table->string('salesforce_id')->unique()->change();
        });
    }

    public function down(): void
    {
    }
}
