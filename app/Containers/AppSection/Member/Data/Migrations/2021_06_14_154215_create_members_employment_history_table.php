<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersEmploymentHistoryTable extends Migration
{
    public function up(): void
    {
        Schema::create('member_employment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('occupation');
            $table->integer('years');
            $table->morphs('memberable');
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
}
