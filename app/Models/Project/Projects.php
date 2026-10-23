<?php

namespace App\Models\Project;

use App\Models\Engineering\PriceList\PriceList;
use App\Models\ProjectControl\Boq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $project_name
 * @property string|null $project_code
 * @property string|null $project_number
 * @property string $category
 * @property numeric|null $budget
 * @property string $area
 * @property string $client
 * @property string $start_date
 * @property string $end_date
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereBudget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereProjectCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereProjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereProjectNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereUpdatedAt($value)
 * @property int $isMultipleArea
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Boq> $boqs
 * @property-read int|null $boqs_count
 * @method static \Database\Factories\Project\ProjectsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Projects whereIsMultipleArea($value)
 * @mixin \Eloquent
 */
class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $fillable = [
        'price_list_id',
        'project_name',
        'project_code',
        'project_number',
        'category',
        'area',
        'start_date',
        'end_date',
        'budget',
        'status',
        'isMultipleArea'
    ];

    public function boqs(): HasMany
    {
        return $this->hasMany(Boq::class, 'project_id', 'id');
    }

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class, 'price_list_id', 'id');
    }
}
