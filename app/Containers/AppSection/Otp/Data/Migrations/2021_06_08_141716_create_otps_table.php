<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->uuid('external_token');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('oauth_access_token_id', 100)->nullable()->index();
            $table->boolean('revoked')->default(false)->index();
            $table->timestamps();
            $table->dateTime('expires_at')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
}
