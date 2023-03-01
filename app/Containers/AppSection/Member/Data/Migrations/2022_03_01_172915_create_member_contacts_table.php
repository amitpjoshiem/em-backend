<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberContactsTable extends Migration
{
    public function up(): void
    {
        Schema::drop('spouses');

        Schema::create('member_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->boolean('retired')->nullable();
            $table->string('name');
            $table->date('birthday')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('retirement_date')->nullable();
            $table->boolean('is_spouse')->default(false);
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_contacts');
    }
}
