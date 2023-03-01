<?php

declare(strict_types=1);

use App\Containers\AppSection\Member\UI\CLI\Commands\MigrateMemberContactsName;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMembersContactName extends Migration
{
    public function up(): void
    {
        Schema::table('member_contacts', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });

        Artisan::call(MigrateMemberContactsName::class);

        Schema::table('member_contacts', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
    }
}
