<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDelete extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_contacts', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('salesforce_opportunities', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('salesforce_child_opportunities', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('salesforce_accounts', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
    }
}
