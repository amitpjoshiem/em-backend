<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMembersEmail extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->boolean('retired')->default(false)->change();
            $table->boolean('married')->default(false)->change();
        });
    }

    public function down(): void
    {
    }
}
