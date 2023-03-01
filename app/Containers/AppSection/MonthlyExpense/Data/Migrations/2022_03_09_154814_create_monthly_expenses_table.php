<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyExpensesTable extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('group')->nullable();
            $table->string('item');
            $table->decimal('essential', 10, 3)->nullable();
            $table->decimal('discretionary', 10, 3)->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_expenses');
    }
}
