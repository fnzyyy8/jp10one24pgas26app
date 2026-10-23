<?php

namespace App\Models\Engineering\ItemDetail;

use App\Models\Engineering\PriceList\UnitPrice;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $section_id
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property string $name
 * @property string $unit
 * @property int $sort_order
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \App\Models\Engineering\ItemDetail\Category|null $category
 * @property-read \App\Models\Engineering\ItemDetail\Section $section
 * @property-read SubCategory|null $subCategory
 * @method static \Database\Factories\ProjectControl\ItemDetail\ItemDetailFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereSubCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ItemDetail extends Model
{

    protected $table = 'item_details';
    protected $fillable = [
        'section_id',
        'category_id',
        'sub_category_id',
        'scope',
        'name',
        'unit',
        'sort_order'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function unitPrices(): HasMany
    {
        return $this->hasMany(UnitPrice::class, 'item_detail_id');
    }
}
