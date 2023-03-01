<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlueprintConcernsTable extends Migration
{
    public function up(): void
    {
        Schema::create('blueprint_concerns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->boolean('high_fees')->default(false);
            $table->boolean('extremely_high_market_exposure')->default(false);
            $table->boolean('simple')->default(false);
            $table->boolean('keep_the_money_safe')->default(false);
            $table->boolean('massive_overlap')->default(false);
            $table->boolean('design_implement_monitoring_income_strategy')->default(false);
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blueprint_concerns');
    }
}
