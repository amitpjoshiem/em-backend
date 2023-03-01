<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityLogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('entity_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('loggable_id');
            $table->string('loggable_type');
            $table->string('action');
            $table->text('before')->nullable();
            $table->text('after')->nullable();
            $table->datetime('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_logs');
    }
}
