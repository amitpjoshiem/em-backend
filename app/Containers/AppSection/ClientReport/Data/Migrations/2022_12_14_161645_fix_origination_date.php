<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixOriginationDate extends Migration
{
    public function up(): void
    {
        Schema::table('client_reports', function (Blueprint $table) {
            $table->datetime('origination_date')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
    }
}
