<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAssetAllocationsTable extends Migration
{
    public function up(): void
    {
        Schema::create('member_asset_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->decimal('liquidity', 10, 3)->nullable();
            $table->decimal('growth', 10, 3)->nullable();
            $table->decimal('income', 10, 3)->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_asset_allocations');
    }
}
