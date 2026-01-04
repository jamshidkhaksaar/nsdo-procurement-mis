<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Asset extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'project_id',
        'asset_tag',
        'name',
        'description',
        'quantity',
        'condition',
        'location_province',
        'location_department',
        'handed_over_to',
        'handed_over_by',
        'photo_path',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(AssetDocument::class);
    }
}