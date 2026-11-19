<?php

declare(strict_types=1);

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
        Schema::table('challenge_periods', function (Blueprint $table) {
            $table->string('location')->nullable()->default('Gelora Bung Karno, Jakarta')->after('name');
            $table->unsignedInteger('distance_meter')->default(3000)->after('location');
            $table->unsignedInteger('duration_minutes')->nullable()->default(60)->after('distance_meter');
            $table->string('banner_image')->nullable()->after('duration_minutes');
            $table->timestamp('end_time')->nullable()->after('event_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenge_periods', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'distance_meter',
                'duration_minutes',
                'banner_image',
                'end_time',
            ]);
        });
    }
};
