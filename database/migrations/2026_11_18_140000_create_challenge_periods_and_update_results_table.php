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
        // 1. Challenge Periods Table
        Schema::create('challenge_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained('challenges')->cascadeOnDelete();
            $table->string('name');
            $table->string('period_code')->unique();
            $table->date('event_date')->nullable();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_open_for_registration')->default(true);
            $table->json('prizes_config')->nullable();
            $table->timestamps();
        });

        // 2. Add challenge_period_id, user_id, and runner_status to challenge_results
        Schema::table('challenge_results', function (Blueprint $table) {
            $table->foreignId('challenge_period_id')->nullable()->after('challenge_id')->constrained('challenge_periods')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->after('participant_id')->constrained('users')->nullOnDelete();
            $table->string('runner_status')->default('ACTIVE')->after('checkin_status'); // ACTIVE (sedang lari), FINISHED (selesai lari)
            $table->unsignedInteger('rank_in_period')->nullable()->after('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenge_results', function (Blueprint $table) {
            $table->dropForeign(['challenge_period_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['challenge_period_id', 'user_id', 'runner_status', 'rank_in_period']);
        });

        Schema::dropIfExists('challenge_periods');
    }
};
