<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesforceExportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('salesforce_exports', function (Blueprint $table) {
            $table->id();
            $table->integer('object_id');
            $table->string('object_class');
            $table->string('action');
            $table->string('salesforce_id')->nullable();
            $table->timestamps();
        });
        Schema::table('salesforce_accounts', function (Blueprint $table) {
            $table->string('salesforce_id')->nullable()->change();
        });
        Schema::table('salesforce_child_opportunities', function (Blueprint $table) {
            $table->string('salesforce_id')->nullable()->change();
        });
        Schema::table('salesforce_contacts', function (Blueprint $table) {
            $table->string('salesforce_id')->nullable()->change();
        });
        Schema::table('salesforce_opportunities', function (Blueprint $table) {
            $table->string('salesforce_id')->nullable()->change();
            $table->string('stage');
            $table->string('investment_size')->nullable();
            $table->timestamp('close_date');
        });
    }

    public function down(): void
    {
    }
}
