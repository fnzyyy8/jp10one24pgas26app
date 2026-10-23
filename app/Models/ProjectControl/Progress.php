<?php

namespace App\Models\ProjectControl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progress extends Model
{
    protected $table = 'progress';
    protected $fillable = [
        'plan_id',
        'date',
        'volume',
    ];

    public function plan(): belongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
