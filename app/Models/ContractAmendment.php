<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractAmendment extends Model
{
    protected $fillable = [
        'contract_id',
        'amendment_number',
        'new_expiry_date',
        'document_path',
        'notes',
    ];

    protected $casts = [
        'new_expiry_date' => 'date',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}