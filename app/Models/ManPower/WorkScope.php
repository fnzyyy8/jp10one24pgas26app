<?php

namespace App\Models\ManPower;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WorkScope extends Model
{
    use HasFactory;

    protected $table = 'work_scopes';

    protected $fillable = [
        'name',
        'work_status'
    ];

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'worker_work_scope', 'work_scope_id', 'worker_id')->withTimestamps();

    }
}
