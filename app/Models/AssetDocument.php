<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetDocument extends Model
{
    protected $fillable = ['asset_id', 'type', 'file_path', 'uploaded_at'];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}