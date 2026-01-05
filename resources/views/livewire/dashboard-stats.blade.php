<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" wire:poll.5s>
    <!-- Total Assets -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-indigo-500 hover:shadow-md transition">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-500">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Assets</p>
                {{-- Animation triggers when wire:key changes --}}
                <div wire:key="total-assets-{{ $totalAssets }}" 
                     x-data="{ count: {{ $totalAssets }} }" 
                     x-init="$watch('count', value => { $el.classList.add('scale-110', 'text-indigo-600'); setTimeout(() => $el.classList.remove('scale-110', 'text-indigo-600'), 1000) })"
                     class="text-2xl font-bold text-gray-900 transition-all duration-500 transform">
                    {{ number_format($totalAssets) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Total Projects -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Projects</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProjects) }}</p>
            </div>
        </div>
    </div>

    <!-- Active Contracts -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-green-500 transition">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-500">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Active Contracts</p>
                <div wire:key="active-contracts-{{ $contractsActive }}" class="text-2xl font-bold text-gray-900">
                    {{ number_format($contractsActive) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Expiring Contracts -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 border-l-4 border-yellow-500 transition">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Expiring Soon</p>
                <div wire:key="expiring-soon-{{ $contractsExpiringSoon }}" class="text-2xl font-bold text-gray-900">
                    {{ number_format($contractsExpiringSoon) }}
                </div>
            </div>
        </div>
    </div>
</div>
