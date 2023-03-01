<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorAssistantTable extends Migration
{
    public function up(): void
    {
        Schema::create('advisor_assistant', function (Blueprint $table) {
            $table->id();
            $table->integer('advisor_id');
            $table->integer('assistant_id');
        });
    }

    public function down(): void
    {
        Schema::drop('advisor_assistant');
    }
}
