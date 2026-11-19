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
        // 1. Communities Table
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('city')->default('Jakarta');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. Challenges Table
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('challenge_type'); // RUN, STEP, ON_MY_FEET
            $table->integer('distance_meter')->default(500);
            $table->string('location')->default('Gelora Bung Karno, Jakarta');
            $table->date('event_date')->nullable();
            $table->string('status')->default('ACTIVE'); // ACTIVE, COMING_SOON
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Participants Table
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('participant_id')->unique(); // e.g. UMS-0001
            $table->string('full_name');
            $table->string('display_name');
            $table->string('whatsapp');
            $table->string('email');
            $table->integer('shoe_size'); // EU 38 - 45
            $table->string('participant_category'); // Umum, Komunitas, Pekerja
            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->string('product_interest')->nullable(); // Performance, Lifestyle, Belum Menentukan
            $table->boolean('marketing_consent')->default(false);
            $table->boolean('terms_consent')->default(true);
            $table->string('acquisition_source')->nullable()->default('QR_GBK');
            $table->softDeletes();
            $table->timestamps();
        });

        // 4. Challenge Results Table
        Schema::create('challenge_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('participants')->cascadeOnDelete();
            $table->foreignId('challenge_id')->constrained('challenges')->cascadeOnDelete();
            $table->string('checkin_status')->default('REGISTERED'); // REGISTERED, CHECKED_IN, DNS, DNF
            $table->string('completion_status')->default('PENDING'); // PENDING, COMPLETED
            $table->decimal('recorded_time_seconds', 8, 2)->nullable();
            $table->decimal('verified_time_seconds', 8, 2)->nullable();
            $table->string('verification_status')->default('PENDING'); // PENDING, VERIFIED, REJECTED
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();
        });

        // 5. Activity Events Tracking Table
        Schema::create('activity_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type'); // campaign_view, registration_completed, leaderboard_view, product_click
            $table->foreignId('participant_id')->nullable()->constrained('participants')->nullOnDelete();
            $table->string('acquisition_source')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_events');
        Schema::dropIfExists('challenge_results');
        Schema::dropIfExists('participants');
        Schema::dropIfExists('challenges');
        Schema::dropIfExists('communities');
    }
};
