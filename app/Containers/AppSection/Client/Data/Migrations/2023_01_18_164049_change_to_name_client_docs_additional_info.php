<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeToNameClientDocsAdditionalInfo extends Migration
{
    public function up(): void
    {
        Schema::table('client_docs_additional_info', function (Blueprint $table) {
            $table->string('name');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
        });
    }

    public function down(): void
    {
        Schema::table('client_docs_additional_info', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name');
            $table->string('last_name');
        });
    }
}
