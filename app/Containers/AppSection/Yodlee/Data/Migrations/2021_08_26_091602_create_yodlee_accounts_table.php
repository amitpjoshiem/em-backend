<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYodleeAccountsTable extends Migration
{
    public function up(): void
    {
        Schema::create('yodlee_accounts', function (Blueprint $table) {
            $table->integer('yodlee_id');
            $table->foreignId('member_id')->index();
            $table->foreignId('user_id');
            $table->string('account_name');
            $table->string('account_status');
            $table->decimal('balance', 10, 3);
            $table->boolean('include_int_net_worth');
            $table->integer('provider_id');
            $table->string('provider_name');
            $table->timestamp('sync_at');
            $table->timestamps();
            $table->primary(['yodlee_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('yodlee_accounts');
    }
}
