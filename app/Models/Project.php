<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}