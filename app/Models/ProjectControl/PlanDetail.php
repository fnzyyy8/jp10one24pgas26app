<?php

namespace App\Models\ProjectControl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $plan_id
 * @property string $plan_date
 * @property numeric $plan_volume
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProjectControl\Plans $plan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail wherePlanDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail wherePlanVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlanDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PlanDetail extends Model
{
    protected $table = 'plan_details';
    protected $fillable = [
        'plan_id',
        'plan_date',
        'volume',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
