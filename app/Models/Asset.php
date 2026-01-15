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
        'supplier_id',
        'asset_tag',
        'serial_number',
        'name',
        'description',
        'quantity',
        'useful_life_years',
        'purchase_date',
        'delivery_date',
        'gr_date',
        'condition',
        'unit_price',
        'currency',
        'total_amount',
        'province_id',
        'department_id',
        'staff_id',
        'room_number',
        'location_province',
        'location_department',
        'handed_over_to',
        'handed_over_by',
        'handover_date',
        'created_by',
        'updated_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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

    protected $casts = [
        'handover_date' => 'date',
        'purchase_date' => 'date',
        'delivery_date' => 'date',
        'gr_date' => 'date',
        'useful_life_years' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function getRemainingLifeAttribute()
    {
        if (!$this->purchase_date || !$this->useful_life_years) {
            return 'N/A';
        }

        // useful_life_years is a decimal, convert to months for precision or just add years
        $years = (int) $this->useful_life_years;
        $months = (int) (($this->useful_life_years - $years) * 12);

        $expiryDate = $this->purchase_date->copy()->addYears($years)->addMonths($months);
        
        if ($expiryDate->isPast()) {
            return 'Expired ' . $expiryDate->diffForHumans();
        }

        return $expiryDate->diffForHumans(null, true) . ' left';
    }
}