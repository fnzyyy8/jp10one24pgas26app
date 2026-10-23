<?php

namespace App\Models\ManPower;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{
    use HasFactory;

    protected $table = 'workers';

    protected $fillable = [
        'id_card_number',
        'name',
        'based',
        'phone_number',
        'email',
        'photo',
        'work_status',
        'last_follow_up',
    ];

    public function workScopes(): BelongsToMany
    {
        return $this->belongsToMany(
            WorkScope::class,
            'worker_work_scope',
            'worker_id',
            'work_scope_id'
        )->withTimestamps();
    }


    public function certificates(): HasMany
    {
        return $this->hasMany(WorkerCertificate::class);
    }

}
