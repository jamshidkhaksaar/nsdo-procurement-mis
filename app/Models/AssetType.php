<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $fillable = ['name', 'category', 'description'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}