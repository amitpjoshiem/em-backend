<?php

declare(strict_types=1);

use App\Containers\AppSection\Client\Models\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewCollectionsToClient extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('medicare_details')->default(Client::NOT_COMPLETED_STEP);
            $table->string('property_casualty')->default(Client::NOT_COMPLETED_STEP);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('medicare_details');
            $table->dropColumn('property_casualty');
        });
    }
}
