<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SalesforceChildOppFix extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE salesforce_child_opportunities CHANGE close_date close_date TIMESTAMP NULL DEFAULT NULL');
        Schema::table('salesforce_child_opportunities', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
            $table->string('stage')->nullable()->change();
            $table->decimal('amount', 10, 3)->nullable()->change();
        });
    }

    public function down(): void
    {
    }
}
