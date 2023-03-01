<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToMember extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->decimal('total_net_worth', 10, 3)->nullable()->default(null);
            $table->decimal('goal', 10, 3)->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('total_net_worth');
            $table->dropColumn('goal');
        });
    }
}
