<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlueprintMonthlyIncomesTable extends Migration
{
    public function up(): void
    {
        Schema::create('blueprint_monthly_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->decimal('current_member', 10, 3)->nullable();
            $table->decimal('current_spouse', 10, 3)->nullable();
            $table->decimal('current_pensions', 10, 3)->nullable();
            $table->decimal('current_rental_income', 10, 3)->nullable();
            $table->decimal('current_investment', 10, 3)->nullable();
            $table->decimal('future_member', 10, 3)->nullable();
            $table->decimal('future_spouse', 10, 3)->nullable();
            $table->decimal('future_pensions', 10, 3)->nullable();
            $table->decimal('future_rental_income', 10, 3)->nullable();
            $table->decimal('future_investment', 10, 3)->nullable();
            $table->decimal('tax', 10, 3)->nullable();
            $table->decimal('ira_first', 10, 3)->nullable();
            $table->decimal('ira_second', 10, 3)->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blueprint_monthly_incomes');
    }
}
