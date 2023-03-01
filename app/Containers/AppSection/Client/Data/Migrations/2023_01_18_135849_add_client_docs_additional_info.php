<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientDocsAdditionalInfo extends Migration
{
    public function up(): void
    {
        Schema::table('client_docs_additional_info', function (Blueprint $table) {
            $table->boolean('is_spouse')->default(false);
        });
    }

    public function down(): void
    {
        Schema::drop('client_docs_additional_info');
    }
}
