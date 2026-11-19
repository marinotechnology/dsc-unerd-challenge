<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->string('category')->default('Performance'); // Lifestyle, Performance, Women
            $table->text('description')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('retail_price')->default(0);
            $table->unsignedInteger('discounted_price')->default(0);
            $table->string('tag')->nullable();
            $table->string('badge_color')->default('volt');
            $table->string('image')->default('images/products/unerd-beat-flow-performance.jpg');
            $table->text('shopee_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed 3 existing products
        DB::table('products')->insert([
            [
                'name' => 'UNERD Beat Flow Performance',
                'slug' => 'unerd-beat-flow-performance',
                'subtitle' => 'Nusantara Edition - Road & Sprint 1 KM',
                'category' => 'Performance',
                'description' => 'Bantalan responsif dengan stabilitas pijakan optimal untuk akselerasi sprint 1 KM maupun long run di lintasan aspal.',
                'price' => 469000,
                'retail_price' => 469000,
                'discounted_price' => 422100,
                'tag' => 'PERFORMANCE',
                'badge_color' => 'volt',
                'image' => 'images/products/unerd-beat-flow-performance.jpg',
                'shopee_url' => 'https://shopee.co.id/UNERD-PERFORMANCE-BEAT-FLOW-NUSANTARA-SEPATU-RUNNING-PRIA-WANITA-JOGJA-i.305818928.48571828579?extraParams=%7B%22display_model_id%22%3A303096235058%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-8259u-mvmw40mkmz9h4a',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UNERD Women Swift Move',
                'slug' => 'unerd-women-swift-move',
                'subtitle' => 'Radiant Lotus - Sport Casual & Active Style',
                'category' => 'Women',
                'description' => 'Siluet dinamis dan ringan khusus rancangan anatomi wanita, fleksibel untuk pemanasan lari santai hingga mobilitas harian.',
                'price' => 459000,
                'retail_price' => 459000,
                'discounted_price' => 413100,
                'tag' => 'WOMEN MOVE',
                'badge_color' => 'volt',
                'image' => 'images/products/unerd-women-swift-move.jpg',
                'shopee_url' => 'https://shopee.co.id/-UNERD-WOMEN-SWIFT-MOVE-Sepatu-Sport-Casual-Sport-Style-Wanita-Dewasa-Radiant-Lotus-i.305818928.45956395884?extraParams=%7B%22display_model_id%22%3A390575836112%2C%22model_selection_logic%22%3A3%7D&image_ids=id-11134207-8224y-ml3dar736a6e9b',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UNERD Thera Reco Lifestyle',
                'slug' => 'unerd-thera-reco-lifestyle',
                'subtitle' => 'Sandal Sepatu Recovery & Casual Comfort',
                'category' => 'Lifestyle',
                'description' => 'Footwear pemulihan pasca lari dengan footbed ergonomis empuk yang merelaksasi telapak kaki setelah latihan lari intensif.',
                'price' => 299000,
                'retail_price' => 299000,
                'discounted_price' => 269100,
                'tag' => 'RECOVERY & LIFESTYLE',
                'badge_color' => 'cobalt',
                'image' => 'images/products/unerd-thera-reco-lifestyle.jpg',
                'shopee_url' => 'https://shopee.co.id/UNERD-THERA-RECO-Sandal-Sepatu-Pria-Wanita-i.305818928.56018366974?extraParams=%7B%22display_model_id%22%3A366544255922%2C%22model_selection_logic%22%3A3%7D&image_ids=sg-11134201-82599-mthzt0pq8yrl86',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
