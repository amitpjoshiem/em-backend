<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMembersContactIsSpouse extends Migration
{
    public function up(): void
    {
        Schema::table('member_contacts', function (Blueprint $table) {
            $table->boolean('is_spouse')->default(false)->change();
        });
    }

    public function down(): void
    {
    }
}