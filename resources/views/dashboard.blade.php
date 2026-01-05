<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid (Livewire Real-time) -->
        <livewire:dashboard-stats />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column: Asset Breakdown & Quick Actions -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('assets.create') }}" class="flex items-center justify-center p-4 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Add Asset
                        </a>
                        <a href="{{ route('contracts.create') }}" class="flex items-center justify-center p-4 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:text-lg">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            New Contract
                        </a>
                    </div>
                </div>

                <!-- Asset Condition Breakdown -->
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Asset Conditions</h3>
                    <div class="space-y-4">
                        @foreach($assetConditions as $condition => $count)
                            <div>
                                <div class="flex justify-between text-sm font-medium text-gray-600 mb-1">
                                    <span>{{ $condition }}</span>
                                    <span>{{ $count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full 
                                        @if($condition == 'New') bg-green-500 
                                        @elseif($condition == 'Good') bg-blue-500 
                                        @elseif($condition == 'Fair') bg-yellow-400 
                                        @elseif($condition == 'Poor') bg-orange-500 
                                        @else bg-red-600 @endif" 
                                        style="width: {{ ($count / ($totalAssets > 0 ? $totalAssets : 1)) * 100 }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($assetConditions->isEmpty())
                            <p class="text-sm text-gray-500 italic">No assets registered yet.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Alerts & Activity -->
            <div class="space-y-6">
                <!-- Expiring Contracts Alert -->
                @if($contractsExpiringSoon > 0)
                    <div class="bg-white shadow sm:rounded-lg overflow-hidden border-t-4 border-yellow-500">
                        <div class="px-4 py-5 sm:px-6 bg-yellow-50 flex justify-between items-center">
                            <h3 class="text-lg leading-6 font-medium text-yellow-800">Expiring Soon (Next 30 Days)</h3>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @foreach($expiringContractsList as $contract)
                                <li class="p-4 hover:bg-gray-50 transition">
                                    <a href="{{ route('contracts.show', $contract) }}" class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $contract->vendor_name }}</p>
                                            <p class="text-xs text-gray-500">Ref: {{ $contract->contract_reference }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-red-600">{{ $contract->expiry_date->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $contract->expiry_date->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bg-white shadow sm:rounded-lg p-6 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No expiring contracts</h3>
                        <p class="mt-1 text-sm text-gray-500">All contracts are up to date.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
