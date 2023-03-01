<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToClientDocsAdditionalInfo extends Migration
{
    public function up(): void
    {
        Schema::table('client_docs_additional_info', function (Blueprint $table) {
            $table->string('type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('client_docs_additional_info', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
