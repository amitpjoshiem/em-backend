<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceChildOpportunitiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_child_opportunities', function (Blueprint $table) {
            $table->id();
            $table->integer('member_id')->index();
            $table->string('salesforce_id');
            $table->string('stage');
            $table->decimal('amount', 10, 3);
            $table->foreignId('salesforce_opportunity_id');
            $table->string('name');
            $table->string('type');
            $table->timestamp('close_date');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salesforce_child_opportunities');
    }
}
