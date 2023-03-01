<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYodleeMembersTable extends Migration
{
    public function up(): void
    {
        Schema::create('yodlee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->integer('yodlee_id');
            $table->string('login_name');
            $table->boolean('link_sent')->default(false);
            $table->timestamp('link_expired')->nullable()->default(null);
            $table->boolean('link_used')->default(false);
            $table->timestamps();
//            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yodlee_members');
    }
}
