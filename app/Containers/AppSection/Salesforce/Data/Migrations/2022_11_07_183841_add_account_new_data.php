<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountNewData extends Migration
{
    public function up(): void
    {
        Schema::table('salesforce_accounts', function (Blueprint $table) {
            $table->boolean('do_not_mail')->nullable(); //Do_Not_Mail__c
            $table->string('category')->nullable(); //Category__c
            $table->date('client_start_date')->nullable(); //Client_Start_Date__c
            $table->date('client_ar_date')->nullable(); //Client_AR_Date__c
            $table->boolean('p_c_client')->nullable(); //P_C_Client__c
            $table->boolean('tax_conversion_client')->nullable(); //Tax_Conversion_Client__c
            $table->boolean('platinum_club_client')->nullable(); //Platinum_Club_Client__c
        });
    }

    public function down(): void
    {
    }
}
