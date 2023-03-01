<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberReportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('member_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->json('success_emails');
            $table->json('error_emails');
            $table->foreignId('file_id');
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_reports');
    }
}
