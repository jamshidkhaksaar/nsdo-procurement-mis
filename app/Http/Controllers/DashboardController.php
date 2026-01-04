<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Contract;
use App\Models\Project;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Core Counts
        $totalProjects = Project::count();
        $totalAssets = Asset::count();
        $totalContracts = Contract::count();

        // 2. Contract Statuses
        $today = Carbon::today();
        $contractsExpired = Contract::whereDate('expiry_date', '<', $today)->count();
        
        $contractsExpiringSoon = Contract::whereDate('expiry_date', '>=', $today)
            ->whereDate('expiry_date', '<=', $today->copy()->addDays(30))
            ->count();
        
        $contractsActive = Contract::whereDate('expiry_date', '>', $today->copy()->addDays(30))->count();

        // 3. Asset Conditions Breakdown (for a potential chart or list)
        $assetConditions = Asset::selectRaw('`condition`, count(*) as count')
            ->groupBy('condition')
            ->pluck('count', 'condition');

        // 5. Expiring Contracts List (for the widget)
        $expiringContractsList = Contract::whereDate('expiry_date', '>=', $today)
            ->whereDate('expiry_date', '<=', $today->copy()->addDays(30))
            ->orderBy('expiry_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProjects',
            'totalAssets',
            'totalContracts',
            'contractsExpired',
            'contractsExpiringSoon',
            'contractsActive',
            'assetConditions',
            'expiringContractsList'
        ));
    }
}