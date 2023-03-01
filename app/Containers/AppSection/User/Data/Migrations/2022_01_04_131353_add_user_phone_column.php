<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserPhoneColumn extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->default(null);
            $table->timestamp('phone_verified_at')->nullable()->default(null);
            $table->string('npn')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::table('phone', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('phone_verified_at');
            $table->dropColumn('npn');
        });
    }
}
