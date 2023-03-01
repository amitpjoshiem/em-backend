<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientHelp extends Migration
{
    public function up(): void
    {
        Schema::create('client_help', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('type')->unique();
        });
    }

    public function down(): void
    {
        Schema::drop('client_help');
    }
}
