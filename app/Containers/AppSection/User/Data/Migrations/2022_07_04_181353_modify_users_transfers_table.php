<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTransfersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users_transfers', function (Blueprint $table) {
            $table->string('model_repository');
            $table->bigInteger('model_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_transfers');
    }
}
