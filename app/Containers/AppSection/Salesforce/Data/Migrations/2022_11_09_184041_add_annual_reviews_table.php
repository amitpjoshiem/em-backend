<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnnualReviewsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_annual_reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('member_id');
            $table->bigInteger('account_id');
            $table->string('salesforce_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->date('review_date')->nullable();
            $table->decimal('amount', 10, 3)->nullable();
            $table->string('type')->nullable();
            $table->string('new_money')->nullable();
            $table->string('notes')->nullable();
        });
    }

    public function down(): void
    {
    }
}
