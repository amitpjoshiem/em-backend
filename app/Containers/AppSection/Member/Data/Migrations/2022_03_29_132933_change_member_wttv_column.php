<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMemberWttvColumn extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->removeColumn('wttv4_or_fox59');
            $table->string('channels')->nullable();
            $table->string('is_watch')->default(false);
        });
    }

    public function down(): void
    {
    }
}
