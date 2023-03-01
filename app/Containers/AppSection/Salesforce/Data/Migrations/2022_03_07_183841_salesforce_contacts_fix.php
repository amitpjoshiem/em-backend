<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SalesforceContactsFix extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_contacts', function (Blueprint $table) {
            $table->integer('contact_id');
        });
    }

    public function down(): void
    {
    }
}
