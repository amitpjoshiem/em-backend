<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientConfirmationTable extends Migration
{
    public function up(): void
    {
        Schema::create('client_confirmations', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('item');
            $table->boolean('value');
            $table->foreignId('member_id');
            $table->foreignId('client_id');
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->string('consultation')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_confirmations');
    }
}
