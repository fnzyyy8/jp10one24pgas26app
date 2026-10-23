<?php

namespace App\Models\ProjectControl;

use App\Models\Project\Projects;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $project_id
 * @property string $detailed_area
 * @property int $isMultipleCustomer
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectControl\Plans> $plans
 * @property-read int|null $plans_count
 * @property-read Projects $project
 * @method static \Database\Factories\ProjectControl\BoqFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereDetailedArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereIsMultipleCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Boq whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Boq extends Model
{

    use HasFactory;

    protected $table = 'boqs';
    protected $fillable = ['project_id', 'detailed_area', 'isMultipleCustomer'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');

    }

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class, 'boq_id', 'id');
    }
}
