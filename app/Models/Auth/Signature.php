<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Signature extends Model
{
    protected $table = 'signature_tables';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'signature_path',
        'original_filename',
        'mime_type',
        'file_size',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'is_default' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
