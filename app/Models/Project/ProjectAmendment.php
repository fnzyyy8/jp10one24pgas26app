<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property string $amendment_date
 * @property string $amendment_description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereAmendmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereAmendmentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectAmendment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectAmendment extends Model
{
    protected $table = 'project_amendments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'project_id',
        'amendment_date',
        'amendment_description',
    ];
}
