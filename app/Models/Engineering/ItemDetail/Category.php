<?php

namespace App\Models\Engineering\ItemDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $section_id
 * @property string $name
 * @property int $sort_order
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\ItemDetail> $itemDetails
 * @property-read int|null $item_details_count
 * @property-read \App\Models\Engineering\ItemDetail\Section $section
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Engineering\ItemDetail\SubCategory> $subCategories
 * @property-read int|null $sub_categories_count
 * @method static \Database\Factories\ProjectControl\ItemDetail\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'section_id',
        'name',
        'sort_order'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class)
            ->orderBy('sort_order');
    }

    public function itemDetails() : HasMany
    {
        return $this->hasMany(ItemDetail::class)
            ->orderBy('sort_order');
    }
}
