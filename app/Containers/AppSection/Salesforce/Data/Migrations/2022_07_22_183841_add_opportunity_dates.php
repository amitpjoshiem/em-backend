<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpportunityDates extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_opportunities', function (Blueprint $table) {
            $table->timestamp('date_of_1st')->nullable();
            $table->timestamp('date_of_2nd')->nullable();
            $table->timestamp('date_of_3rd')->nullable();
            $table->string('result_1st_appt')->nullable();
            $table->string('result_2nd_appt')->nullable();
            $table->string('result_3rd_appt')->nullable();
            $table->string('status_1st_appt')->nullable();
            $table->string('status_2nd_appt')->nullable();
            $table->string('status_3rd_appt')->nullable();
        });
    }

    public function down(): void
    {
    }
}
