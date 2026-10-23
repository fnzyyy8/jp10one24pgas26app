<?php

namespace App\Models\Engineering\PriceList;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecordPrice extends Model
{
    protected $table = 'record_prices';
    protected $fillable = [
        'unit_price_id',
        'date',
        'price',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'float',
    ];

    public function unitPrice(): BelongsTo
    {
        return $this->belongsTo(UnitPrice::class, 'unit_price_id');
    }
}
