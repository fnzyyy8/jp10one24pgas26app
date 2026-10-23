<?php

namespace App\Models\Engineering\PriceList;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceList extends Model
{
    protected $table = 'price_lists';
    protected $fillable = [
        'name',
        'number',
        'client'
    ];

    public function unitPrices(): HasMany
    {
        return $this->hasMany(UnitPrice::class, 'price_list_id');
    }
}
