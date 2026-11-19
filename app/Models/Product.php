<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $subtitle
 * @property string $category Lifestyle, Performance, Women
 * @property string|null $description
 * @property int $price
 * @property int $retail_price
 * @property int $discounted_price
 * @property string|null $tag
 * @property string $badge_color
 * @property string $image
 * @property string|null $shopee_url
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class Product extends Model
{
    use HasFactory;

    /**
     * Supported static categories
     *
     * @var array<int, string>
     */
    public const CATEGORIES = [
        'Lifestyle',
        'Performance',
        'Women',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'category',
        'description',
        'price',
        'retail_price',
        'discounted_price',
        'tag',
        'badge_color',
        'image',
        'shopee_url',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'retail_price' => 'integer',
            'discounted_price' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Ensure slug is generated if empty
     */
    protected static function booted(): void
    {
        self::saving(function (Product $product): void {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if ($product->discounted_price <= 0 && $product->retail_price > 0) {
                $product->discounted_price = (int) round($product->retail_price * 0.9);
            }
            if ($product->price <= 0 && $product->retail_price > 0) {
                $product->price = $product->retail_price;
            }
        });
    }

    /**
     * Format currency display
     */
    public function formattedPrice(): string
    {
        return 'Rp '.number_format($this->retail_price, 0, ',', '.');
    }

    /**
     * Format discounted currency display
     */
    public function formattedDiscountedPrice(): string
    {
        return 'Rp '.number_format($this->discounted_price, 0, ',', '.');
    }
}
