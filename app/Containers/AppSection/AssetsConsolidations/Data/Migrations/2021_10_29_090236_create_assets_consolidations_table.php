<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsConsolidationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('assets_consolidations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->string('name')->nullable();
            $table->decimal('amount', 10, 3)->nullable();
            $table->decimal('management_expense', 5, 4)->nullable();
            $table->decimal('turnover', 5, 4)->nullable();
            $table->decimal('trading_cost', 5, 4)->nullable();
            $table->decimal('wrap_fee', 5, 4)->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets_consolidations');
    }
}
