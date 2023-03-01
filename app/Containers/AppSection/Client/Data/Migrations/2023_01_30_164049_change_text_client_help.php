<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTextClientHelp extends Migration
{
    public function up(): void
    {
        Schema::table('client_help', function (Blueprint $table) {
            $table->text('text')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('client_help', function (Blueprint $table) {
            $table->string('text')->change();
        });
    }
}
