<?php

namespace App\Models\Engineering\ItemDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\ItemDetail> $itemDetails
 * @property-read int|null $item_details_count
 * @method static \Database\Factories\ProjectControl\ItemDetail\SectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';
    protected $fillable = [
        'name',
        'sort_order'
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class)
            ->orderBy('sort_order');
    }

    public function itemDetails(): HasMany
    {
        return $this->hasMany(ItemDetail::class)
            ->orderBy('sort_order');
    }
}
