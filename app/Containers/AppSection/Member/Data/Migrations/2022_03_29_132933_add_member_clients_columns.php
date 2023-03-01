<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberClientsColumns extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('amount_for_retirement')->nullable();
            $table->text('biggest_financial_concern')->nullable();
        });
    }

    public function down(): void
    {
    }
}
