<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsConsolidationsTablesTable extends Migration
{
    public function up(): void
    {
        Schema::create('assets_consolidations_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('wrap_fee', 5, 4)->nullable();
            $table->integer('member_id');
            $table->timestamps();
        });
        Schema::table('assets_consolidations', function (Blueprint $table) {
            $table->renameColumn('table', 'table_id');
        });
    }

    public function down(): void
    {
        Schema::drop('assets_consolidations_tables');
    }
}
