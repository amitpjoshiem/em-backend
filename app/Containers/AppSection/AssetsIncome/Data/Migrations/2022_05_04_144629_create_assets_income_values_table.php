<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsIncomeValuesTable extends Migration
{
    public function up(): void
    {
        Schema::create('assets_income_values', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id');
            $table->string('group');
            $table->string('row');
            $table->string('element');
            $table->string('type');
            $table->string('value');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets_income_values');
    }
}
