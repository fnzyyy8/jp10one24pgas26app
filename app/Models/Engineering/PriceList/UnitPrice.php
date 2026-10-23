<?php

namespace App\Models\Engineering\PriceList;

use App\Models\Engineering\ItemDetail\ItemDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UnitPrice extends Model
{
    protected $table = 'unit_prices';
    protected $fillable = [
        'price_list_id',
        'item_detail_id',
        'isFreeIssueMaterial'
    ];

    protected $casts = [
        'isFreeIssueMaterial' => 'boolean'
    ];

    public function recordedPrices(): HasMany
    {
        return $this->hasMany(RecordPrice::class, 'unit_price_id');
    }

    public function latestRecordPrice(): HasOne
    {
        return $this->hasOne(RecordPrice::class, 'unit_price_id')->latest('date');
    }

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class, 'price_list_id');
    }

    public function itemDetail(): BelongsTo
    {
        return $this->belongsTo(ItemDetail::class, 'item_detail_id');
    }
}
