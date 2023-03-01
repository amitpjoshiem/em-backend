<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientReportsColumns extends Migration
{
    public function up(): void
    {
        Schema::table('client_reports', function (Blueprint $table) {
            $table->string('carrier')->nullable()->change();
            $table->decimal('current_value', 10, 3)->nullable()->change();
            $table->decimal('surrender_value', 10, 3)->nullable()->change();
            $table->decimal('origination_value', 10, 3)->nullable()->change();
            $table->datetime('origination_date')->nullable()->change();

            $table->decimal('current_interest_credited', 10, 3)->nullable();
            $table->decimal('withdrawals', 10, 3)->nullable();
            $table->decimal('total_premiums', 10, 3)->nullable();
            $table->decimal('bonus_received', 10, 3)->nullable();
            $table->decimal('since_interest_credited', 10, 3)->nullable();
            $table->decimal('total_withdrawals', 10, 3)->nullable();
            $table->decimal('total_fees', 10, 3)->nullable();
            $table->decimal('rmd_or_sys_wd', 10, 3)->nullable();
            $table->boolean('is_custom')->default(false);

            $table->unique(['contract_number', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::table('client_reports', function (Blueprint $table) {
            $table->dropColumn('current_interest_credited');
            $table->dropColumn('withdrawals');
            $table->dropColumn('total_premiums');
            $table->dropColumn('bonus_received');
            $table->dropColumn('since_interest_credited');
            $table->dropColumn('total_withdrawals');
            $table->dropColumn('total_fees');
            $table->dropColumn('rmd_or_sys_wd');
        });
    }
}
