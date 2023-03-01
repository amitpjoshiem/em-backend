<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatisticsDates extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dateTime('first_fill_info')->nullable();
            $table->dateTime('converted_from_lead')->nullable();
            $table->dateTime('closed_win_lost')->nullable();
        });
    }

    public function down(): void
    {
    }
}
