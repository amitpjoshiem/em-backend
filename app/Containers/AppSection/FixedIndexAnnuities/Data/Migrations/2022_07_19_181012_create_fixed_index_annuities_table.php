<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedIndexAnnuitiesTable extends Migration
{
    public function up(): void
    {
        Schema::create('fixed_index_annuities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('insurance_provider');
            $table->timestamp('advisor_signed')->nullable();
            $table->timestamp('client_signed')->nullable();
            $table->string('tax_qualification');
            $table->string('agent_rep_code')->nullable();
            $table->integer('license_number')->nullable();
            $table->bigInteger('member_id');
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_index_annuities');
    }
}
