<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceTemporaryExportsTable extends Migration
{
    public function up(): void
    {
        Schema::rename('salesforce_exports', 'salesforce_temporary_exports');

        Schema::table('salesforce_temporary_exports', function (Blueprint $table) {
            $table->dropColumn('salesforce_id');
        });
    }

    public function down(): void
    {
        Schema::rename('salesforce_temporary_exports', 'salesforce_exports');

        Schema::table('salesforce_temporary_exports', function (Blueprint $table) {
            $table->string('salesforce_id');
        });
    }
}
