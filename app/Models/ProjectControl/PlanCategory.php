<?php

namespace App\Models\ProjectControl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanCategory extends Model
{
    protected $table = 'plan_categories';
    protected $fillable = [
        'name',
        'scope'
    ];

    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
}
