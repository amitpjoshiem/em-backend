<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableColumn extends Migration
{
    public function up(): void
    {
        Schema::table('assets_consolidations', function (Blueprint $table) {
            $table->integer('table')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('assets_consolidations', function (Blueprint $table) {
            $table->dropColumn('table');
        });
    }
}
