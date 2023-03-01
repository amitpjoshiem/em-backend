<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTransfersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users_transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_id');
            $table->bigInteger('to_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_transfers');
    }
}
