<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomNameToAttachmentsTable extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_attachments', function (Blueprint $table) {
            $table->string('custom_name')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('salesforce_attachments', function (Blueprint $table) {
            $table->dropColumn('custom_name');
        });
    }
}
