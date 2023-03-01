<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MonthlyExpensesUnique extends Migration
{
    public function up(): void
    {
        Schema::table('monthly_expenses', function (Blueprint $table) {
            $table->unique(['member_id', 'group', 'item']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_expenses');
    }
}
