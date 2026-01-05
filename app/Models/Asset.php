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
        'asset_type_id',
        'asset_tag',
        'name',
        'description',
        'quantity',
        'condition',
        'province_id',
        'department_id',
        'staff_id',
        'room_number',
        'location_province',
        'location_department',
        'handed_over_to',
        'handed_over_by',
        'photo_path',
        'created_by',
        'updated_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(AssetDocument::class);
    }
}