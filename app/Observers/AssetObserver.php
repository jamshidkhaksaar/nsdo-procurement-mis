<?php

namespace App\Observers;

use App\Models\Asset;
use App\Events\AssetCreated;
use App\Events\AssetDeleted;
use Illuminate\Support\Facades\Auth;

class AssetObserver
{
    public function creating(Asset $asset): void
    {
        if (Auth::check()) {
            $asset->created_by = Auth::id();
            $asset->updated_by = Auth::id();
        }
    }

    public function created(Asset $asset): void
    {
        AssetCreated::dispatch($asset);
    }

    public function updating(Asset $asset): void
    {
        if (Auth::check()) {
            $asset->updated_by = Auth::id();
        }
    }

    public function deleted(Asset $asset): void
    {
        AssetDeleted::dispatch($asset->id);
    }
}