<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreAccountNewData extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_accounts', function (Blueprint $table) {
            $table->boolean('medicare_client')->nullable(); //Medicare_Client__c
            $table->decimal('household_value', 10, 3)->nullable(); //Household_Value__c
            $table->string('total_investment_size', )->nullable(); //Total_Investment_Size__c
            $table->string('political_stance', )->nullable(); //Political_Stance__c
            $table->decimal('client_average_age', 10, 3)->nullable(); //Client_Average_Age__c
            $table->string('primary_contact')->nullable(); //Primary_Contact__c
            $table->boolean('military_veteran')->nullable(); //Military_Veteran__c
            $table->boolean('homework_completed')->nullable(); //Homework_Completed__c
        });
    }

    public function down(): void
    {
    }
}
