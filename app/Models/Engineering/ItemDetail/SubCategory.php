<?php

namespace App\Models\Engineering\ItemDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Engineering\ItemDetail\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\ItemDetail> $itemDetails
 * @property-read int|null $item_details_count
 * @method static \Database\Factories\ProjectControl\ItemDetail\SubCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';
    protected $fillable = [
        'category_id',
        'name',
        'sort_order'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function itemDetails()
    {
        return $this->hasMany(ItemDetail::class)
            ->orderBy('sort_order');
    }
}
