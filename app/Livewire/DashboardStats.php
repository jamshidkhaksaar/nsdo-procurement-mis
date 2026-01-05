<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Asset;
use App\Models\Project;
use App\Models\Contract;
use Carbon\Carbon;

class DashboardStats extends Component
{
    #[On('echo:assets,AssetCreated')]
    #[On('echo:assets,AssetDeleted')]
    #[On('echo:contracts,ContractCreated')]
    #[On('echo:contracts,ContractDeleted')]
    public function refreshStats()
    {
        // Re-renders automatically
    }

    public function render()
    {
        $now = Carbon::now();
        $thirtyDaysFromNow = Carbon::now()->addDays(30);

        return view('livewire.dashboard-stats', [
            'totalAssets' => Asset::count(),
            'totalProjects' => Project::count(),
            'contractsActive' => Contract::whereDate('expiry_date', '>', $now)->count(),
            'contractsExpiringSoon' => Contract::whereDate('expiry_date', '>=', $now)
                ->whereDate('expiry_date', '<=', $thirtyDaysFromNow)
                ->count(),
        ]);
    }
}