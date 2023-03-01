<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientReportsDocClientReportTable extends Migration
{
    public function up(): void
    {
        Schema::create('client_reports_doc_client_report', function (Blueprint $table) {
            $table->id();
            $table->integer('client_reports_doc_id');
            $table->integer('client_report_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_reports_doc_client_report');
    }
}
