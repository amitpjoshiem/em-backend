<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlueprintNetworthsTable extends Migration
{
    public function up(): void
    {
        Schema::create('blueprint_networths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->decimal('market', 10, 3)->nullable();
            $table->decimal('liquid', 10, 3)->nullable();
            $table->decimal('income_safe', 10, 3)->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blueprint_networths');
    }
}
