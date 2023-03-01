<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientReportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('client_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id');
            $table->integer('contract_number');
            $table->string('carrier');
            $table->decimal('current_value', 10, 3);
            $table->decimal('surrender_value', 10, 3);
            $table->decimal('origination_value', 10, 3);
            $table->timestamp('origination_date');
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_reports');
    }
}
