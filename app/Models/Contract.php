<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;

class Contract extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'vendor_name',
        'contract_reference',
        'signed_date',
        'expiry_date',
    ];

    protected $casts = [
        'signed_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function amendments(): HasMany
    {
        return $this->hasMany(ContractAmendment::class);
    }

    public function getStatusAttribute(): string
    {
        $today = Carbon::today();
        
        if ($this->expiry_date->isPast()) {
            return 'Expired';
        }

        if ($this->expiry_date->diffInDays($today) <= 30) {
            return 'Expiring Soon';
        }

        return 'Active';
    }
}