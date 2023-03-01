<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpSecuritiesEnable extends Migration
{
    public function up(): void
    {
        Schema::table('otp_securities', function (Blueprint $table) {
            $table->boolean('enabled')->default(true);
        });
    }

    public function down(): void
    {
    }
}
