<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersOtherTable extends Migration
{
    public function up(): void
    {
        Schema::create('member_others', function (Blueprint $table) {
            $table->id();
            $table->string('risk');
            $table->text('questions')->nullable();
            $table->text('retirement')->nullable();
            $table->text('retirement_money')->nullable();
            $table->boolean('work_with_advisor');
            $table->foreignId('member_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_others');
    }
}
