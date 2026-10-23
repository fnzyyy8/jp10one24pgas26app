<?php

namespace App\Models\ProjectControl;

use App\Models\Engineering\PriceList\UnitPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $table = 'plans';
    protected $fillable = [
        'boq_id',
        'unit_price_id',
        'volume'
    ];

    public function boq(): BelongsTo
    {
        return $this->belongsTo(Boq::class, 'boq_id');
    }

    public function unitPrice(): BelongsTo
    {
        return $this->belongsTo(UnitPrice::class, 'unit_price_id');
    }

    public function planDetails(): HasMany
    {
        return $this->hasMany(PlanDetail::class, 'plan_id');
    }
}
