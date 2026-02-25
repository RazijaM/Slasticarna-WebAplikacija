<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('restaurant_locations', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('lng');
            $table->decimal('delivery_radius_km', 8, 2)->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_locations', function (Blueprint $table) {
            $table->dropColumn(['phone', 'delivery_radius_km']);
        });
    }
};
