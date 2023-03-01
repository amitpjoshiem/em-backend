<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('email')->unique();
            $table->string('username', 100)->unique();

            $table->string('password');

            $table->timestamp('email_verified_at')
                ->nullable()
                ->comment('Email confirmed date');

            $table->boolean('is_client')
                ->default(true)
                ->comment('Indicates it\'s admin or it\'s client');

            $table->string('data_source', 32)
                ->nullable()
                ->comment('Enum of sources ("UserUploaded", "Bloomberg", "Morningstar") to fetch ticket financial data');

            $table->rememberToken()->comment('OAuth2 token');

            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
