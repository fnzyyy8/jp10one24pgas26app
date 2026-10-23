<?php

namespace App\Models\ManPower;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerCertificate extends Model
{
    use HasFactory;

    protected $table = 'worker_certificates';

    protected $fillable = [
        'worker_id',
        'certificate_name',
        'expired_date',
        'document_path',
    ];

    protected function casts(): array
    {
        return [
            'expired_date' => 'date',
        ];
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
