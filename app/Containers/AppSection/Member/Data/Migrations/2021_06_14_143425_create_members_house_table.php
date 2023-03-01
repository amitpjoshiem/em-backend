<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersHouseTable extends Migration
{
    public function up(): void
    {
        Schema::create('member_houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained();
            $table->string('type');
            $table->decimal('market_value', 13, 3)->nullable();
            $table->decimal('total_debt', 13, 3)->nullable();
            $table->decimal('remaining_mortgage_amount', 13, 3)->nullable();
            $table->decimal('monthly_payment', 13, 3)->nullable();
            $table->decimal('total_monthly_expenses', 13, 3)->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
}
