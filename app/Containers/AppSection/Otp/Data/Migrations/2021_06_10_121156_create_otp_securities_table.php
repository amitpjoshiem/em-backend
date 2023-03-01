<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpSecuritiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('otp_securities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('secret');
            $table->string('service_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_securities');
    }
}
