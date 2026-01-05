<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $fillable = ['name', 'useful_life_years', 'depreciation_method', 'description'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}