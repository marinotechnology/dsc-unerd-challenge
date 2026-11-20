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
        Schema::table('challenge_results', function (Blueprint $table) {
            $table->boolean('is_massaged')->default(false)->after('completion_status');
            $table->timestamp('massaged_at')->nullable()->after('is_massaged');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('challenge_results', function (Blueprint $table) {
            $table->dropColumn(['is_massaged', 'massaged_at']);
        });
    }
};
