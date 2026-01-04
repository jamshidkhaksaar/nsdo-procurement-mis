<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = ['name', 'project_code'];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}