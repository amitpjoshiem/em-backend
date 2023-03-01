<?php

declare(strict_types=1);

use App\Containers\AppSection\Client\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('member_id');
            $table->string('completed_financial_fact_finder')->default(Client::NOT_COMPLETED_STEP);
            $table->string('investment_and_retirement_accounts')->default(Client::NOT_COMPLETED_STEP);
            $table->string('life_insurance_annuity_and_long_terms_care_policies')->default(Client::NOT_COMPLETED_STEP);
            $table->string('social_security_information')->default(Client::NOT_COMPLETED_STEP);
            $table->string('list_of_stock_certificates_or_bonds')->default(Client::NOT_COMPLETED_STEP);
            $table->boolean('terms_and_conditions')->default(false);
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
}
