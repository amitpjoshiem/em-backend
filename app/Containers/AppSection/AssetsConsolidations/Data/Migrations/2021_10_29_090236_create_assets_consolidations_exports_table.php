<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsConsolidationsExportsTable extends Migration
{
    public function up(): void
    {
        Schema::create('assets_consolidations_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('member_id');
            $table->foreignId('media_id')->nullable();
            $table->string('type');
            $table->string('filename');
            $table->string('status');
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets_consolidations_exports');
    }
}
