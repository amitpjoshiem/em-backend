<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJoinedAssetsIncomeValuesTable extends Migration
{
    public function up(): void
    {
        Schema::table('assets_income_values', function (Blueprint $table) {
            $table->boolean('joined')->default(false);
            $table->string('value')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('assets_income_values', function (Blueprint $table) {
            $table->dropColumn('joined');
        });
    }
}
